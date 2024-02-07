<?php

namespace App\Http\Controllers\Admin;

use App\Complain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    public function customerComplain(){
        $complains = Complain::all();
        return view('admin.complain.customer-complain',compact('complains'));
    }

    // customer Complain Update
    public function customerComplainUpdate($complain_id){

        $complain = Complain::findOrFail($complain_id);
        $complain->is_completed = true;

        try {
            $complain->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully updated status.',
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'type' => 'danger',
                'message' => 'Error !!! '.$exception->getMessage(),
            ]);
        }
    }
}
