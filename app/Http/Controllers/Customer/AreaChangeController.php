<?php

namespace App\Http\Controllers\Customer;

use App\User;
use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaChangeController extends Controller
{	
	/**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {	
    	$district = District::all();
    	$upazila = Upazila::all();
    	$puroshova = Puroshova::all();
    	$word = Word::all();
       	$user = User::findOrFail(auth()->user()->id);
        return view('customer.home.area-change', compact('user', 'district','upazila','puroshova','word'));
    }

    public function GetUpozila($id)
    {
    	$upozila_by_district = Upazila::where('district_id', $id)
				               ->get();
        return json_encode($upozila_by_district);
    }

    public function GetPouroshavaUnion($id)
    {
    	$pouroshava_by_upozila = Puroshova::where('upazila_id', $id)
				               ->get();
        return json_encode($pouroshava_by_upozila);
    }

    public function GetWordRoad($id)
    {
    	$word_by_pouroshava = Word::where('puroshova_id', $id)
				               ->get();
        return json_encode($word_by_pouroshava);
    }

    public function UpdateCustomerArea(Request $request)
    {
    	$user = User::findOrFail(auth()->user()->id);

        $user->upazila_id   =  $request->upazila_thana_id;
        $user->district_id =$request->district_id;
        $user->pouroshova_union_id  =   $request->pouroshava_union_id;
        $user->word_road_id =   $request->word_road_id;
        $user->location =   $request->location;

        $user->save();
        return back()->withSuccess('Successfully updated');
    }


}
?>