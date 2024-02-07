<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateCommissionBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update marketer commission balances';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating commission balances...');
        $marketer = User::where('role', 'marketer')->where('referred_by', $user_id)->get();
        //dd($marketer);
        foreach ($marketer as $row) {
            $orderCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Order Commission')->sum('amount');
            $workerCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Worker Signup')->sum('amount');
            $memberCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Membership Signup')->sum('amount');
            $customerCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Customer Signup')->sum('amount');
            //dd($orderCommission);
            $balance = Balance::where('user_id', $row->id)->sum('job_income');
            //dd($balance);
            $allMarketerIncome = $allMarketerIncome + $orderCommission + $workerCommission + $memberCommission + $customerCommission;
            
        }
        
        
        /*Marketer Commison Save*/
        $marketerAffCommison = $allMarketerIncome * get_static_option('marketer_commission_percent') / 100;
        
        if($allMarketerIncome >= get_static_option('marketer_monthly_income')){
            $marketer = User::where('referral_code', auth()->user()->id)->first();
            $MarketerAffiliate = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->count();
            //dd($MarketerAffiliate);
            if($MarketerAffiliate < 1){
                $affiliate_user = $marketer->affiliate_user;
                $affiliate_user->balance += $marketerAffCommison;
                $affiliate_user->save();

                //save bonus details
                $current_month = date("F");
                $current_year = date("Y");
                $affiliate_bonus = new AffiliateBonus;
                $affiliate_bonus->affiliate_user_id = $marketer->id;
                $affiliate_bonus->user_id = auth()->id();
                $affiliate_bonus->amount = $marketerAffCommison;
                $affiliate_bonus->bonus_purpose = "Marketer Commismion";
                $affiliate_bonus->month = $current_month;
                $affiliate_bonus->year = $current_year;
                $affiliate_bonus->save();
            }
        }
        
        $this->info('Commission balances updated successfully.');
    }
}
