<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;

use App\User;
use App\WorkerGig;
use App\WorkerPage;
use App\PageService;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class WorkerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function workerGigs($status = "pending")
    {
        if($status == "pending"){
            $data = WorkerGig::join('users', 'worker_gigs.worker_id', '=', 'users.id')
                    ->select('worker_gigs.*', 'users.full_name')
                    ->where('worker_gigs.status', 'pending')
                    ->where('users.upazila_id', auth()->user()->upazila_id)
                    ->get();

        }else if($status == "active"){
            $data = WorkerGig::join('users', 'worker_gigs.worker_id', '=', 'users.id')
                    ->select('worker_gigs.*', 'users.full_name')
                    ->where('worker_gigs.status', 'active')
                    ->where('users.upazila_id', auth()->user()->upazila_id)
                    ->get();
        }else{
            $data = WorkerGig::join('users', 'worker_gigs.worker_id', '=', 'users.id')
                    ->select('worker_gigs.*', 'users.full_name')
                    ->where('worker_gigs.status', 'disabled')
                    ->where('users.upazila_id', auth()->user()->upazila_id)
                    ->get();
        }
        return view('controller.dashboard.worker-gigs', compact('data', 'status'));
    }

    public function WorkerGigUnderMeData()
    {
        $data = DB::table('worker_gigs')
                ->join('users','worker_gigs.worker_id','users.id')
                ->select('worker_gigs.*','users.full_name')
                ->where('worker_gigs.status',0)
                ->where('users.upazila_id',auth()->user()->upazila_id)
                ->get();

        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->updated_at);
                $newformat = date('d-m-Y',$mydate);
                return $newformat;
            })
            ->addColumn('link', function($data) {
                if (!empty($data->status->status) && $data->status->status == 1){
                    return '<a href="'.route('controller.workergig.deactive',$data->id).'" id="deactive" title="Click To Deactive" class="btn btn-lg btn-warning"> <i class="fa fa-toggle-on text-white"></i></a>';
                }else{
                    return '<a href="'.route('controller.workergig.active',$data->id).'" id="active" title="Click To Active" class="btn btn-lg btn-danger"> <i class="fa fa-toggle-off text-white"></i></a>';
                }
            })
            ->addColumn('Actions', function($data) {
                return '<a href="" id="'.$data->id.'" class="seeBtn btn btn-success btn-sm">Details </a>
                        <a href="" id="'.$data->id.'" class="editBtn btn btn-info btn-sm">Edit </a>';
            })
            ->rawColumns(['link','Actions'])
            ->make(true);
    }

    public function deactive($id){
        // dd($id);
        $gig = WorkerGig::find($id);
        $gig->status = 'disabled';
        $gig->save();
        return back()->with('success','Gig Deactivated Successfull');
    }

    public function gigUpdate(Request $request){
        $gig = WorkerGig::find($request->gig_id);
        $gig->title = $request->title;
        $gig->description = $request->description;
        if (isset($request->category)) {
            $gig->service_id = $request->category;
        }
        $gig->budget = $request->budget;
        $gig->day = $request->day;
        $gig->tags = $request->tags;
        $gig->save();
        return back()->with('success','Gig Update Successfull');
    }


    /*
    *---------------Marketer Active
    */
    public function active($id){
        $gig = WorkerGig::find($id);
        $gig->status = 'active';
        $gig->save();
        return back()->with('success','Gig Activated Successfull');
    }
    public function pending($id){
        $gig = WorkerGig::find($id);
        $gig->status = 'pending';
        $gig->save();
        return back()->with('success','Gig Activated Successfull');
    }

    public function Editdetails($id){
        $gig = WorkerGig::where('id', $id)->firstOrFail();
        return json_encode($gig);
    }

    public function details($id){
        $gig = WorkerGig::where('id', $id)->firstOrFail();

            echo '
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i> '.$gig->title.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-header">
                <i class="fa ">Budget: ৳'.$gig->budget.'</i>
                <i class="fa fa-clock"> '.$gig->day.' Hours</i>
                <i class="fa fa-tags">Tag: '.$gig->tags.'</i>
            </div>
            <div class="modal-body" id="modal-body">
                '.$gig->description.'
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
            </div>';

    }

    // worker pages


    public function workerPage($status = "pending")
    {
        if($status == "pending"){
            $data = WorkerPage::join('users', 'worker_pages.worker_id', '=', 'users.id')
            ->select('worker_pages.*', 'users.full_name')
            ->where('worker_pages.status', 'pending')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->get();
        }else if($status == "active"){
            $data = WorkerPage::join('users', 'worker_pages.worker_id', '=', 'users.id')
            ->select('worker_pages.*', 'users.full_name')
            ->where('worker_pages.status', 'active')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->get();
        }else{
            $data = WorkerPage::join('users', 'worker_pages.worker_id', '=', 'users.id')
            ->select('worker_pages.*', 'users.full_name')
            ->where('worker_pages.status', 'disabled')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->get();
        }
        return view('controller.dashboard.worker-pages', compact('data','status'));
    }


    public function WorkerPageUnderMeData()
    {
        $data = DB::table('worker_pages')
                ->join('users','worker_pages.worker_id','users.id')
                ->select('worker_pages.*','users.full_name')
                ->where('worker_pages.status',0)
                ->where('users.upazila_id',auth()->user()->upazila_id)
                ->get();

        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->updated_at);
                $newformat = date('d-m-Y',$mydate);
                return $newformat;
            })
            ->addColumn('link', function($data) {
                if (!empty($data->status->status) && $data->status->status == 1){
                    return '<a href="'.route('controller.worker.page.deactive',$data->id).'" id="deactive" title="Click To Deactive" class="btn btn-lg btn-warning btn-sm"> <i class="fa fa-toggle-on text-white"></i></a>';
                }else{
                    return '<a href="'.route('controller.worker.page.active',$data->id).'" id="active" title="Click To Active" class="btn btn-lg btn-danger btn-sm"> <i class="fa fa-toggle-off text-white"></i></a>';
                }
            })
            ->addColumn('Actions', function($data) {
                return '<a href="" id="'.$data->id.'" class="seeBtn btn btn-success btn-sm">Details </a>
                        <a href="" id="'.$data->id.'" class="editPageBtn btn btn-info btn-sm">Edit </a>';
            })
            ->rawColumns(['link','Actions'])
            ->make(true);
    }


    public function Pagedetails($id){
        $page = WorkerPage::where('id', $id)->firstOrFail();

            echo '
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i> '.$page->title.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-header">
                <i class="fa" style="font-weight: bold;">Name: '.$page->name.'</i>
            </div>
            <div class="modal-header">
                <i class="fa fa-phone">'.$page->phone.'</i>
                <i class="fa fa-map-marker"> '.$page->address.'</i>
            </div>
            <div class="modal-header">
                <i class="fa fa-map"> Location: '.$page->location.'</i>
            </div>
            <div class="modal-body" id="modal-body">
                '.$page->description.'
            </div>

            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
            </div>';
    }

    public function PageEditdetails($id){
        $page = WorkerPage::where('id', $id)->firstOrFail();
        return json_encode($page);
    }


    public function pageUpdate(Request $request){
        $page = WorkerPage::find($request->page_id);
        $page->title = $request->title;
        $page->name = $request->name;
        $page->description = $request->description;
        $page->phone = $request->phone;
        $page->address = $request->address;
        $page->location = $request->location;
        $page->save();
        return back()->with('success','Page Update Successfull');
    }

    public function pagedeactive($id){
        // dd($id);
        $page = WorkerPage::find($id);
        $page->status = 'disabled';
        $page->save();
        return back()->with('success','Page Deactivated Successfull');
    }


    /*
    *---------------Marketer Active
    */
    public function pageactive($id){
        $page = WorkerPage::find($id);
        $page->status = 'active';
        $page->save();
        return back()->with('success','Page Activated Successfull');
    }
    public function pagePending($id){
        $page = WorkerPage::find($id);
        $page->status = 'pending';
        $page->save();
        return back()->with('success','Page Activated Successfull');
    }


    // worker services


    public function workerservice($status ="pending")
    {
        if($status == "pending"){
            $data = PageService::join('users', 'page_services.worker_id', '=', 'users.id')
            ->select('page_services.*', 'users.full_name')
            ->where('page_services.status', 'pending')
                ->where('users.upazila_id', auth()->user()->upazila_id)
            ->get();
        }else if($status == "active"){
            $data = PageService::join('users', 'page_services.worker_id', '=', 'users.id')
            ->select('page_services.*', 'users.full_name')
            ->where('page_services.status', 'active')
                ->where('users.upazila_id', auth()->user()->upazila_id)
            ->get();
        }else{
            $data = PageService::join('users', 'page_services.worker_id', '=', 'users.id')
            ->select('page_services.*', 'users.full_name')
            ->where('page_services.status', 'disabled')
                ->where('users.upazila_id', auth()->user()->upazila_id)
            ->get();
        }
        return view('controller.dashboard.worker-services', compact('data', 'status'));
    }


    public function WorkerServiceUnderMeData()
    {
        $data = DB::table('page_services')
                ->join('users','page_services.worker_id','users.id')
                ->select('page_services.*','users.full_name')
                ->where('page_services.status',0)
                ->where('users.upazila_id',auth()->user()->upazila_id)
                ->get();

        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate);
                return $newformat;
            })
            ->addColumn('link', function($data) {
                if (!empty($data->status->status) && $data->status->status == 1){
                    return '<a href="'.route('controller.worker.service.deactive',$data->id).'" id="deactive" title="Click To Deactive" class="btn btn-lg btn-warning btn-sm"> <i class="fa fa-toggle-on text-white"></i></a>';
                }else{
                    return '<a href="'.route('controller.worker.service.active',$data->id).'" id="active" title="Click To Active" class="btn btn-lg btn-danger btn-sm"> <i class="fa fa-toggle-off text-white"></i></a>';
                }
            })
            ->addColumn('Actions', function($data) {
                return '<a href="" id="'.$data->id.'" class="seeBtn btn btn-success btn-sm">Details </a>
                        <a href="" id="'.$data->id.'" class="editServiceBtn btn btn-info btn-sm">Edit </a>';
            })
            ->rawColumns(['link','Actions'])
            ->make(true);
    }

    public function Servicedetails($id){
        $gig = PageService::where('id', $id)->firstOrFail();

            echo '
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i> '.$gig->title.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-header">
                <i class="fa ">Budget: ৳'.$gig->budget.'</i>
                <i class="fa fa-clock"> '.$gig->day.' Hours</i>
                <i class="fa fa-tags">Tag: '.$gig->tags.'</i>
            </div>
            <div class="modal-body" id="modal-body">
                '.$gig->description.'
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
            </div>';
    }


    public function ServiceEditdetails($id){
        $service = PageService::where('id', $id)->firstOrFail();
        return json_encode($service);
    }

    public function serviceUpdate(Request $request){
        $service = PageService::find($request->service_id);
        $service->title = $request->title;
        $service->description = $request->description;
        $service->budget = $request->budget;
        $service->day = $request->day;
        $service->tags = $request->tags;
        $service->save();
        return back()->with('success','Service Update Successfull');
    }


    public function servicedeactive($id){
        // dd($id);
        $gig = PageService::find($id);
        $gig->status = 'disabled';
        $gig->save();
        return back()->with('success','Service Deactivated Successfull');
    }


    /*
    *---------------Marketer Active
    */
    public function serviceactive($id){
        $gig = PageService::find($id);
        $gig->status = 'active';
        $gig->save();
        return back()->with('success','Service Activated Successfull');
    }

    public function servicePending($id){
        $gig = PageService::find($id);
        $gig->status = 'pending';
        $gig->save();
        return back()->with('success','Service Activated Successfull');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
