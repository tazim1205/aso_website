<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use App\Faq;
use App\ServiceDetail;
use App\About;
use App\TermsAndCondition;
use App\PrivacyPolicy;
use App\MarketerTrainingVideos;
use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.setting.offer', compact('pages '));
    }

    // faq
    public function faqindex()
    {
        $customer_faq = Faq::where('faq_for','customer')->get();
        $marketer_faq = Faq::where('faq_for','marketer')->get();
        $serviceprovider_faq = Faq::where('faq_for','service provider')->get();
        return view('admin.page.faq-add', compact('customer_faq','marketer_faq','serviceprovider_faq'));
    }

    public function faqStore(Request $request)
    {
        $request->validate([
            'faq_for' => 'required',
        ]);
        $faq = new Faq();
        $faq->faq_for = $request->input('faq_for');
        $faq->question = $request->input('faq_question');
        $faq->answer = $request->input('faq_answer');
        $faq->save();
        return $faq;
    }

    public function faqUpdate(Request $request)
    {
        $request->validate([
            'faq_for' => 'required',
        ]);
        $faq = Faq::find($request->faq_id);
        $faq->faq_for = $request->input('faq_for');
        $faq->question = $request->input('faq_question');
        $faq->answer = $request->input('faq_answer');
        $faq->save();
        return $faq;
    }


    public function faqDestroy(Request $request){
        $id = $request->input('id');
        $faq = Faq::find($id);

        $faq->delete();
        return $faq;
    }


    // service details
    public function servicedetailsindex()
    {
        $customer_faq = ServiceDetail::where('faq_for','customer')->get();
        $marketer_faq = ServiceDetail::where('faq_for','marketer')->get();
        $serviceprovider_faq = ServiceDetail::where('faq_for','service provider')->get();
        return view('admin.page.service-details', compact('customer_faq','marketer_faq','serviceprovider_faq'));
    }

    public function servicedetailsStore(Request $request)
    {
        $request->validate([
            'faq_for' => 'required',
        ]);
        $faq = new ServiceDetail();
        $faq->faq_for = $request->input('faq_for');
        $faq->question = $request->input('faq_question');
        $faq->answer = $request->input('faq_answer');
        $faq->save();
        return $faq;
    }

    public function servicedetailsUpdate(Request $request)
    {
        $request->validate([
            'faq_for' => 'required',
        ]);
        $faq = ServiceDetail::find($request->faq_id);
        $faq->faq_for = $request->input('faq_for');
        $faq->question = $request->input('faq_question');
        $faq->answer = $request->input('faq_answer');
        $faq->save();
        return $faq;
    }

    public function servicedetailsDestroy($id){
        $faq = ServiceDetail::find($id);

        $faq->delete();
        return redirect()->back()->with('success', 'Service Details Deleted Successfully');
    }


     // about
    public function aboutIndex()
    {
        $about = About::orderByDesc('id')->first();
        return view('admin.page.about', compact('about'));
    }

    public function aboutUpdate(Request $request)
    {
        $request->validate([
            'about' => 'required',
        ]);
        $about = About::find($request->id);
        $about->about = $request->input('about');
        $about->save();
        return redirect()->back();
        // return $about;
    }

     // terms and condition
    public function termsConditionIndex()
    {
        $customer_terms = TermsAndCondition::where('about_for', 'customer')->orderByDesc('id')->first();
        $marketer_terms = TermsAndCondition::where('about_for', 'marketer')->orderByDesc('id')->first();
        $service_provider_terms = TermsAndCondition::where('about_for', 'service provider')->orderByDesc('id')->first();
        return view('admin.page.terms-condition', compact('customer_terms','marketer_terms','service_provider_terms'));
    }

    public function termsConditionUpdate(Request $request)
    {
        $request->validate([
            'about' => 'required',
        ]);
        $about = TermsAndCondition::find($request->id);
        $about->about = $request->input('about');
        $about->save();
        return redirect()->back();
        // return $about;
    }

     // privacy policy
    public function privacypolicyIndex()
    {
        $customer_privacy = PrivacyPolicy::where('about_for', 'customer')->orderByDesc('id')->first();
        $marketer_privacy = PrivacyPolicy::where('about_for', 'marketer')->orderByDesc('id')->first();
        $service_provider_privacy = PrivacyPolicy::where('about_for', 'service provider')->orderByDesc('id')->first();
        return view('admin.page.privacy-policy', compact('customer_privacy','marketer_privacy','service_provider_privacy'));
    }

    public function privacypolicyUpdate(Request $request)
    {
        $request->validate([
            'about' => 'required',
        ]);
        $privacy = PrivacyPolicy::find($request->id);
        $privacy->about = $request->input('about');
        $privacy->save();
        return redirect()->back();
        // return $about;
    }

    // training 

    public function trainingsVideo()
    {
        $user_id = Auth::user()->id;
        $allads = MarketerTrainingVideos::where('controller_id', $user_id)->orderBy('id', 'desc')->get();

        $customer = MarketerTrainingVideos::where('controller_id', $user_id)->where('video_for', 'Customer')->orderByDesc('id')->get();
        $marketer = MarketerTrainingVideos::where('controller_id', $user_id)->where('video_for', 'Marketer')->orderByDesc('id')->get();
        $service_provider = MarketerTrainingVideos::where('controller_id', $user_id)->where('video_for', 'Worker')->orderByDesc('id')->get();
        return view('admin.page.training-video', compact('customer','marketer','service_provider'));
    }

    public function trainingsVideostore(Request $request)
    {
        $request->validate([
            'title'           => 'required',
        ]);

        $user = User::where('id',Auth::user()->id)->first();
        $ads = new MarketerTrainingVideos();
        $ads->controller_id = Auth::user()->id;
        $ads->link = $request->input('detail');
        $ads->video_for = $request->video_for;
        $ads->title = $request->input('title');

        if ($request->has('activation') && $request->input('activation') ==1){
            $ads->status = 1;
        }else{
            $ads->status = 0;
        }
        $ads->save();
        return $ads;
    }

    public function trainingsVideoupdate(Request $request)
    {

        // return var_dump($request->video_for);
        // exit();

        $id = $request->input('id');
        $request->validate([
            'title'           => 'required',
            'video_for'           => 'required',
        ]);

        $ads = MarketerTrainingVideos::find($id);
        $ads->link = $request->input('detail');
        $ads->title = $request->input('title');
        $ads->video_for = $request->video_for;

        if ($request->has('activation') && $request->input('activation') ==1){
            $ads->status = 1;
        }else{
            $ads->status = 0;
        }
        $ads->save();

        return $ads;
    }

    public function trainingsVideodelete(Request $request)
    {
        $id = $request->input('id');
        $ads = MarketerTrainingVideos::find($id);

        $ads->delete();
        return $ads;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page = Page::find($id);
        return view('admin.page.edit', compact('page'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request)
    {
        $request->validate([
            'page'   =>  'required|exists:pages,id',
            'en_name'   =>  'required|string|min:1|max:50|unique:pages,en_name,'.$request->input('page'),
            'bn_name'   =>  'required|string|min:1|max:50|unique:pages,bn_name,'.$request->input('page'),
            'en_title'  =>  'nullable|string|max:250',
            'bn_title'  =>  'nullable|string|max:250',
            'en_image'  =>  'nullable|image|max:500',
            'bn_image'  =>  'nullable|image|max:500',
            'en_description'    =>  'nullable|min:3|max:15000',
            'bn_description'    =>  'nullable|min:3|max:15000',
        ]);

        $page = Page::find($request->input('page'));
        $page->en_name      = $request->input('en_name');
        $page->bn_name      = $request->input('bn_name');
        $page->slug         = Str::slug($request->input('en_name')) ;
        $page->en_title     = $request->input('en_title');
        $page->bn_title     = $request->input('bn_title');
        $page->en_description        = $request->input('en_description');
        $page->bn_description        = $request->input('bn_description');

        if($request->hasFile('en_image')){
            $image             = $request->file('en_image');
            $folder_path       = 'uploads/images/pages/';
            $image_new_name    = Str::random(8).'-en_page-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(600, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $page->en_image    = $folder_path.$image_new_name;
        }
        if($request->hasFile('bn_image')){
            $image             = $request->file('bn_image');
            $folder_path       = 'uploads/images/pages/';
            $image_new_name    = Str::random(8).'-bn_page-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(600, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $page->bn_image    = $folder_path.$image_new_name;
        }
        $page->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
