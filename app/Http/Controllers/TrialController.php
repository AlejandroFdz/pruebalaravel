<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class TrialController extends Controller
{
    public function activar()
    {
    	$user = User::find(Auth::user()->id);

    	$fecha_actual = date('Y-m-d H:i:s');

    	if( $user->trial_ends_at == NULL ) {

    		$nuevafecha = strtotime ( '+30 days' , strtotime ( $fecha_actual ) ) ;
			$user->trial_ends_at = date ( 'Y-m-d H:i:s' , $nuevafecha );

    		$user->save();
    	}

    	return redirect('planes');
    }
}
