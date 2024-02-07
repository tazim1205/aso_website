<?php

namespace App\Http\Controllers\MarketingPanel;

use App\MarketerControllerNotice;
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
        $user_id = Auth::user()->id;
        $notices = MarketerControllerNotice::where('controller_id', $user_id)->orderBy('id', 'desc')->get();
        return view('marketing_panel.notice.index', compact('notices'));
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
        $notice = new MarketerControllerNotice();
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
        $notice = MarketerControllerNotice::find($id);
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
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $notice = MarketerControllerNotice::find($id);
        $notice->delete();
        return $notice;
    }
}
