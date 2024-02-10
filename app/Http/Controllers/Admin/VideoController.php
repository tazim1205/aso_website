<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('admin.video.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required'
        ]);

        $video = Video::create([
            'link' => $request->link,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return $video;
    }

    public function update(Request $request)
    {
        $request->validate([
            'link' => 'required'
        ]);

        $video = Video::find($request->id);
        $video->update([
            'link' => $request->link,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return $video;
    }

    public function destroy($id)
    {
        $video = video::find($id)->delete();

        return redirect()->back()->with('success');
    }
}
