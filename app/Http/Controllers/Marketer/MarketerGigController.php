<?php

namespace App\Http\Controllers\Marketer;

use App\AdminAds;
use App\CustomerBid;
use App\Gig;
use App\GigOrder;
use App\Http\Controllers\Controller;
use App\Notifications\CustomerBidNotification;

use App\WorkerGig;
use App\User;
use App\WorkerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Cookie;
use Illuminate\Support\Facades\DB;

class MarketerGigController extends Controller
{
    /**
     * Show worker's gig to customer.
     * Only worker's upazila
     * Specify by service
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {

        $service = WorkerService::find(Crypt::decryptString($id));

        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        return view('marketer.home.gigs',compact('service','adminAds'));
    }

    /**
     * Customer home>service>worker gigs> details
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showGigDetail(Request $request,$id)
    {
        // return $request->gig_referral_code;
        $gig = WorkerGig::find($id);
        
        if($request->has('gig_referral_code')){
            Cookie::queue('gig_referral_code', $request->gig_referral_code, get_static_option('order_commission_time')*60);
            Cookie::queue('referred_gig_id', $gig->id, get_static_option('order_commission_time')*60);
        }
        
        $code = Cookie::get('referred_gig_id');
        // return $code;
        // dd($code);
        return view('marketer.home.gig-detail',compact('gig'));
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showOrderForm($id)
    {

        $gig = WorkerGig::find(Crypt::decryptString($id));

       
        return view('marketer.home.order-form',compact('gig'));
    }

    // search worker gigs by name 
    public function searchGigs($id,$name, $min_price, $max_price, $district, $upazila, $pouroshava, $word){
        if ($id != 0 && $name == 0 && $min_price == 0 && $max_price == 0 && $district == 0 && $upazila == 0 && $pouroshava == 0 && $word == 0) {
            $service = WorkerService::find($id);

            foreach($service->workerGigs as $gig){
                echo '
                <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <div class="row">
                                &nbsp;
                                <i class="material-icons text-template-primary">
                                    <figure class="avatar avatar-60 border-0">
                                        <img src="'.asset('uploads/images/users/'.$gig->worker->image).'" alt="">
                                    </figure>
                                </i>
                            </div>
                            <div class="row">
                                &nbsp;
                                <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                            </div>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">'.$gig->worker->full_name.'</p>
                                </div>
                                <div class="col-auto pl-0">
                                    <p class="small text-mute text-trucated mt-1">
                                         
                                    </p>
                                </div>
                            </div>
                            <p class="small text-mute">'.$gig->title.'</p>
                        </div>
                    </div>
                </a>';
            }
        }else if ($id != 0 && $name != 0 && $min_price == 0 && $max_price == 0 && $district == 0 && $upazila == 0 && $pouroshava == 0 && $word == 0) {

            $service = DB::table('worker_gigs')->where('service_id', $id)->where('worker_gigs.title','LIKE','%'.$name."%")->get();
            // $service = DB::table('worker_gigs')->where('service_id', $id)->where('title','LIKE','%'.$name."%")->get();

            foreach($service as $gig){
                   
                    echo '
                   <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                        <div class="row">
                            <div class="col-auto align-self-center">
                                <div class="row">
                                    &nbsp;
                                    <i class="material-icons text-template-primary">
                                        <figure class="avatar avatar-60 border-0">
                                            
                                        </figure>
                                    </i>
                                </div>
                                <div class="row">
                                    &nbsp;
                                    <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                                </div>
                            </div>
                            <div class="col pl-0">
                                <div class="row mb-1">
                                    <div class="col">
                                        
                                    </div>
                                    <div class="col-auto pl-0">
                                        <p class="small text-mute text-trucated mt-1">
                                             
                                        </p>
                                    </div>
                                </div>
                                <p class="small text-mute">'.$gig->title.'</p>
                            </div>
                        </div>
                    </a>';
            }
        }else if ($id != 0 && $name == 0 && $min_price != 0 && $max_price != 0 && $district == 0 && $upazila == 0 && $pouroshava == 0 && $word == 0) {

            $service = DB::table('worker_gigs')->where('service_id', $id)->whereBetween('budget',[$min_price, $max_price])->get();

            foreach($service as $gig){
                $worker = User::find($gig->worker_id);
                echo '
                <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <div class="row">
                                &nbsp;
                                <i class="material-icons text-template-primary">
                                    <figure class="avatar avatar-60 border-0">
                                        <img src="'.asset('uploads/images/users/'.$worker->image).'" alt="">
                                    </figure>
                                </i>
                            </div>
                            <div class="row">
                                &nbsp;
                                <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                            </div>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">'.$worker->full_name.'</p>
                                </div>
                                <div class="col-auto pl-0">
                                    <p class="small text-mute text-trucated mt-1">
                                         
                                    </p>
                                </div>
                            </div>
                            <p class="small text-mute">'.$gig->title.'</p>
                        </div>
                    </div>
                </a>';
            }
        }else if ($id != 0 && $name == 0 && $min_price == 0 && $max_price == 0 && $district != 0 && $upazila == 0 && $pouroshava == 0 && $word == 0) {
            $service = DB::table('worker_gigs')
                    ->join('users','worker_gigs.worker_id','users.id')
                    ->where('worker_gigs.service_id', $id)
                    ->where('users.district_id',$district)
                    ->get();

            foreach($service as $gig){
                $worker = User::find($gig->worker_id);
                echo '
                <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <div class="row">
                                &nbsp;
                                <i class="material-icons text-template-primary">
                                    <figure class="avatar avatar-60 border-0">
                                        <img src="'.asset('uploads/images/users/'.$worker->image).'" alt="">
                                    </figure>
                                </i>
                            </div>
                            <div class="row">
                                &nbsp;
                                <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                            </div>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">'.$worker->full_name.'</p>
                                </div>
                                <div class="col-auto pl-0">
                                    <p class="small text-mute text-trucated mt-1">
                                         
                                    </p>
                                </div>
                            </div>
                            <p class="small text-mute">'.$gig->title.'</p>
                        </div>
                    </div>
                </a>';
            }
        }else if ($id != 0 && $name == 0 && $min_price == 0 && $max_price == 0 && $district == 0 && $upazila != 0 && $pouroshava == 0 && $word == 0) {
            $service = DB::table('worker_gigs')
                    ->join('users','worker_gigs.worker_id','users.id')
                    ->where('worker_gigs.service_id', $id)
                    ->where('users.upazila_id',$upazila)
                    ->get();

            foreach($service as $gig){
                $worker = User::find($gig->worker_id);
                echo '
                <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <div class="row">
                                &nbsp;
                                <i class="material-icons text-template-primary">
                                    <figure class="avatar avatar-60 border-0">
                                        <img src="'.asset('uploads/images/users/'.$worker->image).'" alt="">
                                    </figure>
                                </i>
                            </div>
                            <div class="row">
                                &nbsp;
                                <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                            </div>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">'.$worker->full_name.'</p>
                                </div>
                                <div class="col-auto pl-0">
                                    <p class="small text-mute text-trucated mt-1">
                                         
                                    </p>
                                </div>
                            </div>
                            <p class="small text-mute">'.$gig->title.'</p>
                        </div>
                    </div>
                </a>';
            }
        }else if ($id != 0 && $name == 0 && $min_price == 0 && $max_price == 0 && $district == 0 && $upazila == 0 && $pouroshava != 0 && $word == 0) {

            $service = DB::table('worker_gigs')
                    ->where('service_id', $id)
                    ->get();

            foreach($service as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $wPourosova = $worker->pouroshova_union_id;
                $workerPourosova = explode(',', $wPourosova);
                if ($wPourosova != NULL) {
                    foreach ($workerPourosova as $p) {
                        if ($p == $pouroshava) {
                            $check = true;
                        }
                    }
                    if ($check == true) {
                        echo '
                        <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <div class="row">
                                        &nbsp;
                                        <i class="material-icons text-template-primary">
                                            <figure class="avatar avatar-60 border-0">
                                                <img src="'.asset('uploads/images/users/'.$worker->image).'" alt="">
                                            </figure>
                                        </i>
                                    </div>
                                    <div class="row">
                                        &nbsp;
                                        <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                                    </div>
                                </div>
                                <div class="col pl-0">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <p class="mb-0">'.$worker->full_name.'</p>
                                        </div>
                                        <div class="col-auto pl-0">
                                            <p class="small text-mute text-trucated mt-1">
                                                 
                                            </p>
                                        </div>
                                    </div>
                                    <p class="small text-mute">'.$gig->title.'</p>
                                </div>
                            </div>
                        </a>';
                    }
                }
            }
        }else if ($id != 0 && $name == 0 && $min_price == 0 && $max_price == 0 && $district == 0 && $upazila == 0 && $pouroshava == 0 && $word != 0) {

            $service = DB::table('worker_gigs')
                    ->where('service_id', $id)
                    ->get();

            foreach($service as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $wWord = $worker->word_road_id;
                $workerWord = explode(',', $wWord);
                if ($wWord != NULL) {
                    foreach ($workerWord as $w) {
                        if ($w == $word) {
                            $check = true;
                        }
                    }
                    if ($check == true) {
                        echo '
                        <a class="list-group-item border-top text-dark" href="'.route('marketer.showGigDetail',$gig->id).'">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <div class="row">
                                        &nbsp;
                                        <i class="material-icons text-template-primary">
                                            <figure class="avatar avatar-60 border-0">
                                                <img src="'.asset('uploads/images/users/'.$worker->image).'" alt="">
                                            </figure>
                                        </i>
                                    </div>
                                    <div class="row">
                                        &nbsp;
                                        <span class="badge badge-primary mb-1">'.$gig->budget.' ৳</span>
                                    </div>
                                </div>
                                <div class="col pl-0">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <p class="mb-0">'.$worker->full_name.'</p>
                                        </div>
                                        <div class="col-auto pl-0">
                                            <p class="small text-mute text-trucated mt-1">
                                                 
                                            </p>
                                        </div>
                                    </div>
                                    <p class="small text-mute">'.$gig->title.'</p>
                                </div>
                            </div>
                        </a>';
                    }
                }
            }
        }
    }
}
