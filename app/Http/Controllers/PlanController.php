<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

use Braintree\ClientToken;

use App\User;
use App\Invoice;
use Auth;

class PlanController extends Controller
{
    public function index(Request $request)
    {
    	$plans = Plan::get();
        $user = User::find(Auth::user()->id);

        /** Obtenemos el número de días restantes para terminar el periodo de trial. */
        $fecha_actual = date('Y-m-d H:i:s');
        $fecha_fin_trial = $user->trial_ends_at;

        $days = 0;
        if( $fecha_actual > $fecha_fin_trial ) {
            $days = 0;
        } else {
            $days = $this->dias_transcurridos($fecha_actual, $fecha_fin_trial);
        }

        /** Verificamos que el usuario pagó o no una cuenta Premium. */
        $invoice = Invoice::where('client_id', '=', Auth::user()->id)->latest()->first();

        $premium_days = 0;

        if( $invoice->count() > 0 ) {
            if( $invoice->recurring_id != NULL ) {

                $invoice_with_id = Invoice::where('recurring_id', '=', $invoice->recurring_id)->latest()->first();
                $premium_days = $this->dias_transcurridos($fecha_actual, $invoice_with_id->created_at);

                if( $invoice_with_id->payment_status != 'Processed' && $invoice_with_id->payment_status != 'Completed' )
                {
                    $premium_days = 0;
                }

            } else {

                $premium_days = $this->dias_transcurridos($fecha_actual, $invoice->created_at);

            }
        } else {

            $premium_days = 0;

        }

        return view('plans.index', compact('user', 'days', 'premium_days'))->with(['plans' => $plans]);
    }

    function dias_transcurridos($fecha_i, $fecha_f)
    {
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias);
        $dias = floor($dias);

        return $dias;
    }

    public function show(Request $request, Plan $plan)
    {
    	if( $request->user()->subscribedToPlan($plan->braintree_plan, 'main') ) {
    		return redirect()->route('plans.index');
    	}

        $clientToken = ClientToken::generate();

    	return view('plans.show', compact('clientToken'))->with(['plan' => $plan]);
    }
}
