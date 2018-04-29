<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function create(Request $request)
    {
    	$plan = Plan::findOrFail($request->plan);

    	if( $request->user()->subscribedToPlan($plan->braintree_plan, 'main') ) {
    		return redirect()->route('plans.index');
    	}

    	if(!$request->user()->subscribed('main')) {
    		$request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);
    	} else {
    		$request->user()->subscription('main')->swap($plan->braintree_plan);
    	}

    	return redirect()->route('plans.index');
    }
}
