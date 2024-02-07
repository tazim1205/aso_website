<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //for phone
    public function username()
    {
        return 'phone';
    }
    //Over write login view
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //Over write login
    public function login(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            if (current_language() != 'en') {
                session()->flash('message', 'আপনি যে মোবাইল নাম্বারটি দিয়েছেন তা কোনও অ্যাকাউন্টের সাথে মেলে না। একটি অ্যাকাউন্টের জন্য সাইন আপ করুন। ');
            } else {
                session()->flash('message', 'The phone number that you\'ve entered doesn\'t match any account. Sign up for an account.');
            }
            session()->flash('type', 'danger');
            return back();
        }
        else if ($user->role == 'worker') {
            if (worker_payment_check($user->id) != 'Payment-Clear') {
                return view('guest.worker-payment')->with('user', $user)->with('purpose', worker_payment_check($user->id));
            } else if ($user->status != '1') {
                if (current_language() != 'en') {
                    session()->flash('message', 'আপনার পেমেন্ট সম্পন্ন হয়েছে। আপনার প্রোফাইল এক্টিভ করা হলে আপনাকে জানানো হবে। ');
                } else {
                    session()->flash('message', 'Your payment is completed.You will be notified when your profile is activated.');
                }
                session()->flash('type', 'danger');
                return redirect(route('controller-list',1));
            }
        }





        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'status' => 1])) {
                Auth::user()->last_login_at = Carbon::now();
                // Auth::user()->last_logout_at = 'NULL';
                Auth::user()->save();
                session()->flash('message', 'Login success.');
                session()->flash('type', 'success');
                //Admin
                if (Auth::user()->role == 'admin') {
                    return redirect(route('admin.dashboard.index'));
                }

                //Controller
                if (Auth::user()->role == 'controller') {
                    return redirect(route('controller.dashboard.index'));
                }

                //Marketing Panel
                if (Auth::user()->role == 'marketing_panel') {
                    return redirect(route('marketing_panel.dashboard.index'));
                }

                //Marketer
                if (Auth::user()->role == 'marketer') {
                    return redirect(route('marketer.home.index'));
                }

                //Worker
                if (Auth::user()->role == 'worker') {
                    return redirect(route('worker.home.index'));
                }

                //Membership
                if (Auth::user()->role == 'membership') {
                    return redirect(route('membership.home.index'));
                }

                //Customer
                if (Auth::user()->role == 'customer') {
                    return redirect(route('customer.home.index'));
                }

                //Accountant
                if (Auth::user()->role == 'accountant') {
                    return redirect()->route('accountant.dashboard');
                }
                //Unknown type
                else {
                    session()->flash('message', 'Non-permitted role.');
                    session()->flash('type', 'danger');
                    Auth::logout();
                    return redirect('/login');
                }
            } else {
                $this->incrementLoginAttempts($request);
                session()->flash('message', ' This account is disabled. Please, contact to your area controller office to active this account.');
                session()->flash('type', 'warning');
                return redirect()->back();
            }
        } else {
            $this->incrementLoginAttempts($request);
            if (current_language() != 'en') {
                session()->flash('message', 'আপনি যে পাসওয়ার্ড দিয়েছেন তা এই অ্যাকাউন্টের সাথে মেলে না।');
            } else {
                session()->flash('message', 'The password  that you\'ve entered doesn\'t match this account.');
            }

            //            session()->flash('message', 'Credentials do not match our database.');
            session()->flash('type', 'warning');
            return redirect()->back();
        }
    }


}
