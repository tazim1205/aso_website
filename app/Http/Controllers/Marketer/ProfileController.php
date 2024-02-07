<?php

namespace App\Http\Controllers\Marketer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){

        return view('marketer.profile.index');
    }

    public function edit()
    {
        return view('marketer.profile.edit-profile');
    }
}
