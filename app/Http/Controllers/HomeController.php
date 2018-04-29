<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Jenssegers\Agent\Agent;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agent = new Agent();

        $is_mobile = 0;

        if( $agent->isMobile() || $agent->isTablet() ) {
        	$is_mobile = 1;
        }

        return view('home', compact('is_mobile', $is_mobile));
    }
}
