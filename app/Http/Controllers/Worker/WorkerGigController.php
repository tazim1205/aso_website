<?php

namespace App\Http\Controllers\Worker;

use App\Gig;
use App\Http\Controllers\Controller;

use App\WorkerGig;
use App\WorkerServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\GigQuestion;
use App\GigQuestionReplay;

use Carbon\Carbon;
use App\MembershipPackage;
use App\AdminAds;
use App\AdminNotice;
use App\PageService;
use App\User;

use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class WorkerGigController extends Controller
{
    public function index()
    {
        $packages = MembershipPackage::all();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        $adminNotice = AdminNotice::orderBy('id', 'desc')
            ->take(1)
            ->get();
        $categories = WorkerServiceCategory::orderBy('id', 'asc')->get();
        $your_services = PageService::where('worker_id', Auth::id())->get();
        return view('worker.gig.pages.gig', compact('categories', 'packages', 'adminAds', 'adminNotice', 'your_services'));
    }

    public function services()
    {
        return view('worker.gig.pages.service');
    }

    public function page()
    {
        return view('worker.gig.pages.page');
    }

    public function membership()
    {
        return view('worker.gig.pages.membership');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|min:3|max:100',
            'description'       => 'required|string|min:15|max:5000',
            'service'           => 'required|exists:worker_services,id',
            'day'               => 'required|numeric|min:1',
            'tags'              => 'nullable|string|min:3|max:200',
            'price'             => 'required|numeric|min:10',
            // 'cover_photo'             => 'required|image',
            'thambline_photo'             => 'required|image',
        ]);

        $gig = new WorkerGig();

        $gig->worker_id         =   auth()->user()->id;
        $gig->title             =   $request->input('title');
        $gig->description       =   $request->input('description');
        $gig->service_id        =   $request->input('service');
        $gig->day               =   $request->input('day');
        $gig->tags              =   $request->input('tags');
        $gig->budget            =   $request->input('price');

        if($request->hasFile('thambline_photo')){
            $image             = $request->file('thambline_photo');
            $folder_path       = 'uploads/images/worker/gigs/';
            $image_new_name    = Str::random(8).'-worker-gig--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $gig->cover_photo    = $folder_path.$image_new_name;
        }

        if($request->hasFile('thambline_photo')){
            $image             = $request->file('thambline_photo');
            $folder_path       = 'uploads/images/worker/gigs/';
            $image_new_name    = Str::random(8).'-worker-gig-thambline--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $gig->thambline_photo    = $folder_path.$image_new_name;
        }

        $gig->save();
        return  $gig;

    }

    public function show($id){

        $workerGig = WorkerGig::find(Crypt::decryptString($id));
        if ($workerGig->worker->id == Auth::user()->id){
            return view('worker.gig.show', compact('workerGig'));
        }else{
            return redirect()->back();
        }
    }

    public function edit($id){

        $workerGig = WorkerGig::find(Crypt::decryptString($id));
        $categories = WorkerServiceCategory::all();
        if ($workerGig->worker->id == Auth::user()->id){
            return view('worker.gig.edit', compact('workerGig','categories'));
        }else{
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'gig'               => 'required|exists:worker_gigs,id',
            'title'             => 'required|string|min:3|max:100',
            'description'       => 'required|string|min:15|max:5000',
            'service'           => 'required|exists:worker_services,id',
            'day'               => 'required|numeric|min:1',
            'tags'              => 'nullable|string|min:3|max:200',
            'price'             => 'required|numeric|min:10',
        ]);

        $gig = WorkerGig::find($request->input('gig'));
        if ($gig->worker->id == Auth::user()->id){
            $gig->title             =   $request->input('title');
            $gig->description       =   $request->input('description');
            $gig->service_id        =   $request->input('service');
            $gig->day               =   $request->input('day');
            $gig->tags              =   $request->input('tags');
            $gig->budget            =   $request->input('price');

            if($request->hasFile('thambline_photo')){
                $request->validate([
                    'thambline_photo'             => 'image',
                ]);
                if (file_exists($gig->thambline_photo)){
                    unlink($gig->thambline_photo);
                }
                $image             = $request->file('thambline_photo');
                $folder_path       = 'uploads/images/worker/gigs/';
                $image_new_name    = Str::random(8).'-worker-gig--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->resize(1000, 300, function($constraint){
                    $constraint->aspectRatio();
                })->save($folder_path.$image_new_name);
                $gig->cover_photo    = $folder_path.$image_new_name;
            }

            if($request->hasFile('thambline_photo')){
                $request->validate([
                    'thambline_photo'             => 'image',
                ]);
                if (file_exists($gig->thambline_photo)){
                    unlink($gig->thambline_photo);
                }
                $image             = $request->file('thambline_photo');
                $folder_path       = 'uploads/images/worker/gigs/';
                $image_new_name    = Str::random(8).'-worker-gig-thambline--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                    $constraint->aspectRatio();
                })->save($folder_path.$image_new_name);
                $gig->thambline_photo    = $folder_path.$image_new_name;
            }

            $gig->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully gig updated',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Permission denied',
            ]);
        }
    }

    public function delete(Request $request){
        $request->validate([
           'gig' => 'required|exists:worker_gigs,id'
        ]);
        $gig = WorkerGig::find($request->input('gig'));
        if ($gig->worker->id == Auth::user()->id){
            if (file_exists($gig->cover_photo)){
                unlink($gig->cover_photo);
            }
            if (file_exists($gig->thambline_photo)){
                unlink($gig->thambline_photo);
            }
            $gig->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully gig deleted',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Permission denied',
            ]);
        }
    }

    public function replayPage($question_id,$gig_id)
    {
        return view('worker.home.replay',compact('question_id','gig_id'));
    }

    public function gigQuestion($gig_id, $show)
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
                                    <a href="'.route('worker.deletereplay',$replay->id).'" class="text-danger">Delete</a>';
                                }
                            echo '
                            </div>';
                        }
                        echo '
                        <div class="col-12 pl-4">
                            <a href="'.route('worker.replaypage',[$row->id,$gig_id]).'" class="text-info">Replay</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
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
        return Redirect()->route('worker.showWorkerGig',Crypt::encryptString($request->gig_id))->with($notification);

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
}


