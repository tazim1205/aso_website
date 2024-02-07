<?php

namespace App\Http\Controllers\Worker\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('membership.profile.index');
    }
}
