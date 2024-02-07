<?php

namespace App\Http\Controllers\MarketingPanel;

use App\Blog;
use App\Http\Controllers\Controller;
use App\WorkerService;
use App\WorkerServiceCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
class BlogController extends Controller
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
        $blogs = Blog::all();
        return view('marketing_panel.blog.index',compact('categories','services','blogs'));
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
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'thumbnail_img' => 'image|required',
        ]);
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->category_id = $request->input('category');
        $blog->description = $request->input('description');
        $blog->user_id = Auth::user()->id;

        //Auto resize with 500 wide/ 500 height
        if($request->hasFile('thumbnail_img')){
            $image             = $request->file('thumbnail_img');
            $folder_path       = 'uploads/images/blog/';
            $image_new_name    = Str::random(8).'-marketer-blog--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $blog->thumbnail_img    = $folder_path.$image_new_name;
        }

        $blog->save();
        return $blog;
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
        $blog = Blog::find($id);
        $services = WorkerService::all();//orderBy('id', 'desc')->get()
        $categories = WorkerServiceCategory::orderBy('id', 'desc')->get();
        return view('marketing_panel.blog.edit',compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // $id = $request->input('id');
         return $request->all();
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $blog =  Blog::find($id);
        // return $blog;
        $blog->title = $request->input('title');
        $blog->category_id = $request->input('category');
        $blog->description = $request->input('description');
        $blog->user_id = Auth::user()->id;

        //Auto resize with 500 wide/ 500 height
        if($request->hasFile('thumbnail_img')){
            $image             = $request->file('thumbnail_img');
            $folder_path       = 'uploads/images/blog/';
            $image_new_name    = Str::random(8).'-marketer-blog--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $blog->thumbnail_img    = $folder_path.$image_new_name;
        }

        $blog->update();
        return redirect()->route('marketing_panel.blog.index')->with('success','Updated Succesfully Done');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
      $blog = Blog::find($id);
      dd($blog);
      if($blog){
        $blog->delete();
        return redirect()->route('marketing_panel.blog.index')->with('success','Blog Delete Succesfully Done');
      }else{
        return redirect()->route('marketing_panel.blog.index')->with('warning','Something went wrong');
      }

    }
}
