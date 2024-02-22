<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

use App\WorkerService;
use App\WorkerServiceCategory;
use App\Gig;
use App\User;
use App\GigOrder;
use Illuminate\Support\Facades\Auth;
use App\GigQuestion;
use App\GigQuestionReplay;
use App\WorkerGig;
use Carbon\Carbon;
use Response;

use App\SpecialProfile;
use App\AdminAds;
use App\AdminNotice;

use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;

use App\SpecialService;
use App\SpecialServiceOrder;
use App\MembershipPackage;
use App\WorkerPage;
use App\Blog;


use DB;

use App\Page;
use Illuminate\Http\Request;
use Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(Request $request){
        $district = District::all();
        $upazila = Upazila::all();
        $puroshova = Puroshova::all();
        $word = Word::all();
        // return 1;
        if($request->has('referral_code')){
            Cookie::queue('referral_code', $request->referral_code, 43200);
            Cookie::queue('gig_referral_code', $request->referral_code, 2880);
        }

        return view('guest.index');
    }

    //privacy policy
    public function privacyPolicy(){
        $privacy_policy = Page::where('slug', 'privacy-policy')->first();
        return view('guest.privacy-policy', compact('privacy_policy'));
    }

    //privacy policy
    public function termsAndConditions(){
        $terms_and_condition = Page::where('slug', 'terms-and-condition')->first();
        return view('guest.terms-and-conditions', compact('terms_and_condition'));
    }

    // get started
    public function Getstarted(Request $request){
        $district = District::all();
        $upazila = Upazila::all();
        $puroshova = Puroshova::all();
        $word = Word::all();
        $categories = WorkerServiceCategory::all();

        $adminNotice = AdminNotice::orderBy('id', 'desc')
            ->take(1)
            ->get();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        $specialServices = SpecialProfile::all();
        $data = [
            'district' => District::find($request->district_id, ['name']),
            'upazila' => Upazila::find($request->upazila_thana_id, ['name']),
            'puroshova' => Puroshova::find($request->pouroshava_union_id, ['name']),
            'word' => Word::find($request->word_road_id, ['name']),
        ];

        Session::put('location', $data);
        return view('guest.get-started',compact('categories','district','upazila','puroshova','word','adminNotice', 'adminAds','specialServices'));
    }

    public function jobpost(){
        return view('guest.jobpost');
    }

    public function changeArea()
    {
        $district = District::all();
        $upazila = Upazila::all();
        $puroshova = Puroshova::all();
        $word = Word::all();
        return view('guest.area-change', compact('district','upazila','puroshova','word'));
    }

    public function setAreaInCookie(Request $request){
        Cookie::queue('guest_district', $request->district_id, 60);
        Cookie::queue('guest_upazila', $request->upazila_thana_id, 60);
        Cookie::queue('guest_puroshova', $request->pouroshava_union_id, 60);
        Cookie::queue('guest_word', $request->word_road_id, 60);

        session()->flash('message', ' Area Changed.');
        session()->flash('type', 'success');
        return redirect('/get-started');
    }

    public function showService($id)
    {
        $district = District::all();
        $upazila = Upazila::all();
        $puroshova = Puroshova::all();
        $word = Word::all();
        $category = WorkerServiceCategory::find(Crypt::decryptString($id));
        return view('guest.service',compact('category','district','upazila','puroshova','word'));
    }

    public function showGig($id)
    {
        $district = District::all();
        $upazila = Upazila::all();
        $puroshova = Puroshova::all();
        $word = Word::all();
        $mamberships = MembershipPackage::withTrashed()->orderby('position', 'asc')->get();
        $service = WorkerService::find(Crypt::decryptString($id));
        $pages = WorkerPage::where('visibility', 'show')->where('status', 'active')->latest()->inRandomOrder()->get();
        
        return view('guest.gig',compact('service','district','upazila','puroshova','word','mamberships','pages'));
    }

    public function showGigDetails($id)
    {
        $district = District::all();
        $upazila = Upazila::all();
        $puroshova = Puroshova::all();
        $word = Word::all();
        $gig = WorkerGig::find($id);
        return view('guest.gig-details',compact('gig','district','upazila','puroshova','word'));
    }

    public function showSpecialProfiles($special_service_id){
        $special_service_name = SpecialProfile::find($special_service_id);
        if ($special_service_name != null){
            $special_profiles = SpecialProfile::find($special_service_id);
            return view('guest.speacial-profile',compact('special_profiles'))
                ->with('service', $special_service_name);
        }else{
            return redirect()->back();
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
                            <div class="col-12">
                                <h5><i class="fa fa-check-circle text-info"></i> <a href="" class="text-primary"></a> The next generation of the web’s favorite icon library + toolkit is now available as a Beta release!</h5>
                                <span>User_name, 08:45 pm, 25 Feb 2021</span>
                            </div>';
                        }
                        echo '
                    </div>
                </div>
            </div>';
        }
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showOrderForm($id)
    {

        $gig = WorkerGig::find(Crypt::decryptString($id));
        return view('guest.order-form',compact('gig'));
    }

    public function gigList($service_id,$budget,$min_budget,$max_budget,$delivery_time,$rating,$timely_delivery_rate,$order_complete_rate,$now_online,$recent_online,$recent_order_delivery){

        $service = WorkerService::find($service_id);
        $query = WorkerGig::serviceId($service_id)->active();
        if (isset($budget) && $budget != 0) {
            if ($budget == 'High To Low') {
                $gig = $query->orderByDesc('budget')->get();
            }else{
                $gig = $query->get();
            }

            return  view('guest.single-gig', compact('gig'));

        }else if (isset($min_budget)  && $min_budget!= 0 && isset($max_budget) && $max_budget!= 0) {
            $gig = $query->whereBetween('budget', [$min_budget, $max_budget])->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($delivery_time) && $delivery_time != 0) {
            $gig = WorkerGig::where('service_id',$service_id)->where('status', 'active')->where('day', '>=', $delivery_time)->orderByDesc('day')->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($rating) && $rating != 0) {
            $gig = $query->where('day', '>=', $delivery_time)->orderByDesc('day')->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($timely_delivery_rate) && $timely_delivery_rate != 0) {
            $gig = $query->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($order_complete_rate) && $order_complete_rate != 0) {
            $gig = $query->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($now_online) && $now_online != 0) {
            $gig = $query->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($recent_online) && $recent_online != 0) {
            // echo "working";
            $gig = $query->get();
            return  view('guest.single-gig', compact('gig'));
        }else if (isset($recent_order_delivery) && $recent_order_delivery != 0) {
             // echo "working";
            $gig = $query->get();
            return  view('guest.single-gig', compact('gig'));
        }else{
            $gig = $query->get();
            return  view('guest.single-gig', compact('gig'));
        }
    }

    public function search(Request $request){

        $gig=DB::table('worker_gig')->where('title','LIKE','%'.$request->search_text."%")->orWhere('description','LIKE','%'.$request->search_text."%")->orWhere('tags','LIKE','%'.$request->search_text."%")->where('status', 1)->get();

        $pages=DB::table('worker_pages')->where('title','LIKE','%'.$request->search_text."%")->orWhere('name','LIKE','%'.$request->search_text."%")->orWhere('description','LIKE','%'.$request->search_text."%")->where('status', 1)->get();

        $PageService = PageService::where('status', 1)->where('title','LIKE','%'.$request->search_text."%")->orWhere('description','LIKE','%'.$request->search_text."%")->orWhere('tags','LIKE','%'.$request->search_text."%")->get();
        foreach ($PageService as $row) {
            $page_info = WorkerPage::where('worker_services', 'like', '%'.$row->id.'%')->first();
            $row->page = $page_info->id;
        }

        // var_dump($PageService);
        // exit();
        return view('guest.search',compact('gig','pages','PageService'));
    }
}
