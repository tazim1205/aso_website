<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CustomerOrderQuantityController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->upazila->customers;
        return view('controller.customer.order-quantity', compact('customer'));
    }
}
