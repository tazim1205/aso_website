<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\WorkerService;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class WorkerServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = WorkerService::all();//orderBy('id', 'desc')->get()
        $categories = WorkerServiceCategory::orderBy('id', 'desc')->get();
        return view('admin.worker-service.index', compact('services', 'categories'));
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
        // return $request;
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'icon' => 'nullable|image',
        ]);
        $service = new WorkerService();
        $service->name = $request->input('name');
        $service->comission_rate = $request->input('comission_rate');
        $service->marketer_comission = $request->input('marketer_comission');
        $service->category_id = $request->input('category');
        $service->meta_tag = $request->input('meta_tag');
        //Auto resize with 500 wide/ 500 height
        if($request->hasFile('icon')){
            $image              = $request->file('icon');
            $OriginalExtension  = $image->getClientOriginalExtension();
            $image_name         =$request->input('name').'-worker-service-'. Carbon::now()->format('d-m-Y H-i-s') .'.'. $OriginalExtension;
            $destinationPath    = ('uploads/images/worker/service');
            $resize_image       = Image::make($image->getRealPath());
            $resize_image->resize(500, 500, function($constraint){
                $constraint->aspectRatio();
            });
            $resize_image->save($destinationPath . '/' . $image_name);
            $service->icon    = $image_name;
        }
        $service->save();
        return $service;
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
    public function update(Request $request)
    {

       
        $id = $request->input('id');
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            //'icon' => 'nullable|image',
        ]);
        $service = WorkerService::find($id);
        $service->name = $request->input('name');
        $service->category_id = $request->input('category');
        $service->meta_tag = $request->input('meta_tag');

        $service->comission_rate = $request->input('comission_rate');
        $service->marketer_comission = $request->input('marketer_comission');

        if (isset($request->gig_post)) {
            $service->gig_post = $request->gig_post;
        }
        if (isset($request->job_post)) {
            $service->job_post = $request->job_post;
        }
        if (isset($request->page_post)) {
            $service->page_post = $request->page_post;
        }

        //Auto resize with 500 wide/ 500 height
        if($request->hasFile('icon')){
            $image              = $request->file('icon');
            $OriginalExtension  = $image->getClientOriginalExtension();
            $image_name         =$request->input('name').'-worker-service-'. Carbon::now()->format('d-m-Y H-i-s') .'.'. $OriginalExtension;
            $destinationPath    = ('uploads/images/worker/service');
            $resize_image       = Image::make($image->getRealPath());
            $resize_image->resize(500, 500, function($constraint){
                $constraint->aspectRatio();
            });
            $resize_image->save($destinationPath . '/' . $image_name);
            $service->icon    = $image_name;
        }
        $service->save();
        return $service;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = WorkerService::find($id)->delete();

        return redirect()->back()->with('success');
    }
}
