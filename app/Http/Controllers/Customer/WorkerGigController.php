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
use App\MembershipPackage;
use App\PageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Crypt;

class WorkerGigController extends Controller
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
        $service = WorkerService::where('meta_tag', $id)->orwhere('id',$id)->first();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        $pages = WorkerPage::where('visibility', 'show')->where('status', 'active')->latest()->inRandomOrder()->get();
        $mamberships = MembershipPackage::withTrashed()->orderby('position', 'asc')->get();
            
        return view('customer.home.gigs',compact('service','adminAds', 'pages', 'mamberships'));
    }

    /**
     * Customer home>service>worker gigs> details
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showGigDetail($id)
    {

        $gig = WorkerGig::find($id);
        return view('customer.home.gig-detail',compact('gig'));
    }

    public function replayPage($question_id,$gig_id)
    {
        return view('customer.home.replay',compact('question_id','gig_id'));
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
            $createdAt1 = Carbon::parse($row->created_at);
            echo '
            <div class="d-flex" id="">
                <div class="p-2">
                    <h4><i class="fa fa-question-circle text-success"></i> </h4>
                </div>
                <div class="">
                    <h4>'.$row->question.'</h4>
                    <span>'.$user->user_name.', '.$createdAt1->format('g:i a').', '.$createdAt1->format('j F, Y').'</span>
                    <div class="row mt-1">';
                        $replays = GigQuestionReplay::where('question_id', $row->id)->get();
                        foreach ($replays as $replay) {
                            $user2 = User::find($replay->user_id);
                            $createdAt = Carbon::parse($replay->created_at);
                        echo '
                            <div class="col-12 pl-4">
                                <h5 class=""><i class="fa fa-check-circle text-info"></i> <a href="" class="text-primary"></a> '.$replay->replay.'</h5>
                                <span>'.$user2->user_name.', '.$createdAt->format('g:i a').', '.$createdAt->format('j F, Y').'</span><br>';
                                if ($user2->id == auth()->user()->id) {
                                    echo '
                                    <a href="'.route('customer.deletereplay',$replay->id).'" class="text-danger">Delete</a>';
                                }
                            echo '
                            </div>';
                        }
                        echo '
                        <div class="col-12 pl-4">
                            <a href="'.route('customer.replaypage',[$row->id,$gig_id]).'" class="text-info">Replay</a>
                        </div>
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
                    <br>
                    <a href="'.route('customer.deletequestion',$row->id).'" class="text-danger">Delete</a>
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
        return Redirect()->route('customer.showGigDetail',$request->gig_id)->with($notification);

    }

    public function deleteQuestion($question_id){
        $question = GigQuestion::find($question_id);
        $question->delete();
        $notification=array(
              'messege'=>'Successfully submited!',
             'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function deleteReplay($replay_id){
        $replay = GigQuestionReplay::find($replay_id);
        $replay->delete();
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
    public function showOrderForm($id)
    {

        $gig = WorkerGig::find(Crypt::decryptString($id));
        return view('customer.home.order-form',compact('gig'));
    }

    public function gigList($service_id,$budget,$min_budget,$max_budget,$delivery_time,$rating,$timely_delivery_rate,$order_complete_rate,$now_online,$recent_online,$recent_order_delivery){

        $service = WorkerService::find($service_id);
        $query = WorkerGig::serviceId($service_id)->active();
        if (isset($budget) && $budget != 0) {
            if ($budget == 'High To Low') {
                $gigs = $query->orderByDesc('budget')->get();
            }else{
                $gigs = $query->get();
            }

            return  view('customer.home.single-gig', compact('gigs'));

        }else if (isset($min_budget)  && $min_budget!= 0 && isset($max_budget) && $max_budget!= 0) {
            $gigs = $query->whereBetween('budget', [$min_budget, $max_budget])->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($delivery_time) && $delivery_time != 0) {
            $gigs = WorkerGig::where('service_id',$service_id)->where('status', 'active')->where('day', '>=', $delivery_time)->orderByDesc('day')->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($rating) && $rating != 0) {
            $gigs = $query->where('day', '>=', $delivery_time)->orderByDesc('day')->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($timely_delivery_rate) && $timely_delivery_rate != 0) {
            $gigs = $query->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($order_complete_rate) && $order_complete_rate != 0) {
            $gigs = $query->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($now_online) && $now_online != 0) {
            $gigs = $query->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($recent_online) && $recent_online != 0) {
            // echo "working";
            $gigs = $query->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else if (isset($recent_order_delivery) && $recent_order_delivery != 0) {
             // echo "working";
            $gigs = $query->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }else{
            $gigs = $query->get();
            return  view('customer.home.single-gig', compact('gigs'));
        }
    }

    public function search(Request $request){

        $gigs=DB::table('worker_gigs')->where('title','LIKE','%'.$request->search_text."%")->orWhere('description','LIKE','%'.$request->search_text."%")->orWhere('tags','LIKE','%'.$request->search_text."%")->where('status', 1)->get();

        $pages=DB::table('worker_pages')->where('title','LIKE','%'.$request->search_text."%")->orWhere('name','LIKE','%'.$request->search_text."%")->orWhere('description','LIKE','%'.$request->search_text."%")->where('status', 1)->get();

        $PageService = PageService::where('status', 1)->where('title','LIKE','%'.$request->search_text."%")->orWhere('description','LIKE','%'.$request->search_text."%")->orWhere('tags','LIKE','%'.$request->search_text."%")->get();
        foreach ($PageService as $row) {
            $page_info = WorkerPage::where('worker_services', 'like', '%'.$row->id.'%')->first();
            $row->page = $page_info->id;
        }

        // var_dump($PageService);
        // exit();
        return view('customer.home.search',compact('gigs','pages','PageService'));
    }
}
