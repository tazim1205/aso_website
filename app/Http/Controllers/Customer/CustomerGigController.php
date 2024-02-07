<?php

namespace App\Http\Controllers\Customer;

use App\Complain;
use App\CustomerGig;
use App\RattingReview;
use App\Http\Controllers\Controller;
use App\Referral;

use App\WorkerBid;
use App\UserAccountHistory;
use App\User;
use App\CustomerBid;
use App\AffiliateBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class CustomerGigController extends Controller
{
    /**
     * @param Request $request
     * @return CustomerGig
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|min:3|max:80',
            'description'       => 'required|string|min:15|max:2000',
            'address'           => 'required|string|min:3|max:200',
            'service'           => 'required|exists:worker_services,id',
            'day'               => 'required|numeric|min:1',
            'date'               => 'required',
            'time'               => 'required',
            // 'budget'            => 'required|numeric|min:10',
        ]);

        $gig = new CustomerGig();
        $gig->customer_id   = Auth::user()->id;
        $gig->title         = $request->input('title');
        $gig->description   = $request->input('description');
        $gig->address       = $request->input('address');
        $gig->service_id    = $request->input('service');
        $gig->day           = $request->input('day');
        $gig->date           = $request->input('date');
        $gig->time           = $request->input('time');
        // $gig->budget        = $request->input('budget');
        $gig->save();
        return $gig;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     */
    public function show($id)
    {

        $gig = CustomerGig::find(Crypt::decryptString($id));
        if ($gig->customer_id == Auth::user()->id){
            return view('customer.job.show-customer-gig', compact('gig'));
        }else{
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request)
    {
        $request->validate([
            'gig'    => 'required|exists:customer_gigs,id',
        ]);
        $gig = CustomerGig::find($request->input('gig'));
        if ($gig->customer_id == Auth::user()->id){
            //Gig status change
            $gig->status = 'cancelled';
            $gig->save();
            //Add in canceller list
            $cancelJob = new \App\CancelJob();
            $cancelJob->type = 'bid';
            $cancelJob->canceller_id = Auth::user()->id;
            $cancelJob->job_id = $gig->id;
            $cancelJob->save();


            return response()->json([
                'type' => 'success',
                'message' => 'Successfully cancel this gig',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function selectWorker(Request $request){
        $request->validate([
            'bid' => 'required|exists:worker_bids,id'
        ]);
        $bid = WorkerBid::find($request->input('bid'));
        $bid->is_selected = 1;
        $bid->save();

        $gig = $bid->customerGig;
        $gig->status = 'running'; //Job status running
        $gig->save();

        UserAccountHistory::updateStatus($bid->id, 'running');

        UserAccountHistory::where('service_id', $gig->id)->where('service_type', 'customer gig')->where('order_id', '!=', $request->input('bid'))->update(['status' => 'cancelled']);

        //All other cancel
        WorkerBid::where('customer_gig_id', $gig->id)->where('id', '!=', $request->input('bid'))->update(['is_cancelled' => 1]);
    }

    public function changePriceForMoreWork(Request $request){
        $request->validate([
            'bid' => 'required|exists:worker_bids,id',
            'price' => 'required'
        ]);
        $bid = WorkerBid::find($request->input('bid'));
        if ($bid->customerGig->customer->id == Auth::user()->id){
            if ($bid->budget > $request->input('price')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $bid->budget = $request->input('price');
                $bid->save();

                UserAccountHistory::updateBudget($bid->id, $request->input('price'));
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully price updated',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }
	
	
	public function acceptGigBidBudget(Request $request){
        $request->validate([
            'bid' => 'required',
            'budget' => 'required|numeric'
        ]);

        $bid = WorkerBid::find($request->input('bid'));
        if ($bid->customerGig->customer_id == Auth::user()->id){
            if ($bid->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $bid->budget = $request->input('budget');
                $bid->proposed_budget = NULL;
                $bid->update();

                UserAccountHistory::updateBudget($bid->id, $request->input('budget'));
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully Budget Accepted',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }
    public function cancelGigBidBudget(Request $request){
        $request->validate([
            'bid' => 'required',
            'budget' => 'required'
        ]);

        $bid = WorkerBid::find($request->input('bid'));
        if ($bid->customerGig->customer_id == Auth::user()->id){
            $bid->proposed_budget = NULL;
            $bid->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Budget Cancelled Successfully',
            ]);

        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function imageUploadToJob(Request $request){
        $request->validate([
            'bid' => 'required|exists:worker_bids,id',
            'image' => 'required|image'
        ]);
        $bid = WorkerBid::find($request->input('bid'));
        $customerGig = $bid->customerGig;
        if ($customerGig->image){
            return response()->json([
                'type' => 'warning',
                'message' => 'Image already exist.',
            ]);
        }else{
            if($request->hasFile('image')){
                $image             = $request->file('image');
                $folder_path       = 'uploads/images/jobs/';
                $image_new_name    = Str::random(8).'-jobs-'.'-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->save($folder_path.$image_new_name);
                $customerGig->image    = $folder_path.$image_new_name;
            }
            $customerGig->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Image successfully uploaded.',
            ]);
        }
    }

    public function completedJobAndRating(Request $request){
        $request->validate([
            'bid' => 'required|exists:worker_bids,id',
        ]);

        if($request->update_rating != 0){
            $bid = WorkerBid::find($request->input('bid'));
            $bid->rating_given = 1;
            $bid->save();

            $bid->worker->rating->max_rate +=  $request->input('rate');
            $bid->worker->rating->save();

            $RattingReview = new RattingReview();
            $RattingReview->user_id = $bid->worker_id;
            $RattingReview->givenBy = Auth::user()->id;
            $RattingReview->porpuse_id = $request->input('bid');
            $RattingReview->purpose = 'BID';
            $RattingReview->review = $request->input('review');
            $RattingReview->rate = $request->input('rate');
            $RattingReview->save();

            // get categorywise comission 
            $commission = $bid->customerGig->service->comission_rate;

            // //Worker balance update
            $bid->worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
                    
            $after_comision = $bid->budget - ($bid->budget * $commission) /100;
            $bid->worker->balance->due +=  $after_comision;

            

            $service_change = $bid->budget - $after_comision;
            $bid->worker->balance->service_change += $service_change;
            
            $bid->worker->balance->save();
            
            $user = User::find($bid->worker_id);
            $user->recharge_amount -= $service_change;
            $user->save();
            
            $earning = $bid->budget - $service_change;
            $account = DB::table('user_account_history')->where('order_id', $bid->id)->update([
                'service_charge' => $service_change,
                'comission' => $after_comision,
                'earnings' => $earning,
                'status' => 'completed',
            ]);
            
            // First Number Order Commison Save
            if ($user->referred_by != null) {
                $customer_first_number_order = get_static_option('customer_first_number_order');
                $customer_bid = CustomerBid::where('customer_id', auth()->user()->id)->count();
                if ($customer_bid <= $customer_first_number_order) {
                    $referred_by_user = User::where('referral_code', $user->referred_by)->first();
                    if ($referred_by_user != null) {
                        $amount = $commission * $bid->budget / 100;

                        $affiliate_user = $referred_by_user->affiliate_user;
                        if ($affiliate_user != null) {
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($referred_by_user->id, $bid->customerGig->customer_id, $amount, 'Customer Signup', $bid->id, $bid->budget);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $referred_by_user->id;
                            $affiliate_bonus->user_id = $bid->worker_id;
                            $affiliate_bonus->amount = $amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Customer Signup';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->save();*/
                        }
                    }
                }
            }


            return response()->json([
                'type' => 'success',
                'message' => 'Successfully rated',
            ]);
        }else{


            $bid = WorkerBid::find($request->input('bid'));
            $bid->rating_given = 1;
            $bid->status = 'completed';
            $bid->save();

            $customerGig = $bid->customerGig;
            if ($customerGig->customer_id == Auth::user()->id){
                $customerGig->status = 'completed';
                $customerGig->save(); //Job status updated
                //Rating

                $bid->worker->rating->max_rate +=  5;
                $bid->worker->rating->save();

                if ($request->input('rate') > 0){
                    $bid->worker->rating->rate +=  $request->input('rate');
                    $bid->worker->rating->save();


                    // // get categorywise comission 
                    $commission = $bid->customerGig->service->comission_rate;

                
                
                    // //Worker balance update
                    $bid->worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
                    
                    $after_comision = $bid->budget - ($bid->budget * $commission) /100;
                    $bid->worker->balance->due +=  $after_comision;



                    $service_change = $bid->budget - $after_comision;
                    $bid->worker->balance->service_change += $service_change;

                    // var_dump($bid->workerGig->worker->balance->service_change);
                    // exit();

                    $bid->worker->balance->save();


                    $user = User::find($bid->worker_id);
                    $user->recharge_amount -= $service_change;
                    $user->save();

                    //Worker balance update
                    // $bid->worker->balance->job_income += $bid->budget;
                    // $bid->worker->balance->due += (get_static_option('admin_percent_on_worker_job')/100) * $bid->budget;
                    // $bid->worker->balance->save();
                    
                    $earning = $bid->budget - $service_change;

                    // UserAccountHistory::updateEarnings($bid->id, $service_change, $after_comision, $earning);
                    $account = DB::table('user_account_history')->where('order_id', $bid->id)->update([
                        'service_charge' => $service_change,
                        'comission' => $after_comision,
                        'earnings' => $earning,
                        'status' => 'completed',
                    ]);
                    
                    
                    // First Number Order Commison Save
            if ($user->referred_by != null) {
                $customer_first_number_order = get_static_option('customer_first_number_order');
                $customer_bid = CustomerBid::where('customer_id', auth()->user()->id)->count();
                if ($customer_bid <= $customer_first_number_order) {
                    $referred_by_user = User::where('referral_code', $user->referred_by)->first();
                    if ($referred_by_user != null) {
                        $amount = $commission * $bid->budget / 100;

                        $affiliate_user = $referred_by_user->affiliate_user;
                        if ($affiliate_user != null) {
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($referred_by_user->id, $bid->customerGig->customer_id, $amount, 'Customer Signup', $bid->id, $bid->budget);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $referred_by_user->id;
                            $affiliate_bonus->user_id = $bid->worker_id;
                            $affiliate_bonus->amount = $amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Customer Signup';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->save();*/
                        }
                    }
                }
            }

                    $RattingReview = new RattingReview();
                    $RattingReview->user_id = $bid->worker_id;
                    $RattingReview->givenBy = Auth::user()->id;
                    $RattingReview->porpuse_id = $request->input('bid');
                    $RattingReview->purpose = 'BID';
                    $RattingReview->review = $request->input('review');
                    $RattingReview->rate = $request->input('rate');
                    $RattingReview->save();
                    
                   

                    return response()->json([
                        'type' => 'success',
                        'message' => 'Successfully rated-'.$request->input('rate'),
                    ]);
                }else{
                    return response()->json([
                        'type' => 'success',
                        'message' => 'Successfully rated',
                    ]);
                }

            }else{
                return redirect()->back();
            }
        }

    }
    // customer gig complain
    public function completedJobAndComplain(Request $request){
        $request->validate([
            'gig' => 'required|exists:worker_bids,id',
            'complain' => 'required|string',
        ]);

        $bid = WorkerBid::find($request->input('gig'));

        $customerGig = $bid->customerGig;
        if ($customerGig->customer_id == Auth::user()->id){
            // $customerGig->status = 'completed';
            // $customerGig->save(); //Job status updated


            // //Rating
            // $bid->worker->rating->max_rate +=  5;
            // $bid->worker->rating->save();

            //Complain
            $complain = new Complain();
            $complain->complainer_id = Auth::user()->id;
            $complain->purpose_id = $request->input('gig');
            $complain->complain = $request->input('complain');
            $complain->save();

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully order complained',
            ]);
        }
    }

}
