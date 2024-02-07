<?php

namespace App\Http\Controllers\Admin;

use App\ControllerNotice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $district = $request->input('district') ?? 'Áll';
        $upazila = $request->input('upazila') ?? 'Áll';
        $notices = ControllerNotice::orderBy('id', 'desc')
            ->district($district)
            ->upazila($upazila)
            ->active()
            ->get();
        $inactive_notices = ControllerNotice::orderBy('id', 'desc')
            ->district($district)
            ->upazila($upazila)
            ->inactive()
            ->get();
        return view('admin.controller-notice.index', compact('notices', 'inactive_notices'));
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
        $notice=ControllerNotice::find($id);
        $notice->delete();
        return redirect()->back()->with('success', 'Notice Deleted Successfully');
    }

    public function status($id)
    {
        $notice = ControllerNotice::find($id);
        if ($notice->is_active == 0) {
            $notice->is_active = 1;
        } else {
            $notice->is_active = 0;
        }
        $notice->save();
        return redirect()->back()->with('success', 'Notice Status Changed Successfully');
    }
}
