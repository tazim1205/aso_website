<?php

namespace App\Http\Controllers\Controller;

use App\Complain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplainController extends Controller
{
    public function customerComplain($status = 'submitted')
    {
        $customers = Auth::user()->upazila->customers;
        if ($status == 'submitted') {
            return view('controller.complain.customer-complain', compact('customers'));
        } else if ($status == 'resolved') {
            return view('controller.complain.customer-complain-resolved', compact('customers'));
        }
    }

    // customer Complain Update
    public function customerComplainUpdate($complain_id)
    {

        $complain = Complain::findOrFail($complain_id);
        $complain->is_completed = true;

        try {
            $complain->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully updated status.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Error !!! ' . $exception->getMessage(),
            ]);
        }
    }
}
