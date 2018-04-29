<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WatsonController extends Controller
{
    public function index()
    {
    	return view('watson.index');
    }
}
