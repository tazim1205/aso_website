<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Puroshova;
use App\Word;
use Illuminate\Http\Request;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $pouroshobhas = Puroshova::where('upazila_id', auth()->user()->upazila_id)->orderBy('id','desc')->get();
        $pouroshobha_ids = [];

        foreach ($pouroshobhas as $row) {
            array_push($pouroshobha_ids,$row->id);
        }
        
        $wards = Word::whereIn('puroshova_id', $pouroshobha_ids)->orderBy('id','desc')->get();
        return view('controller.area.ward.index',compact('pouroshobhas','wards'));
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
            'name' => 'required',
            'pouroshobhaId' => 'required',
        ]);
        $word = new Word();
        $word->name = $request->input('name');
        $word->puroshova_id = $request->input('pouroshobhaId');
        $word->save();
        return $word;
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
            'name' => 'required',
            'pouroshobhaId' => 'required',
        ]);
        $word =  Word::find($id);
        $word->name = $request->input('name');
        $word->puroshova_id = $request->input('pouroshobhaId');
        $word->save();
        return $word;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $word = Word::find($id);
        $word->delete();
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function enable(Request $request){
        $word = Word::find($request->id);
        $word->status = 1;
        $word->save();
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function disable(Request $request){
        $word = Word::find($request->id);
        $word->status = 0;
        $word->save();
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
