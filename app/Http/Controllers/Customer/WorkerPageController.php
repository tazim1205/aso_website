<?php

namespace App\Http\Controllers\Customer;

use App\AdminAds;
use App\CustomerBid;
use App\Gig;
use App\User;
use App\GigOrder;
use App\Http\Controllers\Controller;
use App\Notifications\CustomerBidNotification;
use DB;
use Illuminate\Support\Facades\Auth;
use App\GigQuestion;
use App\GigQuestionReplay;

use App\WorkerGig;
use App\WorkerService;
use App\WorkerPage;
use App\PageService;
use App\Membership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Crypt;

class WorkerPageController extends Controller
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

        $page_details = WorkerPage::where('id', $id)->where('status', 'active')->where('visibility', 'show')->first();

        if ($page_details) {
            $membership = Membership::where('user_id', $page_details->worker_id)->where('ending_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))->first();
            // var_dump($membership);exit();
        }
        else {
            abort(404);
        }
        if ($membership) {
            return view('customer.home.pages', compact('page_details'));
        }
        else {
            abort('404');
        }
    }

    function pageClick(Request $request){
        $page_click = 1;
        return WorkerPage::find($request->page_id)->increment('click', $page_click);
    }
    function serviceClick(Request $request){
        $service_click = 1;
        return PageService::find($request->service_id)->increment('click', $service_click);
    }


    /**
     * Customer home>service>worker gigs> details
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showPageDetail($id)
    {
        $gig = WorkerGig::find($id);
        return view('customer.home.page-service',compact('gig'));
    }

    public function showServiceDetail($page_id, $id)
    {
        $page_details = WorkerPage::where('id', $page_id)->where('status', 'active')->where('visibility', 'show')->first();
        
        if ($page_details) {
            $membership = Membership::where('user_id', $page_details->worker_id)->where('ending_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))->first();
        }
        else {
            abort(404);
        }

        if ($membership) {
            $service = PageService::findOrFail($id);
            return view('customer.home.page-service',compact('service', 'page_id'));
        }
        else {
            abort('404');
        }
    }

    public function gigQuestions($gig_id, $show)
    {
        if ($show == '0') {
            $question = GigQuestion::where('gig_id', $gig_id)->limit(1)->get();
        }else{
            $question = GigQuestion::where('gig_id', $gig_id)->get();
        }
        foreach ($question as $row) {
            $user = User::find($row->user_id);
            echo '
            <div class="d-flex" id="">
                <div class="p-2">
                    <h4><i class="fa fa-question-circle text-success"></i> </h4>
                </div>
                <div class="">
                    <h4>'.$row->question.'</h4>
                    <span>'.$user->user_name.', '.date('g:i a', $row->create_at).', '.date('j F, Y', $row->create_at).'</span>
                    <div class="row mt-1">';
                        $replays = GigQuestionReplay::where('question_id', $row->id)->get();
                        foreach ($replays as $replay) {
                        echo '
                            <div class="col-12 pl-4">
                                <h5 class=""><i class="fa fa-check-circle text-info"></i> <a href="" class="text-primary"></a> The next generation of the web’s favorite icon library + toolkit is now available as a Beta release!</h5>
                                <span>User_name, 08:45 pm, 25 Feb 2021</span>
                            </div>';
                        }
                        echo '
                        <button onclick="replayQuestion('.$row->id.')"><i class="fa fa-reply" ></i> Replay</button>
                    </div>
                </div>
            </div>';
        }
    }

    public function yourGigQuestions($gig_id, $show)
    {
        $question = GigQuestion::where('user_id', Auth::user()->id)->where('gig_id', $gig_id)->get();
        foreach ($question as $row) {
            $user = User::find($row->user_id);
            echo '
            <div class="d-flex" id="">
                <div class="p-2">
                    <h4><i class="fa fa-question-circle text-success"></i> </h4>
                </div>
                <div class="">
                    <h4>'.$row->question.'</h4>
                    <span>'.$user->user_name.', '.date('g:i a', $row->create_at).', '.date('j F, Y', $row->create_at).'</span>
                    <div class="row mt-1">';
                        $replays = GigQuestionReplay::where('question_id', $row->id)->get();
                        foreach ($replays as $replay) {
                            $user2 = User::find($replay->user_id);
                        echo '
                            <div class="col-12">
                                <h5><i class="fa fa-check-circle text-info"></i> <a href="" class="text-primary"></a> '.$replay->replay.'</h5>
                                <span>'.$user2->user_name.', '.date('g:i a', $replay->create_at).', '.date('j F, Y', $replay->create_at).'</span>
                            </div>';
                        }
                        echo '
                    </div>
                </div>
            </div>';
        }
    }

    public function askQuestion(Request $request)
    {
        $question = new GigQuestion();
        $question->user_id = Auth::user()->id;
        $question->gig_id = $request->gig_id;
        $question->question = $request->question;
        $question->save();
        $notification=array(
              'messege'=>'Successfully submited!',
             'alert-type'=>'success'
         );
        return Redirect()->back()->with($notification);

    }

    public function questionReplay(Request $request)
    {
        $replay = new GigQuestionReplay();
        $replay->user_id = Auth::user()->id;
        $replay->question_id = $request->question_id;
        $replay->replay = $request->replay;
        $replay->save();
        $notification=array(
              'messege'=>'Successfully submited!',
             'alert-type'=>'success'
         );
        return Redirect()->back()->with($notification);

    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showOrderForm($page_id, $id)
    {
        $page_details = WorkerPage::where('id', $page_id)->where('status', 'active')->where('visibility', 'show')->first();
        if ($page_details) {
            $membership = Membership::where('user_id', $page_details->worker_id)->where('ending_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))->first();
        }
        else {
            abort(404);
        }

        if ($membership) {
            $service = PageService::find(Crypt::decryptString($id));
            return view('customer.home.serviceorder-form',compact('service'));
        }
        else {
            abort(404);
        }
    }

    public function gigList($service_id,$budget,$min_budget,$max_budget,$delivery_time,$rating,$timely_delivery_rate,$order_complete_rate,$now_online,$recent_online,$recent_order_delivery){

        $service = WorkerService::findOrFail($service_id);

        if (isset($budget) && $budget != 0) {
            if ($budget == 'High To Low') {
                $gigs = WorkerGig::where('service_id',$service_id)->orderByDesc('budget')->get();
            }else{
                $gigs = WorkerGig::where('service_id',$service_id)->get();
            }
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $Word = $worker->word_road_id;
                $workerWord = explode(',', $Word);
                if ($Word != NULL){
                    foreach ($workerWord as $w) {
                        if ($w == auth()->user()->word_road_id) {
                            $check = true;
                        }
                    }
                    if ($check == true){

                        echo '
                        <div class="col-lg-3 col-6 mb-1">
                            <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                <div class="" style="margin-top: 113px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                            <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                            $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                            if ($percent>80){
                                                echo $star = 5;
                                            }else if ($percent>60){
                                                echo $star = 4;
                                            }else if ($percent>40){
                                                echo $star = 3;
                                            }else if ($percent>20){
                                                echo $star = 2;
                                            }else if ($percent>1){
                                                echo $star = 1;
                                            }else{
                                                echo $star = 0;
                                            }
                                            echo '
                                            ('.$worker->rating->rateGivenBy.')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                        </div>';

                    }
                }
            }
        }else if (isset($min_budget)  && $min_budget!= 0 && isset($max_budget) && $max_budget!= 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->whereBetween('budget', [$min_budget, $max_budget])->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $Word = $worker->word_road_id;
                $workerWord = explode(',', $Word);
                if ($Word != NULL){
                    foreach ($workerWord as $w) {
                        if ($w == auth()->user()->word_road_id) {
                            $check = true;
                        }
                    }
                    if ($check == true){

                        echo '
                        <div class="col-lg-3 col-6 mb-1">
                            <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                <div class="" style="margin-top: 113px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                            <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                            $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                            if ($percent>80){
                                                echo $star = 5;
                                            }else if ($percent>60){
                                                echo $star = 4;
                                            }else if ($percent>40){
                                                echo $star = 3;
                                            }else if ($percent>20){
                                                echo $star = 2;
                                            }else if ($percent>1){
                                                echo $star = 1;
                                            }else{
                                                echo $star = 0;
                                            }
                                            echo '
                                            ('.$worker->rating->rateGivenBy.')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                        </div>';

                    }
                }
            }
        }else if (isset($delivery_time) && $delivery_time != 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->where('day', '>=', $delivery_time)->orderByDesc('day')->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $Word = $worker->word_road_id;
                $workerWord = explode(',', $Word);
                if ($Word != NULL){
                    foreach ($workerWord as $w) {
                        if ($w == auth()->user()->word_road_id) {
                            $check = true;
                        }
                    }
                    if ($check == true){

                        echo '
                        <div class="col-lg-3 col-6 mb-1">
                            <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                <div class="" style="margin-top: 113px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                            <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                            $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                            if ($percent>80){
                                                echo $star = 5;
                                            }else if ($percent>60){
                                                echo $star = 4;
                                            }else if ($percent>40){
                                                echo $star = 3;
                                            }else if ($percent>20){
                                                echo $star = 2;
                                            }else if ($percent>1){
                                                echo $star = 1;
                                            }else{
                                                echo $star = 0;
                                            }
                                            echo '
                                            ('.$worker->rating->rateGivenBy.')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                        </div>';

                    }
                }
            }
        }else if (isset($rating) && $rating != 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->where('day', '>=', $delivery_time)->orderByDesc('day')->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                if ($percent >= $rating) {
                    $Word = $worker->word_road_id;
                    $workerWord = explode(',', $Word);
                    if ($Word != NULL){
                        foreach ($workerWord as $w) {
                            if ($w == auth()->user()->word_road_id) {
                                $check = true;
                            }
                        }
                        if ($check == true){

                            echo '
                            <div class="col-lg-3 col-6 mb-1">
                                <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                    <div class="" style="margin-top: 113px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                                <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                if ($percent>80){
                                                    echo $star = 5;
                                                }else if ($percent>60){
                                                    echo $star = 4;
                                                }else if ($percent>40){
                                                    echo $star = 3;
                                                }else if ($percent>20){
                                                    echo $star = 2;
                                                }else if ($percent>1){
                                                    echo $star = 1;
                                                }else{
                                                    echo $star = 0;
                                                }
                                                echo '
                                                ('.$worker->rating->rateGivenBy.')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                            </div>';

                        }
                    }
                }
            }
        }else if (isset($timely_delivery_rate) && $timely_delivery_rate != 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $bids = DB::table('customer_bids')
                        ->join('worker_gigs','worker_gigs.id','customer_bids.worker_gig_id')
                        ->join('users','worker_gigs.worker_id','users.id')
                        ->select('customer_bids.*')
                        ->where('worker_gigs.worker_id',$worker->id)->get();
                $complete = 0;
                $others = 0;
                foreach ($bids as $row) {
                    if ($row->status == 'completed') {
                        $complete++;
                    }else{
                        $others++;
                    }
                }
                $Deliverypercent =  $complete / ($complete + $others) * 100;

                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                if ($Deliverypercent >= $timely_delivery_rate) {
                    $Word = $worker->word_road_id;
                    $workerWord = explode(',', $Word);
                    if ($Word != NULL){
                        foreach ($workerWord as $w) {
                            if ($w == auth()->user()->word_road_id) {
                                $check = true;
                            }
                        }
                        if ($check == true){

                            echo '
                            <div class="col-lg-3 col-6 mb-1">
                                <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                    <div class="" style="margin-top: 113px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                                <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                if ($percent>80){
                                                    echo $star = 5;
                                                }else if ($percent>60){
                                                    echo $star = 4;
                                                }else if ($percent>40){
                                                    echo $star = 3;
                                                }else if ($percent>20){
                                                    echo $star = 2;
                                                }else if ($percent>1){
                                                    echo $star = 1;
                                                }else{
                                                    echo $star = 0;
                                                }
                                                echo '
                                                ('.$worker->rating->rateGivenBy.')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                            </div>';

                        }
                    }
                }
            }
        }else if (isset($order_complete_rate) && $order_complete_rate != 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $bids = DB::table('customer_bids')
                        ->join('worker_gigs','worker_gigs.id','customer_bids.worker_gig_id')
                        ->join('users','worker_gigs.worker_id','users.id')
                        ->select('customer_bids.*')
                        ->where('worker_gigs.worker_id',$worker->id)->get();
                $complete = 0;
                $others = 0;
                foreach ($bids as $row) {
                    if ($row->status == 'completed') {
                        $complete++;
                    }else{
                        $others++;
                    }
                }
                $Deliverypercent =  $complete / ($complete + $others) * 100;

                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                if ($Deliverypercent >= $order_complete_rate) {
                    $Word = $worker->word_road_id;
                    $workerWord = explode(',', $Word);
                    if ($Word != NULL){
                        foreach ($workerWord as $w) {
                            if ($w == auth()->user()->word_road_id) {
                                $check = true;
                            }
                        }
                        if ($check == true){

                            echo '
                            <div class="col-lg-3 col-6 mb-1">
                                <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                    <div class="" style="margin-top: 113px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                                <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                if ($percent>80){
                                                    echo $star = 5;
                                                }else if ($percent>60){
                                                    echo $star = 4;
                                                }else if ($percent>40){
                                                    echo $star = 3;
                                                }else if ($percent>20){
                                                    echo $star = 2;
                                                }else if ($percent>1){
                                                    echo $star = 1;
                                                }else{
                                                    echo $star = 0;
                                                }
                                                echo '
                                                ('.$worker->rating->rateGivenBy.')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                            </div>';

                        }
                    }
                }
            }
        }else if (isset($now_online) && $now_online != 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                if ($worker->last_login_at != 'NULL' && $worker->last_logout_at == 'NULL') {
                    $Word = $worker->word_road_id;
                    $workerWord = explode(',', $Word);
                    if ($Word != NULL){
                        foreach ($workerWord as $w) {
                            if ($w == auth()->user()->word_road_id) {
                                $check = true;
                            }
                        }
                        if ($check == true){

                            echo '
                            <div class="col-lg-3 col-6 mb-1">
                                <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                    <div class="" style="margin-top: 113px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                                <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                if ($percent>80){
                                                    echo $star = 5;
                                                }else if ($percent>60){
                                                    echo $star = 4;
                                                }else if ($percent>40){
                                                    echo $star = 3;
                                                }else if ($percent>20){
                                                    echo $star = 2;
                                                }else if ($percent>1){
                                                    echo $star = 1;
                                                }else{
                                                    echo $star = 0;
                                                }
                                                echo '
                                                ('.$worker->rating->rateGivenBy.')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                            </div>';
                        }
                    }
                }
            }
        }else if (isset($recent_online) && $recent_online != 0) {
            // echo "working";
            $gigs = WorkerGig::where('service_id',$service_id)->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                    $Word = $worker->word_road_id;
                    $workerWord = explode(',', $Word);
                    if ($Word != NULL){
                        foreach ($workerWord as $w) {
                            if ($w == auth()->user()->word_road_id) {
                                $check = true;
                            }
                        }
                        if ($check == true && $worker->id == $gig->worker_id && $worker->last_logout_at != 'NULL' && $worker->last_logout_at <= Carbon::now()){

                            echo '
                            <div class="col-lg-3 col-6 mb-1">
                                <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                    <div class="" style="margin-top: 113px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                                <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                if ($percent>80){
                                                    echo $star = 5;
                                                }else if ($percent>60){
                                                    echo $star = 4;
                                                }else if ($percent>40){
                                                    echo $star = 3;
                                                }else if ($percent>20){
                                                    echo $star = 2;
                                                }else if ($percent>1){
                                                    echo $star = 1;
                                                }else{
                                                    echo $star = 0;
                                                }
                                                echo '
                                                ('.$worker->rating->rateGivenBy.')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                            </div>';
                        }
                    }
                
            }
        }else if (isset($recent_order_delivery) && $recent_order_delivery != 0) {
             // echo "working";
            $gigs = WorkerGig::where('service_id',$service_id)->get();
            foreach($gigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;

                $Word = $worker->word_road_id;
                $workerWord = explode(',', $Word);
                if ($Word != NULL){
                    foreach ($workerWord as $w) {
                        if ($w == auth()->user()->word_road_id) {
                            $check = true;
                        }
                    }
                    if ($check == true && $worker->id == $gig->worker_id){
                        if (DB::table('customer_bids')
                        ->join('worker_gigs','worker_gigs.id','customer_bids.worker_gig_id')
                        ->join('users','worker_gigs.worker_id','users.id')
                        ->where('worker_gigs.worker_id',$worker->id)
                        ->where('customer_bids.status','completed')->exists()) {
                            echo '
                            <div class="col-lg-3 col-6 mb-1">
                                <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                    <div class="" style="margin-top: 113px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                                <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                                $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                if ($percent>80){
                                                    echo $star = 5;
                                                }else if ($percent>60){
                                                    echo $star = 4;
                                                }else if ($percent>40){
                                                    echo $star = 3;
                                                }else if ($percent>20){
                                                    echo $star = 2;
                                                }else if ($percent>1){
                                                    echo $star = 1;
                                                }else{
                                                    echo $star = 0;
                                                }
                                                echo '
                                                ('.$worker->rating->rateGivenBy.')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                            </div>';
                        }
                    }
                }
            }
        }else{
            foreach($service->workerGigs as $gig){
                $check = false;
                $worker = User::find($gig->worker_id);

                $Word = $worker->word_road_id;
                $workerWord = explode(',', $Word);
                if ($Word != NULL){
                    foreach ($workerWord as $w) {
                        if ($w == auth()->user()->word_road_id) {
                            $check = true;
                        }
                    }
                    if ($check == true){

                        echo '
                        <div class="col-lg-3 col-6 mb-1">
                            <div class="card pt-2 pb-2" style="background-image: url('.asset('uploads/images/product1.jpg').');height: 170px;">
                                <div class="" style="margin-top: 113px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <span class="badge badge-success">৳ '.$gig->budget .'</span><br>
                                            <span class="badge badge-success"><i class="fa fa-clock"></i> '.$gig->day .' Hours</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-right text-warning"><i class="fa fa-star"></i>';
                                            $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                            if ($percent>80){
                                                echo $star = 5;
                                            }else if ($percent>60){
                                                echo $star = 4;
                                            }else if ($percent>40){
                                                echo $star = 3;
                                            }else if ($percent>20){
                                                echo $star = 2;
                                            }else if ($percent>1){
                                                echo $star = 1;
                                            }else{
                                                echo $star = 0;
                                            }
                                            echo '
                                            ('.$worker->rating->rateGivenBy.')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <figcaption class="figure-caption "><a class="text-primary" href="'.route('customer.showGigDetail',$gig->id).'"><b>'.\Illuminate\Support\Str::limit($gig->title, 80).'</b></a></figcaption>
                        </div>';

                    }
                }
            }
        }
    }
}
