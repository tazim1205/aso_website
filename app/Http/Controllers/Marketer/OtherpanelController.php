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
use Auth;
use App\WithdrawRequest;
use DateTime;
use App\CustomerBid;
use App\WorkerBid;
use App\Balance;
use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;
use App\Membership;

use App\Payment;
use App\MembershipPackage;
use App\AffiliateUser;

use App\WorkerGig;
use App\UserAccountHistory;



use App\User;
use App\WorkerService;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use CreateCustomerGigsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;

class OtherpanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawHistoryPage()
    {
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.home.withdraw-history', compact('adminAds'));
    }

    public function marketerOrderHistoryPage()
    {
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.order-history', compact('adminAds'));
    }
    // Target Filup|Order Commission|Worker Signup|Membership Signup|Marketer Comision
    public function marketerTargetFilupData($year){
        $user_id = Auth::user()->id;
        if ($year == 0) {
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = date("Y");

                $targetFilupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Target Filup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $orderCommissionBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $workerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Worker Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $membershipSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Membership Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $marketerBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $customerSignUp = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer SignUp')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $totalIncome = $orderCommissionBonus + $workerSignupBonus + $membershipSignupBonus + $marketerBonus + $customerSignUp;

                $incomeWithBonus = $totalIncome + $targetFilupBonus;
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalIncome.'</td>
                    <td class="text-center">'.$targetFilupBonus.'</td>
                    <td class="text-center">'.$incomeWithBonus.'</td>
                </tr>';
            }
        }else{
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = $year;

                $targetFilupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Target Filup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $orderCommissionBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $workerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Worker Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $membershipSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Membership Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $marketerBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Comision')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $customerSignUp = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer SignUp')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                $totalIncome = $orderCommissionBonus + $workerSignupBonus + $membershipSignupBonus + $marketerBonus + $customerSignUp;

                $incomeWithBonus = $totalIncome + $targetFilupBonus;
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalIncome.'</td>
                    <td class="text-center">'.$targetFilupBonus.'</td>
                    <td class="text-center">'.$incomeWithBonus.'</td>
                </tr>';
            }
        }
    }

    public function marketerOrderCompleteCommissionData($year){
        $user_id = Auth::user()->id;
        if ($year == 0) {
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = date("Y");
                $orderCommissionBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $orderBudgetForCustomer = CustomerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->get();
                $orderBudgetForWorker = WorkerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->get();

                $customerBidBudget = 0;
                $workerBidBudget = 0;
                foreach ($orderBudgetForCustomer as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at));
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $customerBidBudget  += $row->budget;
                    }
                }
                foreach ($orderBudgetForWorker as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at));
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $workerBidBudget  += $row->budget;
                    }
                }
                $totalOrderBudget = $customerBidBudget;
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalOrderBudget.'</td>
                    <td class="text-center">'.$orderCommissionBonus.'</td>
                </tr>';
            }
        }else{
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = $year;
                $orderCommissionBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Order Commission')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $orderBudgetForCustomer = CustomerBid::where('gig_refferral_code', $user_id)->get();
                $orderBudgetForWorker = WorkerBid::where('gig_refferral_code', $user_id)->get();

                $customerBidBudget = 0;
                $workerBidBudget = 0;
                foreach ($orderBudgetForCustomer as $row) {
                    $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    $created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $customerBidBudget = $customerBidBudget + $row->budget;
                    }
                }
                foreach ($orderBudgetForWorker as $row) {
                    $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    $created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $workerBidBudget = $workerBidBudget + $row->budget;
                    }
                }
                $totalOrderBudget = $customerBidBudget + $workerBidBudget;
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalOrderBudget.'</td>
                    <td class="text-center">'.$orderCommissionBonus.'</td>
                </tr>';
            }
        }
    }

    public function marketercustomerSignupBonusData($year){
        $user_id = Auth::user()->id;
        if ($year == 0) {
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = date("Y");

                $totalWorkerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $withdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'complete')->get();
                $totalWithdraw = 0;
                foreach ($withdraw as $row) {
                     $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWithdraw = $totalWithdraw + $row->amount;
                    }
                }
                $due =  $totalWithdraw - $totalWorkerSignupBonus;
                $totalOrder = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->count();
                $totalWorker = 0;
                $workerJobCondition = 0;
                $workers = User::where('role','customer')->where('referred_by', $user_id)->get();
                foreach ($workers as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 

                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWorker++;
                        $balance = Balance::where('user_id',$row->id)->sum('job_income');
                        if ($balance >= get_static_option('job_complete_amount')) {
                            $workerJobCondition++;
                        }
                    }
                }
                
                
                //$orderBudgetForCustomer = CustomerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->sum('budget');
                $orderBudgetForCustomer = CustomerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->get();
                $orderBudgetForWorker = WorkerBid::where('gig_refferral_code', $user_id)->where('status', 'completed')->get();
                $totalCustomerBudget = 0;
                foreach ($orderBudgetForCustomer as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 

                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalCustomerBudget += $row->budget;
                        
                    }
                }
                $totalWorkerBudget = 0;
                foreach ($orderBudgetForWorker as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 

                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWorkerBudget += $row->budget;
                        
                    }
                }
                //$totalBudget = $totalCustomerBudget + $totalWorkerBudget;
                $totalBudget = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->sum('budget');
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalWorker.' জন</td>
                    <td class="text-center">'.$totalOrder.'</td>
                    <td class="text-center">'.$totalBudget.'</td>
                    <td class="text-center">'.$totalWorkerSignupBonus.'</td>
                </tr>';
            }
        }else{
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = $year;

                $totalWorkerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $withdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'complete')->get();
                $totalWithdraw = 0;
                foreach ($withdraw as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWithdraw = $totalWithdraw + $row->amount;
                    }
                }
                $due =  $totalWithdraw - $totalWorkerSignupBonus;
                $totalOrder = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->count();
                $totalWorker = 0;
                $workerJobCondition = 0;
                $workers = User::where('role','customer')->where('referred_by', $user_id)->get();

                foreach ($workers as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 
                  
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWorker++;
                        $balance = Balance::where('user_id',$row->id)->sum('job_income');
                        if ($balance >= get_static_option('job_complete_amount')) {
                            $workerJobCondition++;
                        }
                    }
                }
                
                $totalCustomerBudget = 0;
                foreach ($orderBudgetForCustomer as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 

                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalCustomerBudget += $row->budget;
                        
                    }
                }
                $totalWorkerBudget = 0;
                foreach ($orderBudgetForWorker as $row) {
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at)); 

                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWorkerBudget += $row->budget;
                        
                    }
                }
                //$totalBudget = $totalCustomerBudget + $totalWorkerBudget;
                $totalBudget = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->sum('budget');
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalWorker.' জন</td>
                    <td class="text-center">'.$totalOrder.'</td>
                    <td class="text-center">'.$totalBudget.'</td>
                    <td class="text-center">'.$totalWorkerSignupBonus.'</td>
                </tr>';
            }
        }
    }

    public function marketerWorkerSignupBonusData($year)
    {
        $user_id = Auth::user()->id;
        if ($year == 0) {
            for ($i = 1; $i <= 12; $i++) {
                $monthNum  = $i;
                $dateObj = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $currentYear = date("Y");

                $totalWorkerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Worker Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $withdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'complete')->get();
                $totalWithdraw = 0;
                foreach ($withdraw as $row) {
                    $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    $created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWithdraw = $totalWithdraw + $row->amount;
                    }
                }
                $due =  $totalWithdraw - $totalWorkerSignupBonus;
                
                

                $totalWorker = 0;
                $workerJobCondition = 0;
                $workers = User::where('role', 'worker')->where('referred_by', $user_id)->get();
                foreach ($workers as $row) {
                    $created_year = date('Y', strtotime($row->created_at));
                    $created_month = date('F', strtotime($row->created_at));
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWorker++;
                        $balance = Balance::where('user_id', $row->id)->sum('job_income');
                        if ($balance >= get_static_option('job_complete_amount')) {
                            $workerJobCondition++;
                        }
                    }
                }
                
                $pendingIncome = ($totalWorker * $totalWorkerSignupBonus) - $totalWorkerSignupBonus;
                
                echo '
                <tr>
                    <th scope="row">' . $monthName . '</th>
                    <td class="text-center">' . $totalWorker . ' জন</td>
                    <td class="text-center">' . $workerJobCondition . ' জন</td>
                    <td class="text-center">' . $totalWorkerSignupBonus . '</td>
                    <td class="text-center">' . $pendingIncome . '</td>
                </tr>';
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $monthNum  = $i;
                $dateObj = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $currentYear = $year;

                $totalWorkerSignupBonus = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Worker Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $withdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'complete')->get();
                $totalWithdraw = 0;
                foreach ($withdraw as $row) {
                    $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    $created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWithdraw = $totalWithdraw + $row->amount;
                    }
                }
                $due =  $totalWithdraw - $totalWorkerSignupBonus;

                $totalWorker = 0;
                $workerJobCondition = 0;
                $workers = User::where('role', 'worker')->where('referred_by', $user_id)->get();
                foreach ($workers as $row) {
                    $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    $created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $totalWorker++;
                        $balance = Balance::where('user_id', $row->id)->sum('job_income');
                        if ($balance >= 2000) {
                            $workerJobCondition++;
                        }
                    }
                }
                
                $pendingIncome = ($totalWorker * $totalWorkerSignupBonus) - $totalWorkerSignupBonus;
                
                echo '
                <tr>
                    <th scope="row">' . $monthName . '</th>
                    <td class="text-center">' . $totalWorker . ' জন</td>
                    <td class="text-center">' . $workerJobCondition . ' জন</td>
                    <td class="text-center">' . $totalWorkerSignupBonus . '</td>
                    <td class="text-center">' . $pendingIncome . '</td>
                </tr>';
            }
        }
    }

    public function marketerMembershipSignupCommissionData($year){
        $user_id = Auth::user()->id;
        if ($year == 0) {
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = date("Y");

                $totalMembershipSignupCommission = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Membership Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $totalMembership = 0;
                $totalPackegBye = 0;
                $membership = User::where('role','worker')->where('referred_by', $user_id)->get();
                foreach ($membership as $row) {
                    //$created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    //$created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    $created_year = date('Y', strtotime($row->created_at)); 
                    $created_month = date('F', strtotime($row->created_at));
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $memberships = Membership::where('user_id', $row->id)->first();
                        if($memberships){
                            $totalMembership++;
                        }
                        
                        $bye = Payment::where('user_id',$row->id)->where('purpose', 'Membership')->first();
                        if ($bye) {
                            //$bye_year = Carbon::createFromFormat('Y-m-d H:i:s', $bye->created_at)->year;
                            //$bye_month = Carbon::createFromFormat('Y-m-d H:i:s', $bye->created_at)->month;
                            $bye_year = date('Y', strtotime($bye->created_at)); 
                            $bye_month = date('F', strtotime($bye->created_at));
                            if ($currentYear == $bye_year && $monthName == $bye_month) {
                                $totalPackegBye++;
                            }
                        }
                    }
                }
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalMembership.' জন</td>
                    <td class="text-center">'.$totalPackegBye.' জন</td>
                    <td class="text-center">'.$totalMembershipSignupCommission.'</td>
                </tr>';
            }
        }else{
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = $year;

                $totalMembershipSignupCommission = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Membership Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $totalMembership = 0;
                $totalPackegBye = 0;
                $membership = User::where('role','worker')->where('referred_by', $user_id)->get();
                foreach ($membership as $row) {
                    $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                    $created_month = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->month;
                    if ($currentYear == $created_year && $monthName == $created_month) {
                        $membership = Membership::where('user_id', $row->id)->first();
                        if($membership){
                            $totalMembership++;
                        }
                        $bye = Payment::where('user_id',$row->id)->first();
                        if ($bye) {
                            $bye_year = Carbon::createFromFormat('Y-m-d H:i:s', $bye->created_at)->year;
                            $bye_month = Carbon::createFromFormat('Y-m-d H:i:s', $bye->created_at)->month;
                            if ($currentYear == $bye_year && $monthName == $bye_month) {
                                $totalPackegBye++;
                            }
                        }
                    }
                }
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$totalMembership.' জন</td>
                    <td class="text-center">'.$totalPackegBye.' জন</td>
                    <td class="text-center">'.$totalMembershipSignupCommission.'</td>
                </tr>';
            }
        }
    }


/*Marketer Marketer Commison*/
    public function marketerMarketersCommission($year){
        $user_id = Auth::user()->id;
        if ($year == 0) {
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = date("Y");

                $totalMarketerCommission = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $allMarketerIncome = 0;
                $conditionFilup = '';
                $marketer = User::where('role','marketer')->where('referred_by', $user_id)->get();
                foreach ($marketer as $row) {
                    $orderCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Order Commission')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                    $workerCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Worker Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                    $memberCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Membership Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                    $customerCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Customer Signup')->where('month', $monthName)->where('year', $currentYear)->sum('amount');
                    $balance = Balance::where('user_id',$row->id)->sum('job_income');
                    $allMarketerIncome = $allMarketerIncome + $orderCommission + $workerCommission + $memberCommission+$customerCommission;
                    if ($allMarketerIncome >= get_static_option('marketer_monthly_income')) {
                        $conditionFilup= 'YES';
                    }else{
                        $conditionFilup= 'No';
                    }
                }
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$conditionFilup.'</td>
                    <td class="text-center">'.$allMarketerIncome.'</td>
                    <td class="text-center">'.$totalMarketerCommission.'</td>
                </tr>';
            }
        }else{
            for($i = 1; $i <= 12; $i++){
                $monthNum  = $i; 
                $dateObj= DateTime::createFromFormat('!m', $monthNum); 
                $monthName = $dateObj->format('F');
                $currentYear = $year;

                $totalMarketerCommission = AffiliateBonus::where('affiliate_user_id', $user_id)->where('bonus_purpose', 'Marketer Commismion')->where('month', $monthName)->where('year', $currentYear)->sum('amount');

                $allMarketerIncome = 0;
                $conditionFilup = '';
                $marketer = User::where('role','marketer')->where('referred_by', $user_id)->get();
                foreach ($marketer as $row) {
                    $orderCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Order Commission')->sum('amount');
                    $workerCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Worker Signup')->sum('amount');
                    $memberCommission = AffiliateBonus::where('affiliate_user_id', $row->id)->where('bonus_purpose', 'Membership Signup')->sum('amount');

                    $balance = Balance::where('user_id',$row->id)->sum('job_income');
                    $allMarketerIncome = $allMarketerIncome + $orderCommission + $workerCommission + $memberCommission;
                    if ($balance >= 200) {
                        $conditionFilup= 'YES';
                    }else{
                        $conditionFilup= 'No';
                    }
                }
                echo '
                <tr>
                    <th scope="row">'.$monthName.'</th>
                    <td class="text-center">'.$conditionFilup.'</td>
                    <td class="text-center">'.$allMarketerIncome.'</td>
                    <td class="text-center">'.$totalMarketerCommission.'</td>
                </tr>';
            }
        }
    }

    // withdraw history list(varname)
    

    public function withdrawHistoryList($year){
        if ($year == 0) {
            $user_id = Auth::user()->id;
            $currentYear = date("Y");
            $data = WithdrawRequest::where('user_id', $user_id)->whereYear('created_at',$currentYear)->get();
        }else{
            $user_id = Auth::user()->id;
            $currentYear = $year;
            $data = WithdrawRequest::where('user_id', $user_id)->whereYear('created_at',$currentYear)->get();
        }
            return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate); 
                return $newformat;
            })
            ->addColumn('status', function($data) {
                if (!empty($data->status) && $data->status == 'complete'){
                    return '<span class="text-success">Complete</span>';
                }else if (!empty($data->status) && $data->status == 'cancel'){
                    return '<span class="text-danger">Cancel</span>';
                }else{
                    return '<span class="text-warning">Pending</span>';
                }
            })
            ->addColumn('Actions', function($data) {
                return '<a href="" class="seeBtn" id="'.$data->id.'">See</a>';
            })
            ->rawColumns(['date','status','Actions'])
            ->make(true);
        
    }

    public function withdrawHistoryDetails($id){
        $withdraw = WithdrawRequest::where('id', $id)->first();
        $msg = '<p><span class="text-danger">A/C Number:</span> '.$withdraw->ac_number.'</p>
        <p><span class="text-danger">A/C Details:</span> '.$withdraw->ac_details.'</p>
        <p><span class="text-danger">Tranjection Id/Info:</span> '.$withdraw->transaction_id.'</p>
        <p><span class="text-danger">Time:</span> '.$withdraw->created_at->toTimeString().'</p>';
        if($withdraw->cancel_reason != null){
            $msg .= '<p><span class="text-danger">Cancel Reason:</span> '.$withdraw->cancel_reason.'</p>';
        }
        echo $msg;
    }

    // customer under me 
    public function customerUnderMe(){
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.home.customer-list', compact('adminAds'));
    }

    public function CustomerUnderMeData($year, $month){
        $user_id = Auth::user()->id;
        if ($year == 0 && $month == 0) {
            $currentYear = date("Y");
            $currentMonth = date("m");
            $data = User::where('role','customer')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }else{
            $currentYear = $year;
            $currentMonth = $month;
            $data = User::where('role','customer')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate); 
                return $newformat;
            })
            
            ->addColumn('totalBid', function($data) {
                //$totalBid = UserAccountHistory::where('customer_id',$data->id)->count('order_id');
                $totalBid = AffiliateBonus::where('affiliate_user_id',Auth::user()->id)->where('user_id', $data->id)->where('bonus_purpose', 'Customer Signup')->count();
                return $totalBid;
                
            })

            ->addColumn('totalBudget', function($data) {
                //$totalBudget = UserAccountHistory::where('customer_id',$data->id)->sum('budget');
                $totalBudget = AffiliateBonus::where('affiliate_user_id',Auth::user()->id)->where('user_id', $data->id)->where('bonus_purpose', 'Customer Signup')->sum('budget');
                return $totalBudget;
                
            })

            ->addColumn('balance', function($data) {
                //$balance = UserAccountHistory::where('customer_id',$data->id)->sum('earnings');
                $balance = AffiliateBonus::where('affiliate_user_id', Auth::user()->id)->where('user_id', $data->id)->where('bonus_purpose', 'Customer Signup')->sum('amount');
                return ''.$balance.'';
                
            })
            
            ->addColumn('Actions', function($data) {
                return '<a href="" class="seeBtn" id="'.$data->id.'">See</a>';
            })
            ->rawColumns(['date','totalBid','totalBudget','balance','Actions'])
            ->make(true);
    }

    public function customerDetails($id){
        $workers = User::where('id', $id)->first();
        $district = District::find($workers->district_id);
        $upazila = Upazila::find($workers->upazila_id);
        $pourosova = Puroshova::find($workers->pouroshova_union_id);
        $word = Word::find($workers->word_road_id);
        $balance = Balance::where('user_id',$id)->sum('job_income');
        echo '
        <p><span class="text-danger">District:</span> '.$district->name.'</p>
        <p><span class="text-danger">Upazila/ M. Thana:</span> '.$upazila->name.'</p>
        <p><span class="text-danger">Puroshova/ Area:</span> '.(($pourosova)?''.$pourosova->name.'':'').'</p>
        <p><span class="text-danger">Word/ Road:</span> '.(($word)?''.$word->name.'':'').'</p>
        <p><span class="text-danger">Sign Up Time:</span> '.$workers->created_at->toDateString().'</p>';
    }

    // worker under me 

    // page 
    public function workerUnderMe(){
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.home.worker-list', compact('adminAds'));
    }

    public function WorkerUnderMeData($year, $month){
        $user_id = Auth::user()->id;
        if ($year == 0 && $month == 0) {
            $currentYear = date("Y");
            $currentMonth = date("m");
            $data = User::where('role','worker')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }else{
            $currentYear = $year;
            $currentMonth = $month;
            $data = User::where('role','worker')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate); 
                return $newformat;
            })
            ->addColumn('jobcomplete', function($data) {
                $balance = Balance::where('user_id',$data->id)->sum('job_income');
                if ($balance >=  get_static_option('job_complete_amount')) {
                    return '<span class="text-success">Yes</span>';
                }else{
                    return '<span class="text-danger">No</span>';
                }
                
            })
            ->addColumn('balance', function($data) {
                $balance = AffiliateBonus::where('affiliate_user_id', Auth::user()->id)->where('bonus_purpose', 'Worker Signup')->sum('amount');
                return ''.$balance.'';
                
            })
            
            ->addColumn('Actions', function($data) {
                return '<a href="" class="seeBtn" id="'.$data->id.'">See</a>';
            })
            ->rawColumns(['date','jobcomplete','balance','Actions'])
            ->make(true);
    }

    // worker Details
    public function workerDetails($id){
        $workers = User::where('id', $id)->first();
        $district = District::find($workers->district_id);
        $upazila = Upazila::find($workers->upazila_id);
        $pourosova = Puroshova::find($workers->id);
        $word = Word::find($workers->id);
        $balance = Balance::where('user_id',$id)->sum('job_income');
        echo '
        <p><span class="text-danger">District:</span> '.$district->name.'</p>
        <p><span class="text-danger">Upazila/ M. Thana:</span> '.$upazila->name.'</p>
        <p><span class="text-danger">Puroshova/ Area:</span> '.(($pourosova)?''.$pourosova->name.'':'').'</p>
        <p><span class="text-danger">Word/ Road:</span> '.(($word)?''.$word->name.'':'').'</p>
        <p><span class="text-danger">Sign Up Time:</span> '.$workers->created_at->toDateString().'</p>

        <p><span class="text-danger">Term Fill Up Date:</span> '.(($balance >=  2000)?''.$balance->updated_at->toDateString().'':'').'</p>
        <p><span class="text-danger">Term Fill Up Time:</span> '.(($balance >=  2000)?''.$balance->updated_at->toTimeString().'':'').'</p>';
    }

    // member under me

    // page
    public function memberUnderMe(){
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.home.membership-list', compact('adminAds'));
    }

    public function memberUnderMeData($year, $month){
        $user_id = Auth::user()->id;
        if ($year == 0 && $month == 0) {
            $currentYear = date("Y");
            $currentMonth = date("m");
            $data = User::has('membership')->where('role','worker')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }else{
            $currentYear = $year;
            $currentMonth = $month;
            $data = User::has('membership')->where('role','worker')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate); 
                return $newformat;
            })
            ->addColumn('pages', function($data) {
                $pages = $data->workerPages;
                $page_name = '';
                foreach ($pages as $page) {
                    $page_name .= $page->name.',';
                }
                return $page_name;
            })
            ->addColumn('buy', function($data) {
                $bye = Payment::where('user_id',$data->id)->first();
                if ($bye) {
                    return '<span class="text-success">'.$bye->amount.'</span>';
                }else{
                    return '<span class="text-danger">-</span>';
                }
                
            })
            ->addColumn('balance', function($data) {
                //$balance = Balance::where('user_id',$data->id)->sum('job_income');
                $balance = AffiliateBonus::where('user_id', $data->id)->where('bonus_purpose', 'Membership Signup')->sum('amount');
                return ''.$balance.'';
                
            })
            
            ->addColumn('Actions', function($data) {
                return '<a href="" class="seeBtn" id="'.$data->id.'">See</a>';
            })
            ->rawColumns(['date','buy','balance','Actions'])
            ->make(true);
    }

    // member Details
    public function memberDetails($id){
        $member = User::where('id', $id)->first();
        $district = District::find($member->district_id);
        $upazila = Upazila::find($member->upazila_id);
        $pourosova = Puroshova::find($member->id);
        $word = Word::find($member->id);
        $bye = Payment::where('user_id',$member->id)->where('purpose', 'Membership')->first();
        if ($bye) {
           $packeg = MembershipPackage::where('id',$bye->packeg_id)->first();
        }else{
           $packeg = '';
        }
        
        echo '
        <p><span class="text-danger">Packeg Bye Date:</span> '.(($bye)?'<span class="">'.$bye->created_at->toDateString().'</span>':'<span class="">-</span>').'</p>
        <p><span class="text-danger">District:</span> '.(($district)?''.$district->name.'':'').'</p>
        <p><span class="text-danger">Upazila/ M. Thana:</span> '.(($upazila)?''.$upazila->name.'':'').'</p>
        <p><span class="text-danger">Puroshova/ Area:</span> '.(($pourosova)?''.$pourosova->name.'':'').'</p>
        <p><span class="text-danger">Word/ Road:</span> '.(($word)?''.$word->name.'':'').'</p>
        <p><span class="text-danger">Sign Up Time:</span> '.$member->created_at->toDateString().'</p>
        <p><span class="text-danger">Packeg Bye Date:</span> '.(($bye)?'<span class="">'.$bye->created_at->toDateString().'</span>':'<span class="">-</span>').'</p>
        <p><span class="text-danger">Packeg Bye Time:</span> '.(($bye)?'<span class="">'.$bye->created_at->toTimeString().'</span>':'<span class="">-</span>').'</p>
        <p><span class="text-danger">Packeg Name:</span> '.(($packeg != '')?'<span class="">'.$packeg->name.'</span>':'<span class="">-</span>').'</p>';
    }

    // marketer under me

    // page
    public function marketerUnderMe(){
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.home.marketer-list', compact('adminAds'));
    }


    public function marketerUnderMeData($year, $month){
        $user_id = Auth::user()->id;
        if ($year == 0 && $month == 0) {
            $currentYear = date("Y");
            $currentMonth = date("m");
            $data = User::where('role','marketer')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }else{
            $currentYear = $year;
            $currentMonth = $month;
            $data = User::where('role','marketer')->where('referred_by', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate); 
                return $newformat;
            })
            ->addColumn('marketer_balance', function($data) {
                $marketer_balance = AffiliateUser::where('user_id',$data->id)->first();
                if ($marketer_balance) {
                    return '<span class="text-success">'.$marketer_balance->balance.'</span>';
                }else{
                    return '<span class="text-danger">-</span>';
                }
                
            })
            ->addColumn('incomeFromHim', function($data) {
                $incomeFromHim = AffiliateBonus::where('affiliate_user_id', Auth::user()->id)->where('bonus_purpose', 'Marketer Commismion')->sum('amount');
                return ''.$incomeFromHim.'';
                
            })
            
            ->addColumn('Actions', function($data) {
                return '<a href="" class="seeBtn" id="'.$data->id.'">See</a>';
            })
            ->rawColumns(['date','marketer_balance','incomeFromHim','Actions'])
            ->make(true);

        if ($month == 0 && $year == 0) {
            $currentYear = date("Y");
            $currentMonth = date("F");
            $marketer = User::where('role','marketer')->where('referred_by', $user_id)->get();
            foreach ($marketer as $row) {
                $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                $created_month = $row->created_at->format('F');
                if ($created_year == $currentYear && $created_month == $currentMonth) {
                    $marketer_balance = AffiliateUser::where('user_id',$row->id)->first();
                    $incomeFromHim = AffiliateBonus::where('user_id',$row->id)->sum('amount');
                    echo '<tr>
                            <th class="text-center">'.$row->user_name.'</th>
                            <th class="text-center">'.$row->created_at->toDateString().'</th>
                            <td class="text-center">'.(($marketer_balance)?'<span class="text-success">'.$marketer_balance->balance.'</span>':'<span class="text-danger">-</span>').'</td>
                            <th class="text-center">'.$incomeFromHim.'</th>
                            <td class="text-center"><a href="" class="seeBtn" id="'.$row->id.'">See</a></td>
                        </tr>
                    ';
                }
            }
        }else{
            $currentYear = $year;
            $currentMonth = $month;
            $marketer = User::where('role','marketer')->where('referred_by', $user_id)->get();
            foreach ($marketer as $row) {
                $created_year = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->year;
                $created_month = $row->created_at->format('F');
                if ($created_year == $currentYear && $created_month == $currentMonth) {
                    $marketer_balance = AffiliateUser::where('user_id',$row->id)->first();
                    $incomeFromHim = AffiliateBonus::where('user_id',$row->id)->sum('amount');
                    echo '<tr>
                            <th class="text-center">'.$row->user_name.'</th>
                            <th class="text-center">'.$row->created_at->toDateString().'</th>
                            <td class="text-center">'.(($marketer_balance)?'<span class="text-success">'.$marketer_balance->balance.'</span>':'<span class="text-danger">-</span>').'</td>
                            <th class="text-center">'.$incomeFromHim.'</th>
                            <td class="text-center"><a href="" class="seeBtn" id="'.$row->id.'">See</a></td>
                        </tr>
                    ';
                }
            }
        }
    }

    // marketer details
    public function marketerDetails($id){
        $marketer = User::where('id', $id)->first();
        $district = District::find($marketer->district_id);
        $upazila = Upazila::find($marketer->upazila_id);
        
        echo '
        <p><span class="text-danger">Phone Number:</span> '.$marketer->phone.'</p>
        <p><span class="text-danger">Email:</span> '.$marketer->email.'</p>
        <p><span class="text-danger">District:</span> '.(($district)?''.$district->name.'':'').'</p>
        <p><span class="text-danger">Upazila/ M. Thana:</span> '.(($upazila)?''.$upazila->name.'':'').'</p>
        <p><span class="text-danger">Sign Up Time:</span> '.$marketer->created_at->toTimeString().'</p>
        ';
    }

    // order under me

    // page
    public function orderUnderMe(){
        $adminAds = MarketerControllerAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        return view('marketer.home.order-history', compact('adminAds'));
    }

    public function orderUnderMeData($year, $month){
        $user_id = Auth::user()->id;

        if ($year == 0 && $month == 0) {
            $currentYear = date("Y");
            $currentMonth = date("m");
            $data = CustomerBid::where('gig_refferral_code', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }else{
            $currentYear = $year;
            $currentMonth = $month;
            $data = CustomerBid::where('gig_refferral_code', $user_id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate); 
                return $newformat;
            })
            ->addColumn('income', function($data) {
                $incomeFromThisOrder = AffiliateBonus::where('affiliate_user_id',$data->gig_refferral_code)->where('order_id', $data->id)->where('bonus_purpose', 'Order Commission')->sum('amount');
                return ''.$incomeFromThisOrder.'';
                
            })
            ->addColumn('Actions', function($data) {
                return '<a href="" class="seeBtn" id="'.$data->id.'">See</a>';
            })
            ->rawColumns(['date','income','Actions'])
            ->make(true);
    }

    public function orderDetails($id){
        $user_id = Auth::user()->id;
        $marketer = User::where('id', $user_id)->first();
        $customerOrder = CustomerBid::where('id', $id)->first();

        $customer = User::where('id', $customerOrder->customer_id)->first();

        $orderWorker=DB::table('customer_bids')
        ->join('worker_gigs','customer_bids.worker_gig_id','worker_gigs.id')
        ->join('users','worker_gigs.worker_id','users.id')
        ->select('users.user_name as workerName','customer_bids.customer_id')
        ->where('customer_bids.id',$customerOrder->id)->first();

        $district = District::find($customer->district_id);
        $upazila = Upazila::find($customer->upazila_id);
        $pourosova = Puroshova::find($customer->pouroshova_union_id);
        $word = Word::find($customer->word_road_id);

        echo '
        <p><span class="text-danger">Customer Username:</span> '.$customer->user_name.'</p>
        <p><span class="text-danger">Worker Username:</span> '.$orderWorker->workerName.'</p>
        <p><span class="text-danger">Order Number:</span> '.$customerOrder->id.'</p>
        <p><span class="text-danger">District:</span> '.(($district)?''.$district->name.'':'').'</p>
        <p><span class="text-danger">Upazila/ M. Thana:</span> '.(($upazila)?''.$upazila->name.'':'').'</p>
        <p><span class="text-danger">Puroshova/ Area:</span> '.(($pourosova)?''.$pourosova->name.'':'').'</p>
        <p><span class="text-danger">Word/ Road:</span> '.(($word)?''.$word->name.'':'').'</p>
        <p><span class="text-danger">Time:</span> '.$customerOrder->created_at->toTimeString().'</p>
        '; 
        
        //echo 'hello';
    }

    
    

}
