<?php

namespace App\Http\Controllers\Worker;

use App\CustomerGig;
use App\Http\Controllers\Controller;
use App\Notifications\WorkerBidNotification;

use App\WorkerBid;
use App\UserAccountHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class WorkerBidController extends Controller
{

    public function show($id)
    {

        $customerGig = CustomerGig::find(Crypt::decryptString($id));
        return view('worker.job.show-worker-bid', compact('customerGig'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'budget'            => 'required|numeric|min:10',
            'description'       => 'required|string|min:15|max:5000',
            'jobId'            => 'required',
        ]);
        $workerBid = new WorkerBid();
        $workerBid->customer_gig_id   = Crypt::decryptString($request->input('jobId'));
        $workerBid->worker_id   = Auth::user()->id;
        $workerBid->description   = $request->input('description');
        $workerBid->budget        = $request->input('budget');
        $workerBid->gig_refferral_code = Auth::user()->referred_by;
        $workerBid->save();

        $Gig = CustomerGig::find($workerBid->customer_gig_id);

        UserAccountHistory::isertIntoAccountHistory($workerBid->id, 'worker', Auth::user()->id, $Gig->customer_id, 'customer gig', $Gig->id, $workerBid->budget , $Gig->date, $Gig->time, $Gig->day, 0.00, 0.00, 0.00, 'pending');
        
        $workerBid->customerGig->customer->notify(new WorkerBidNotification($workerBid)); //notification send to customer
        return $workerBid;

        

    }

    public function cancel(Request $request)
    {
        $request->validate([
            'bid' => 'required|exists:worker_bids,id'
        ]);
        $bid = WorkerBid::find($request->input('bid'));
        if ($bid->worker_id == Auth::user()->id){
            $bid->is_cancelled = '1';
            $bid->save();
            $bid->customerGig->customer->notify(new WorkerBidNotification($bid)); //notification send to customer
            //return redirect()->route('worker.showWorkerBid',Crypt::encryptString($bid->customer_gig_id));

            UserAccountHistory::updateStatus($bid->id, 'cancelled');

            return $bid;
        }else{
            return redirect()->back();
        }
    }

    public function changePriceForMoreWork(Request $request){
        $request->validate([
            'bid' => 'required|exists:worker_bids,id',
            'price' => 'required|numeric'
        ]);
        $bid = WorkerBid::find($request->input('bid'));
        if ($bid->worker->id == Auth::user()->id){
            if ($bid->budget > $request->input('price')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $bid->proposed_budget = $request->input('price');
                $bid->save();
                $bid->customerGig->customer->notify(new WorkerBidNotification($bid)); //notification send to customer
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully price updated',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'info',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function completedJobAndRating(Request $request){
        $request->validate([
            'bid' => 'required|exists:worker_bids,id',
        ]);

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
                $bid->customerGig->worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
                
                $after_comision = $bid->budget - ($bid->budget * $commission) /100;
                $bid->customerGig->worker->balance->due +=  $after_comision;



                $service_change = $bid->budget - $after_comision;
                $bid->customerGig->worker->balance->service_change += $service_change;

                // var_dump($bid->workerGig->worker->balance->service_change);
                // exit();

                $bid->customerGig->worker->balance->save();


                $user = User::find($bid->customerGig->worker->id);
                $user->recharge_amount -= $service_change;
                $user->save();


                //Worker balance update
                // $bid->worker->balance->job_income += $bid->budget;
                // $bid->worker->balance->due += (get_static_option('admin_percent_on_worker_job')/100) * $bid->budget;
                // $bid->worker->balance->save();

                $RattingReview = new RattingReview();
                $RattingReview->user_id = $bid->worker_id;
                $RattingReview->givenBy = Auth::user()->id;
                $complain->purpose_id = $request->input('bid');
                $RattingReview->review = $request->input('review');
                $RattingReview->rate = $request->input('rate');
                $RattingReview->save();

                $earning = $bid->budget - $service_change;
                UserAccountHistory::updateEarnings($bid->id, $service_change, $after_comision, $earning);
                UserAccountHistory::updateStatus($bid->id, 'completed');

                
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
