<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class WorkerServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = WorkerServiceCategory::all();//orderBy('id', 'desc')->get()
        return view('admin.worker-service-category.index', compact('categories'));
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
        $request->validate([
            'name' => 'required|unique:worker_service_categories',
        ]);
        $category = new WorkerServiceCategory();
        $category->name = $request->input('name');
        $category->meta_tag = $request->input('meta_tag');
        //Auto resize with 500 wide/ 500 height
        if($request->hasFile('icon')){
            $image              = $request->file('icon');
            $OriginalExtension  = $image->getClientOriginalExtension();
            $image_name         =$request->input('name').'-worker-service-category-'. Carbon::now()->format('d-m-Y H-i-s') .'.'. $OriginalExtension;
            $destinationPath    = ('uploads/images/worker/service-category');
            $resize_image       = Image::make($image->getRealPath());
            $resize_image->resize(500, 500, function($constraint){
                $constraint->aspectRatio();
            });
            $resize_image->save($destinationPath . '/' . $image_name);
            $category->icon    = $image_name;
        }
        $category->save();
        return $category;
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
        //return WorkerServiceCategory::find($id);
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
            'name' => "required|unique:worker_service_categories,name,$id",
        ]);

        $category = WorkerServiceCategory::find($id);

        $category->name = $request->input('name');
        $category->meta_tag = $request->input('meta_tag');
        //Auto resize with 500 wide/ 500 height
        if($request->hasFile('icon')){
            $image              = $request->file('icon');
            $OriginalExtension  = $image->getClientOriginalExtension();
            $image_name         =$request->input('name').'-worker-service-category-'. Carbon::now()->format('d-m-Y H-i-s') .'.'. $OriginalExtension;
            $destinationPath    = ('uploads/images/worker/service-category');
            $resize_image       = Image::make($image->getRealPath());
            $resize_image->resize(500, 500, function($constraint){
                $constraint->aspectRatio();
            });
            $resize_image->save($destinationPath . '/' . $image_name);
            $category->icon    = $image_name;
        }
        $category->save();
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = WorkerServiceCategory::find($id)->delete();

        return redirect()->back()->with('success');
    }
}
