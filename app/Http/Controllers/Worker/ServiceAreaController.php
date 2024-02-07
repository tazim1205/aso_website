<?php

namespace App\Http\Controllers\Worker;

use App\User;
use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceAreaController extends Controller
{	
	/**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {	
        $user = User::findOrFail(auth()->user()->id);
    	$district = District::all();
    	$upazila = Upazila::all();

    	$puroshova = Puroshova::where('upazila_id', $user->upazila_id)
                    ->get();

    	$word = Word::all();
       	

        $pouroshava_union = $user->pouroshova_union_id;
        $userpouroshava = explode(',', $pouroshava_union);

        $word_road =$user->word_road_id;
        $userword = explode(',', $word_road);

        return view('worker.home.service-area', compact('user', 'district','upazila','puroshova','word','userpouroshava','userword'));
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

        $pouroshava = [];
        $pouroshava_string = '';
        $word = '';
        // for ($i=0; $i <count($request->all) ; $i++) { 
        //     $pouroshava .= $request->all[$i];
        //     $pouroshava .= ',';
        // }

        for ($i=0; $i <count($request->word_road_id) ; $i++) { 
            $word .= $request->word_road_id[$i];
            $word .= ',';

            $words = Word::findOrFail($request->word_road_id[$i]);
            array_push($pouroshava, $words->puroshova_id);
            
        }
        array_unique($pouroshava);
        $pouroshava_string = implode(",", $pouroshava);
        
        $user->pouroshova_union_id = $pouroshava_string;
        $user->word_road_id = $word;

        // if ($request->all) {
        //     $pouroshava = '';
        //     $word = '';
        //     foreach ($request->all as $key => $val) {
        //         if (in_array($val, $request->all))
        //         {
        //             $p = Puroshova::findOrFail($val);
        //             $pouroshava.= $p->id;
        //             $pouroshava.=',';

        //             $word_by_pouroshava = Word::where('puroshova_id', $val)->get();
        //             foreach ($word_by_pouroshava as $wp) {
        //                 $word.= $wp->id;
        //                 $word.=',';
        //             }
        //             $a = $request->word_road_id;
        //             $word_road_id = implode(',', $a);
        //             $word.= $word_road_id;
        //         }
        //     }
        //     $user->pouroshova_union_id = $pouroshava;
        //     $user->word_road_id = $word;
        // }else{
        //     $pouroshava = '';
        //     foreach ($request->word_road_id as $key => $val) {
        //         if (in_array($val, $request->word_road_id))
        //         {
        //             $word = Word::findOrFail($val);
        //             $pouroshava.= $word->puroshova_id;
        //             $pouroshava.=',';
        //         }
        //     }
        //     $user->pouroshova_union_id = $pouroshava;
        //     $a = $request->word_road_id;
        //     $user->word_road_id = implode(',', $a);
        // }
        $user->location =   $request->location;
        $user->save();
        return back()->withSuccess('Successfully updated');
    }

    public function GetPouroshavaWord($id)
    {   
        $user = User::findOrFail(auth()->user()->id); 
        $puroshova = Puroshova::where('upazila_id', $id)->get();
        $pouroshava_union = $user->pouroshova_union_id;
        $userpouroshava = explode(',', $pouroshava_union);

        $word_road =$user->word_road_id;
        $userword = explode(',', $word_road);

        foreach($puroshova as $row){
        echo '<div class="col-lg-12"></div>
        <div class="col-lg-12 mt-3">
            <div class="d-flex justify-content-between bg-success p-2" style="border-radius: 5px;">
                <div class="text-light text-capitalize">
                    '.$row->name.'
                </div>
                
            </div>
            <div class="mt-1" style="border-radius: 5px;border: 1px solid #00bb32;">';   
                $words = Word::where('puroshova_id', $row->id)
                                    ->get();
                foreach($words as $w){
                echo '
                <div class="d-flex justify-content-between p-2" >
                    <div class="text-capitalize" style="color: #027321;">
                       '.$w->name.'
                    </div>
                    <div class=" text-success">';
                        if(in_array($w->id, $userword)){
                        echo '    
                        <input type="checkbox" name="word_road_id[]" id="" checked="" value="'.$w->id.'">';
                        }else{
                        echo '    
                        <input type="checkbox" name="word_road_id[]" id="" value="'.$w->id.'">';
                        }
                    echo '    
                    </div>
                </div>';
                }
            echo '   
            </div>
        </div>
        <div class="col-lg-4"></div>';
        }
    }

}
?>