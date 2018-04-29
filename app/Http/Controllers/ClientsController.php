<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Facades\PayPal;

use Auth;
use App\User;
use App\Invoice;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ClientsController extends Controller
{    
    protected $provider;

    public function __construct() {
        $this->provider = new ExpressCheckout();
    }

    public function profile()
    {
    	$message = '';
    	$user = User::where('id', '=', Auth::user()->id)->get();

        /** Verificamos que el usuario pagó o no una cuenta Premium. */
        $invoice = Invoice::where('client_id', '=', Auth::user()->id)->latest()->first();

        $fecha_actual = date('Y-m-d H:i:s');
        
        $premium_days = 0;
        $recurring_id = '';

        if( $invoice->count() > 0 ) {
            if( $invoice->recurring_id != NULL ) {

                $invoice_with_id = Invoice::where('recurring_id', '=', $invoice->recurring_id)->latest()->first();
                $premium_days = $this->dias_transcurridos($fecha_actual, $invoice_with_id->created_at);
                $recurring_id = $invoice_with_id->recurring_id;

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

    	return view('client.profile', compact('premium_days', 'recurring_id'))->with('user', $user)->with('message', '');
    }

    function dias_transcurridos($fecha_i, $fecha_f)
    {
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias); 
        $dias = floor($dias);     
        
        return $dias;
    }

    public function update(Request $request)
    {
    	if ( $this->formValidationPost($request) ) {
    		/** Actualizamos la información del usuario. */
    		$user = User::find($request->id);

    		if( $user->count() > 0 ) {
    			if( $user->id == Auth::user()->id ) {

    				if( $request->email == Auth::user()->email ) {
    					$user->email = $request->email;
    				} else {
    					$user->email = Auth::user()->email;
    				}

    				$user->name = $request->name;
    				$user->lastname = $request->lastname;
    				$user->email = $request->email;
    				$user->phone = $request->phone;
    				$user->company = $request->company;
    				$user->password = Hash::make($request->password);
    				$user->save();
    			}
    		}

    	}

    	return redirect()->back()->with('message', 'Actualizaste tu información con éxito.');
    }

    public function formValidationPost($request)
    {
    	$this->validate($request,[
    			'email' => 'required',
    			'name' => 'required|min:5|max:35',
    			'lastname' => 'required|min:5|max:100',
    			'company' => 'required|min:5|max:55',
    			'phone' => 'required|min:5|max:35',
    			'password' => 'required|min:6|max:20',
    			'confirm_password' => 'required|min:3|max:20|same:password'
    		],[
    			'name.required' => 'Tu nombre es obligatorio.',
    			'name.min' => ' Tu nombre debe tener al menos 5 carácteres.',
    			'name.max' => ' El nombre que has introducido es demasiado largo.',
    			'lastname.required' => ' Tu/s apellido/s son obligatorios.',
    			'lastname.min' => ' Tu apellido debe tener al menos 5 carácteres.',
    			'lastname.max' => ' Los apellidos que has introducido son demasiado largos.',
    			'company.required' => 'El campo Empresa es obligatorio.',
    			'company.min' => 'El nombre de tu empresa debe tener al menos 5 carácteres.',
    			'company.max' => 'El nombre de empresa que has introducido es demasiado largo.',
    			'phone.required' => 'El teléfono es obligatorio.',
    			'phone.min' => 'El teléfono que has introducido es demasiado corto.',
    			'phone.max' => 'El teléfono que has introducido es demasiado largo.',
    			'password.required' => 'El campo contraseña es obligatorio.',
    			'password.min' => 'La contraseña ha de tener mínimo 6 carácteres.',
    			'password.max' => 'La contraseña que has introducido es demasiado larga.',
    			'confirm_password.required' => 'Tienes que volver a escribir la contraseña.',
    			'confirm_password.same' => 'Las contraseñas que has introducido no coindiden.'
    		]);

    	return redirect()->back();
    }

    public function suspend($id, Request $request)
    {
        if( $request->ajax() ) {
            if( $id != '' ) {
                $PayerID = $request->get('PayerID');                
                $response = $this->provider->suspendRecurringPaymentsProfile($PayerID);
            }
        }
    }
}
