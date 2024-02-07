<?php

namespace App\Http\Controllers\Controller;

use App\ControllerNotice;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('controller.notice.index');
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
            'title' => 'nullable',
            'detail' => 'required',
        ]);
        $notice = new ControllerNotice();
        $notice->controller_id = Auth::user()->id;
        $notice->title = $request->input('title');
        $notice->detail = $request->input('detail');
        $notice->save();
        return $notice;
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
            'title' => 'nullable',
            'detail' => 'required',
        ]);
        $notice = ControllerNotice::find($id);
        $notice->title = $request->input('title');
        $notice->detail = $request->input('detail');
        $notice->save();
        return $notice;
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

    public function enable($id)
    {
        $notice = ControllerNotice::find($id);
        $notice->is_active = 1;
        $notice->save();
        return redirect()->back()->with('success', 'Notice activated successfully');
    }

    public function disabled($id)
    {
        $notice = ControllerNotice::find($id);
        $notice->is_active = 0;
        $notice->save();
        return redirect()->back()->with('success', 'Notice disabled successfully');
    }
}
