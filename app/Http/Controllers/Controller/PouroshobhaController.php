<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Puroshova;
class PouroshobhaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pouroshovas = Puroshova::where('upazila_id', auth()->user()->upazila_id)->orderBy('id','desc')->get();
        return view('controller.area.puroshobha.index',compact('pouroshovas'));
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
            'name' => 'required|unique:puroshovas',
        ]);
        $puroshobha = new Puroshova();
        $puroshobha->name = $request->input('name');
        $puroshobha->upazila_id = auth()->user()->upazila_id;
        $puroshobha->save();
        return $puroshobha;
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
        $request->validate([
            'name' => "required|unique:puroshovas,name,$id",
        ]);

        $puroshobha = Puroshova::find($id);
        $puroshobha->name = $request->input('name');
        $puroshobha->upazila_id = auth()->user()->upazila_id;
        $puroshobha->save();
        return $puroshobha;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pouroshova = Puroshova::find($id);
        $pouroshova->delete();
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function enable(Request $request){
        $pouroshova = Puroshova::find($request->id);
        $pouroshova->status = 1;
        $pouroshova->save();
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function disable(Request $request){
        $pouroshova = Puroshova::find($request->id);
        $pouroshova->status = 0;
        $pouroshova->save();
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
