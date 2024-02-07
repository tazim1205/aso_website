<?php

namespace App\Http\Controllers\Marketer;

use App\MarketerControllerAds;
use App\MarketerControllerNotice;
use App\CustomerGig;
use App\Http\Controllers\Controller;
use App\Job;
use App\AdminAds;
use App\AdminNotice;

use App\AffiliateBonus;
use App\AffiliateUser;
use Auth;
use App\WithdrawRequest;
use App\CustomerBid;
use App\WorkerBid;
use App\Balance;
use App\Payment;
use DateTime;
use App\StaticOption;
use App\Blog;
use App\Membership;

use App\User;
use App\WorkerService;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use CreateCustomerGigsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = WorkerServiceCategory::all();
        $adminNotice = MarketerControllerNotice::orderBy('id', 'desc')
            ->take(1)
            ->get();
        $adminAds = MarketerControllerAds::where('status', '1')
            ->get();
        /*
            $c_gigs =DB::table('customer_gigs')
                ->join('worker_and_services', function ($join) {
                    $join->on('customer_gigs.service_id', '=', 'worker_and_services.service_id')
                        ->where('worker_and_services.worker_id', '=', auth()->user()->id);
                })->get();
            dd($c_gigs);
            */


        $user_id = Auth::user()->id;
        $currentMonth = date("F");
        // total income 
        $totalIncome = AffiliateBonus::where('affiliate_user_id', $user_id)->sum('amount');
        // current month total income 
        $TotalCurrentMonthIncome = AffiliateBonus::where(
            ['affiliate_user_id' => $user_id],
            ['month' => $currentMonth]
        )->sum('amount');
        
        /*  Target Fillup Bonus Added  */
        
        $monthly_bonust_amount = get_static_option('monthly_bonust_amount');
        $monthly_income_for_target_filup = get_static_option('monthly_income_for_target_filup');
        // dd($monthly_income_for_target_filup);
        $affiliated_user = AffiliateBonus::where(
            ['affiliate_user_id' => $user_id],
            ['month' => $currentMonth],
            ['bonus_purpose', 'Target Filup']
        )->count();
        //dd($affiliated_user);
        $totalLoop = intval($TotalCurrentMonthIncome / $monthly_income_for_target_filup);
        //dd(intval($totalLoop));
        if($totalLoop > 1){
            $totalLoop = $totalLoop - $affiliated_user;
        }
        
        for($i = 0; $i < $totalLoop; $i++){
            $marketer = User::where('referral_code', auth()->user()->id)->first();
            //dd($marketer);
            if ($marketer != null) {
                $affiliate_user = $marketer->affiliate_user;
                if ($affiliate_user != null) {
                    $affiliate_user->balance += $monthly_bonust_amount;
                    $affiliate_user->save();

                    //save bonus details
                    $current_month = date("F");
                    $current_year = date("Y");
                    $affiliate_bonus = new AffiliateBonus;
                    $affiliate_bonus->affiliate_user_id = $marketer->id;
                    $affiliate_bonus->user_id = auth()->id();
                    $affiliate_bonus->amount = $monthly_bonust_amount;
                    $affiliate_bonus->bonus_purpose = "Target Filup";
                    $affiliate_bonus->month = $current_month;
                    $affiliate_bonus->year = $current_year;
                    $affiliate_bonus->save();
                }
            }
            
        }
        
        
        /* Target Fillup Bonus Added */
        
        
        // total withdraw
        $totalWidraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'complete')->sum('amount');
        // total withdraw pending
        $totalWidrawPainding = WithdrawRequest::where('user_id', $user_id)->where(['status' => 'pending'])->sum('amount');
        
        
        

        // total income lifetime and target filup bonus
        // Target Filup|Order Commission|Worker Signup|Membership Signup|Marketer Commismion
        $targetFilupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Target Filup')->sum('amount');

        $orderCommissionBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->sum('amount');
        $workerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Worker Signup')->sum('amount');
        $membershipSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Membership Signup')->sum('amount');
        $marketerBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->sum('amount');
        $customerSignUp = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer SignUp')->sum('amount');

        $totalLifetimeIncome = $orderCommissionBonus + $workerSignupBonus + $membershipSignupBonus + $marketerBonus + $customerSignUp;

        //order commission
        $totalOrderCommissionBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->sum('amount');
        $totalOrder = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->count();
        $totalCustomerOrder = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->count();
        $totalCustomerOrderBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->sum('amount');
        //$totalOrder = 0;
        $orderBudgetForCustomer = CustomerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->sum('budget');
        //$orderBudgetForWorker = WorkerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->sum('budget');
$orderBudgetForWorker = 0;
        $totalOrderBudget = $orderBudgetForCustomer + $orderBudgetForWorker;
        
        $totalCustomerSignUpBudget = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->sum('budget');
        
        
        //dd($orderBudgetForCustomer);
        //worker signup commission 
        $totalWorkerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Worker Signup')->sum('amount');

        $withdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'complete')->get();
        $totalWithdraw = 0;
        foreach ($withdraw as $row) {
            $totalWithdraw = $totalWithdraw + $row->amount;
        }
        $due =  $totalWithdraw - $totalWorkerSignupBonus;


        // Total Worker
        $totalWorker = 0;
        $workerJobCondition = 0;
        $workers = User::where('role', 'worker')->where('referred_by', $user_id)->get();
        foreach ($workers as $row) {
            $totalWorker++;
            $balance = Balance::where('user_id', $row->id)->sum('job_income');
            if ($balance >= get_static_option('job_complete_amount')) {
                $workerJobCondition++;
            }
        }

        // Total Customer
        $totalCustomer = 0;
        $customerJobCondition = 0;
        $customers = User::where('role', 'customer')->where('referred_by', $user_id)->get();
        //dd($customers);
        foreach ($customers as $row) {
            $totalCustomer++;
            $balance = Balance::where('user_id', $row->id)->sum('job_income');
            if ($balance >= get_static_option('job_complete_amount')) {
                $customerJobCondition++;
            }
        }

        // membership signup commission
        $totalMembershipSignupCommission = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Membership Signup')->sum('amount');

        $totalMembership = 0;
        $totalPackegBye = 0;
        $membership = User::where('role', 'worker')->where('referred_by', $user_id)->get();
        foreach ($membership as $row) {
            $membership = Membership::where('user_id', $row->id)->first();
            if($membership){
                $totalMembership++;
            }
            
            $bye = Payment::where('user_id', $row->id)->where('purpose', 'Membership')->first();
            if ($bye) {
                $totalPackegBye++;
            }
        }

        // membership signup commission
        // Target Filup|Order Commission|Worker Signup|Membership Signup|Marketer Commismion
        $totalMarketerCommission = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->sum('amount');

        $allMarketerIncome = 0;
        
        
        
        $conditionFilup = '';
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
            if ($allMarketerIncome >= get_static_option('marketer_monthly_income')) {
                $conditionFilup = 'YES';
            } else {
                $conditionFilup = 'No';
            }
        }
        
        $pendingIncome = ($totalWorker * $totalWorkerSignupBonus) - $totalWorkerSignupBonus;
        //current balance
        $currentBalance = AffiliateUser::where('user_id', $user_id)->sum('balance');
        /*Marketer Commison Save*/
        //dd($balance);
        $previousBalance = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->first()->previous_balance ?? 0;
        $mainBalance = $allMarketerIncome - $previousBalance;
        $marketerAffCommison = $mainBalance * get_static_option('marketer_commission_percent') / 100;
        //dd($mainBalance);
        if($currentBalance >= get_static_option('marketer_monthly_income')){
            $marketer = User::where('referral_code', auth()->user()->id)->first();
            $MarketerAffiliate = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->count();
            $prevois_balance = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->first();
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
            }else if($previousBalance != 0){
                $affiliate_user = $marketer->affiliate_user;
                $affiliate_user->balance += $marketerAffCommison;
                $affiliate_user->save();
                
                $affiliate_bonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->first();
                $affiliate_bonus->amount += $marketerAffCommison;
                $affiliate_bonus->previous_balance = $allMarketerIncome;
                $affiliate_bonus->save();
            }
        }
        
        
        return view('marketer.home.index', compact('currentMonth','currentBalance','categories', 'totalCustomerSignUpBudget', 'totalCustomer','totalCustomerOrderBonus','orderBudgetForWorker', 'totalCustomerOrder', 'pendingIncome', 'orderBudgetForCustomer', 'customerJobCondition', 'adminNotice', 'adminAds', 'totalIncome', 'TotalCurrentMonthIncome', 'totalWidraw', 'totalWidrawPainding', 'totalLifetimeIncome', 'targetFilupBonus', 'totalOrderCommissionBonus', 'totalOrderBudget', 'totalWorkerSignupBonus', 'due', 'totalWorker', 'workerJobCondition', 'totalMembershipSignupCommission', 'totalMembership', 'totalPackegBye', 'totalMarketerCommission', 'allMarketerIncome', 'conditionFilup','totalOrder'));
    }


    /**
     * showJob
     */
    public function showJob($id){

        $customerGig = CustomerGig::find(Crypt::decryptString($id));
        return view('worker.home.show-job',compact('customerGig'));
    }

    /**
     * showServices
     */
    public function showServices($id){

        $category = WorkerServiceCategory::find(Crypt::decryptString($id));
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        return view('marketer.home.services',compact('category','adminAds'));
    }

    public function showCustomerGigs($service_id){

        $service = WorkerService::find(Crypt::decryptString($service_id));
        return view('marketer.home.gigs',compact('service'));
    }

    // marketer withdraw 
    public function makeWithdrawPage(){
        $user_id = Auth::user()->id;
        $currentBalance = AffiliateUser::where('user_id', $user_id)->sum('balance');
        return view('marketer.home.make-withdraw',compact('currentBalance'));
    }
    public function makeWithdraw(Request $request){

        $user_id = Auth::user()->id;
        $currentBalance = AffiliateUser::where('user_id', $user_id)->sum('balance');

        $withdrawLimit = WithdrawRequest::where('user_id', $user_id)->whereMonth('created_at', '=', date('m'))->count();

        if ($currentBalance < $request->amount) {
            return back()->with('warning','Your Balance Is Low');
        }else if ($request->amount < get_static_option('withdraw_limit')) {
            return back()->with('warning',"You can not withdraw less than ".get_static_option('withdraw_limit')." taka");
        }else if ($withdrawLimit >= get_static_option('withdraw_times')) {
            return back()->with('warning','You can request for withdraw '.get_static_option('withdraw_times').' times in a month');
        }else{

            $newBalance  = $currentBalance - $request->amount;
            $user = User::find($user_id);
            $user->affiliate_user->balance = $newBalance;
            $user->affiliate_user->save();

            $withdraw = new WithdrawRequest();
            $withdraw->user_id = $user_id;
            $withdraw->amount = $request->amount;
            $withdraw->via = $request->via;
            $withdraw->ac_number = $request->ac_number;
            $withdraw->ac_details = $request->ac_details;
            $withdraw->status = "pending";
            $withdraw->save();

            return back()->with('success','Your Request Submited');
        }
            
    }

    public function singleBlog($id){
        
        $blog = Blog::find($id);
        // return $blog;
        $blog->view_count += 1;
        $blog->save();
        return view('marketer.home.single-blog',compact('blog'));
    }
}
