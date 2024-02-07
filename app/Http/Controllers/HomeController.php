<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Blog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function authedUserPasswordChange(Request $request){
        $request->validate([
            'current'=> 'required',
            'password'=> 'required|min:6|max:32',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $password = User::where('id', auth()->user()->id)->first();

        $user->password =  Hash::make($request->input('password'));

        // if ($password->password === Hash::make($request->input('current'))) {
        if (Hash::check($request->input('current'), $password->password)) {
            $user->save();
            return redirect()->back()->with('message', 'Password Change Successfully!!');            
        }else{
            return redirect()->back()->with('error', 'Current password not match.');
        }
        // try {
        //     if ($user->password == Hash::make($request->current)) {
        //         $user->save();
        //         return response()->json([
        //             'type' => 'success',
        //             'message' => 'Successfully new password saved.',
        //         ]);
        //     }else{
        //         return response()->json([
        //             'type' => 'danger',
        //             'message' => 'Current password not match.',
        //         ]);
        //     }
        // }catch (\Exception $exception){
        //     return response()->json([
        //         'type' => 'danger',
        //         'message' => 'Error !!! '.$exception->getMessage(),
        //     ]);
        // }  
    }

    public function changeModeAsCustomer(){
        
        // return redirect(route('worker.home.index'))->with('success','Gig Deactivated Successfull');

        $user = User::where('id', auth()->user()->id)->first();
        $phone = $user->phone;
        $password = $user->password;

        $user->remember_token = 'worker';
        $user->role = 'customer';
        $user->save();
        return redirect(route('customer.home.index'))->with('success','You successfully login as customer');

        // Auth::logout();

        // if (Auth::attempt(['phone' => $phone, 'password' => $password, 'status' => 1])) {

        //     Auth::user()->last_login_at = Carbon::now();
        //     // Auth::user()->last_logout_at = 'NULL';
        //     Auth::user()->save();
            
        //     //Admin
        //     if (Auth::user()->role == 'admin') {
        //         return redirect(route('admin.dashboard.index'));
        //     }

        //     //Controller
        //     if (Auth::user()->role == 'controller') {
        //         return redirect(route('controller.dashboard.index'));
        //     }

        //     //Marketing Panel
        //     if (Auth::user()->role == 'marketing_panel') {
        //         return redirect(route('marketing_panel.dashboard.index'));
        //     }

        //     //Marketer
        //     if (Auth::user()->role == 'marketer') {
        //         return redirect(route('marketer.home.index'));
        //     }

        //     //Worker
        //     if (Auth::user()->role == 'worker') {
        //         return redirect(route('worker.home.index'));
        //     }

        //     //Membership
        //     if (Auth::user()->role == 'membership') {
        //         return redirect(route('membership.home.index'));
        //     }
            
        //     //Customer
        //     if (Auth::user()->role == 'customer') {
        //         return redirect(route('customer.home.index'));
        //     }
        //     //Unknown type
        //     else {
        //         session()->flash('message', 'Non-permitted role.');
        //         session()->flash('type', 'danger');
        //         Auth::logout();
        //         return redirect('/login');
        //     }
        //     return redirect(route('customer.home.index'))->with('success','Gig Deactivated Successfull');
        // } else {
        //     // $this->incrementLoginAttempts($request);
        //     return redirect(route('customer.home.index'))->with('success','Gig Deactivated Successfull');
        // }
    }

    public function changeModeAsWorker(){
        $user = User::where('id', auth()->user()->id)->first();
        $phone = $user->phone;
        $password = $user->password;

        $user->remember_token = 'worker';
        $user->role = 'worker';
        $user->save();
        return redirect(route('worker.home.index'))->with('success','You successfully login as worker');

    }

    public function changeModeAsMarketer(){
        $user = User::where('id', auth()->user()->id)->first();
        $phone = $user->phone;
        $password = $user->password;

        $user->remember_token = 'marketer';
        $user->role = 'marketer';
        $user->save();
        return redirect(route('marketer.home.index'))->with('success','You successfully login as marketer');

    }
    //Single Blog

    public function singleBlog($id){
        
        $blog = Blog::find($id);
        // return $blog;
        $blog->view_count += 1;
        $blog->save();
        return view('worker.home.single-blog',compact('blog'));
    }
}
