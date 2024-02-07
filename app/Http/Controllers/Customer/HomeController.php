<?php

namespace App\Http\Controllers\Customer;

use App\AdminAds;
use App\AdminNotice;
use App\MarketerTrainingVideos;
use App\MarketerHelplines;
use App\Gig;
use App\GigOrder;
use App\SpecialProfile;

use App\Faq;
use App\ServiceDetail;
use App\About;
use App\TermsAndCondition;
use App\PrivacyPolicy;
use App\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\WorkerService;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = WorkerServiceCategory::all();
        $specialServices = SpecialProfile::all();
        $adminNotice = AdminNotice::orderBy('id', 'desc')
            ->take(1)
            ->get();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        //notify()->success('Laravel Notify is awesome!');
        return view('customer.home.index', compact('categories', 'adminNotice', 'adminAds','specialServices'));
    }

    /**
     * Display the specified resource.
     * Display services of this category
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showServices($id)
    {
        $category = WorkerServiceCategory::where('meta_tag' , $id)->orwhere('id',$id)->first();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        return view('customer.home.services',compact('category','adminAds'));
    }

    public function trainingVideo()
    {
        $user_id = Auth::user();
        $allVideo = MarketerTrainingVideos::where('district_id', $user_id->district_id)->where('upazila_id', $user_id->upazila_id)->where('status',1)->where('video_for','Customer')->orderBy('id', 'desc')->get();
        return view('customer.others.training-video', compact('allVideo'));
    }

    public function helpline()
    {

        return view('customer.others.helpline');
    }

    public function filterHelpline($filterFor,$district,$upazila)
    {
        
        $helpline = DB::table('customer_worker_helplines')->where('worker_or_customer', $filterFor)->where('district_id',$district)->where('upazila_id',$upazila)->whereNull('deleted_at')->get();
        foreach($helpline as $ads){
            echo '<div class="help-2">
                    <div class="help-0">
                        <p> এরিয়া /পৌরসভা /ইউনিয়ন</p>
                    </div>
                    <div class="help-3">
                        <div class="help-4">
                            <p>'. $ads->phone. '</p>
                        </div>
                        <div class="help-5">
                            <p>Call Now</p>
                        </div>
                    </div>

                    <div class="help-3">
                        <div class="help-4">
                            <p>' . $ads->email . '</p>
                        </div>
                        <div class="help-5">
                            <p>Email Now</p>
                        </div>
                    </div>

                </div>';
        }
    }

    public function Faq()
    {   
        $customer_faq = Faq::where('faq_for','customer')->get();
        return view('customer.others.faq', compact('customer_faq'));
    }

    public function serviceDetails()
    {   
        $customer_service = ServiceDetail::where('faq_for','customer')->get();
        return view('customer.others.service-details', compact('customer_service'));
    }

    public function about()
    {   
        $about = About::orderByDesc('id')->first();
        return view('customer.others.about', compact('about'));
    }

    public function termsCondition()
    {   
        $customer_terms = TermsAndCondition::where('about_for', 'customer')->orderByDesc('id')->first();
        return view('customer.others.terms-condition', compact('customer_terms'));
    }

    public function privacyPolicy()
    {   
        $customer_privacy = PrivacyPolicy::where('about_for', 'customer')->orderByDesc('id')->first();
        return view('customer.others.privacy-policy', compact('customer_privacy'));
    }

    public function singleBlog($id){
        
        $blog = Blog::find($id);
        // return $blog;
        $blog->view_count += 1;
        $blog->save();
        return view('customer.home.single-blog',compact('blog'));
    }

    public function createService()
    {
        $categories = WorkerServiceCategory::all();
        return view('customer.home.create', compact('categories'));
    }
}
