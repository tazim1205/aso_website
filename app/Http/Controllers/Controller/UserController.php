<?php

namespace App\Http\Controllers\Controller;

use App\AffiliateUser;
use App\CustomerWorkerHelplines;
use App\Http\Controllers\Controller;

use App\SpecialService;
use App\User;
use App\UserUsefulFile;
use App\WorkerService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $special_services = SpecialService::all();
        return view('controller.user.index', compact('special_services'));
    }

    public function userStatus($id)
    {
        $user = User::find($id);
        if ($user->status == 0) {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->save();
        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    public function userBadge($id)
    {

        $user = User::find($id);
        if ($user->is_verified == 0) {
            $user->is_verified = 1;
        } else {
            $user->is_verified = 0;
        }
        $user->save();
        return redirect()->back()->with('success', 'User badge updated successfully.');
    }

    public function userUsefulDocDelete($id)
    {
        $file = UserUsefulFile::find($id);

        if ($file->file) {
            unlink($file->file);
        }
        $file->delete();
        return back()->with('success', 'File has been deleted.');
    }

    public function workerBalanceReset($id)
    {

        $user = User::find($id);
        $user->recharge_amount = 0;
        $user->save();
        return back()->with('success', 'Balance reset successfully.');
    }

    public function spByCategory()
    {
        $workerServices = WorkerService::withCount('users')->get();
        return view('controller.user.sp-category', compact('workerServices'));
    }

    public function membershipByCategory()
    {
        $workerServices = WorkerService::withCount('memberships')->get();
        return view('controller.user.membership-category', compact('workerServices'));
    }

    public function affiliateMarketer()
    {
        $affiliate = AffiliateUser::with('user')->get();
        return view('controller.user.affiliate', compact('affiliate'));
    }

    public function customer()
    {
        return view('controller.user.customer');
    }

    public function updateCustomer(Request  $request){
        $id = $request->input('id');
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]);

        $worker = User::find($id);
        $worker->full_name = $request->input('full_name');
        $worker->phone = $request->input('phone');
        $worker->email = $request->email;
        $worker->save();
        return response()->json($worker, 200);
    }

    public function deleteCustomer(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        $user->delete();
        return response()->json($user, 200);
    }

    public function worker()
    {
        return view('controller.user.worker');
    }

    public function updateWorker(Request  $request){
        $id = $request->input('id');
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'recharge_amount' => 'required'
        ]);

        $worker = User::find($id);
        $worker->full_name = $request->input('full_name');
        $worker->phone = $request->input('phone');
        $worker->recharge_amount = $request->recharge_amount;
        $worker->save();
        return response()->json($worker, 200);
    }

    public function deleteWorker(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        $user->delete();
        return response()->json($user, 200);
    }

    public function workerById($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
}
