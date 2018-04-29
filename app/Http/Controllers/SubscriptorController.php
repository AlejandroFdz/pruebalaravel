<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptorController extends Controller
{
    public function dashboard()
    {
      return view('subscriptor.dashboard');
    }
}
