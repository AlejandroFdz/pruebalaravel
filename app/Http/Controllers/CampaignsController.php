<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Lists;
use App\Groups;
use App\Subscribers;
use App\Campaigns;
use App\UserTemplates;
use App\User;
use App\Invoice;

use App\Http\Requests\CampaignsRequest;

use Illuminate\Support\Facades\DB;

use Barryvdh\Debugbar\Facade as Debugbar;

use Log;

use Mail;
use App\Mail\CHormigaEmails;
use App\Jobs\SendCustomerEmails;
use App\EmailQueueNotify;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $campaigns = Campaigns::where('id_user', '=', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('campaigns.index')->with('campaigns', $campaigns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.create');
    }

    public function glist($user_token, $id_list, Request $request)
    {
        $ajax_result = array( 'success' => '', 'result' => '', 'error' => array() );

        if( $request->user_token == Auth::user()->token ) {

            $list = Lists::where('id', '=', $request->id_list)->get();

            if( count($list) > 0 ) {

                $ajax_result['success'] = true;

                if( $request->ajax() ) {

                    $groups = Groups::where('list_id', '=', $request->id_list)->select('id', 'name')->orderBy('id', 'asc')->get();

                    $ajax_result['result'] = $groups->toArray();

                    return response()->json($ajax_result);
                }
            } else if( count($list) == 0 ) {

                // El usuario modificó el ID de la lista intentando explotar un posible error en la aplicación
                $ajax_result['success'] = false;
                $ajax_result['result'] = '';
                array_push($ajax_result['error'], 'Encontramos un error al mostrar los grupos para la lista seleccionada.');

                return response()->json($ajax_result);
            }

        } else {

            // El token de usuario es incorrecto: Problema de seguridad
            $ajax_result['success'] = false;
            $ajax_result['result'] = '';
            array_push($ajax_result['error'], 'Encontramos un error al mostrar los grupos asociados a tu usuario.');

            return response()->json($ajax_result);
        }

    }

    public function scount($user_token, $id_group, Request $request)
    {
        $ajax_result = array( 'success' => true, 'result' => 'ok', 'error' => array() );

        if( $request->user_token == Auth::user()->token ) {

            $groups = Groups::where('id', '=', $request->id_group)->select('id')->get();

            if( count($groups) > 0 ) {

                $ajax_result['success'] = true;

                if( $request->ajax() ) {

                    $subscribers = Subscribers::where('group_id', '=', $request->id_group)->get();

                    $ajax_result['result'] = array( array( 'cant' => count($subscribers->toArray())) );

                    return response()->json($ajax_result);
                }

            } else {

                $ajax_result['success'] = false;
                $ajax_result['result'] = '';
                array_push($ajax_result['error'], 'Encontramos un error al obtener los grupos para la lista seleccionada.');

                return response()->json($ajax_result);
            }

        } else {
            $ajax_result['success'] = false;
            $ajax_result['result'] = '';
            array_push($ajax_result['error'], 'Encontramos un error al mostrar los grupos asociados a tu usuario.');

            return response()->json($ajax_result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignsRequest $request)
    {
        $input = [
            'name' => $request->name,
            'subject' => $request->subject,
            'from' => $request->from,
            'email' => $request->email,
            'id_user' => Auth::user()->id,
            'company' => $request->company
        ];

        $campaign = Campaigns::create($input);

        return redirect()->route('campaigns.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        /** Array que contiene el número de contactos por grupo y lista. */
        $total_subscribers_array = array();

        /** Obtenemos la lista de campañas. */
        $campaign = Campaigns::find($id);

        /** Obtenemos la lista de plantillas creadas. */
        $templates = UserTemplates::where('user_id', '=', Auth::user()->id)->get();

        /** Obtenemos todas las listas del usuario. */
        $lists = Lists::where('client_id', '=', Auth::user()->id)->orderBy('id', 'desc')->get();

        /** Obtenemos el número de contactos por grupo y lista y lo agregamos al array $total_subscribers_array. */
        foreach( $lists as $list ) {

            $subscribers = Subscribers::join('groups', 'groups.id', '=', 'subscribers.group_id')
                ->join('lists', 'lists.id', '=', 'groups.list_id')
                ->where('lists.client_id', '=', Auth::user()->id)
                ->where('lists.id', '=', $list->id)
                ->select(['subscribers.id'])
                ->get();

            array_push( $total_subscribers_array, $subscribers->count() );
        }

        /** Obtenemos el estado del plan al que suscribió el usuario. */
        $user = User::find(Auth::user()->id);

        $fecha_actual = date('Y-m-d H:i:s');
        $fecha_fin_trial = $user->trial_ends_at;

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

        return view('campaigns.edit', compact('user', 'days', 'premium_days'))
            ->with('campaign', $campaign)
            ->with('templates', $templates)
            ->with('lists', $lists)
            ->with('total_subscribers_array', $total_subscribers_array);
    }

    function dias_transcurridos($fecha_i, $fecha_f)
    {
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias); 
        $dias = floor($dias);     
        
        return $dias;
    }

    /**
    * Enviamos la campaña de correo a todos los usuarios seleccionados por el usuario.
    */
    public function send_campaign(Request $request)
    {
      if( $request->ajax() ) {

        $ajax_result = array( 'status' => 'success', 'result' => 'ok' );

        $campaign_id = $request->campaign_id;

        $campaign_data = [
            'campaign_id' => $campaign_id,
            'id_user' => Auth::user()->id,
            'email' => Auth::user()->email,
            'template_id' => $request->template_id,
            'default_template_id' => $request->default_template_id,
            'list_id' => $request->list_id,
            'subject' => $request->subject,
            'from_name' => $request->from_name,
            'from_email' => $request->from_email,
            '_token' => $request->_token
        ];

        /** Cerramos la campaña para que no se vuelva a enviar. */
        $campaign = Campaigns::find($campaign_id);
        $campaign->status = 'closed';
        $campaign->save();

        /** Ponemos a la cola el envío de correos. */
        dispatch(new SendCustomerEmails($campaign_data));

        /** Registramos el envío para notificar posteriormente al usuario. */
        /** Agregamos a la cola el envío */

        $input = [
            'id_user' => Auth::user()->id,
            'email' => Auth::user()->email
        ];

        EmailQueueNotify::create($input);

        return response()->json($ajax_result);
        
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignsRequest $request, $id)
    {
        $campaign = Campaigns::find($id);

        $campaign->name = $request->name;
        $campaign->subject = $request->subject;
        $campaign->from = $request->from;
        $campaign->email = $request->email;
        $campaign->company = $request->company;

        $campaign->save();

        return redirect('campaigns');
    }

    public function send($id)
    {

        $user_token = Auth::user()->token;

        $lists = Lists::where('client_id', '=', Auth::user()->id)->orderBy('id')->get();

        $list = $lists->pluck('id');

        $list_id = $list[0];

        $groups = Groups::where('list_id', '=', $list_id)
            ->get();

        $subscribers = DB::table('subscribers')
                ->join('groups', 'subscribers.group_id', '=', 'groups.id')
                ->join('lists', 'lists.id', '=', 'groups.list_id')
                ->select('subscribers.*')
                ->where('lists.client_id', '=', Auth::user()->id)
                ->get();

        $campaign = Campaigns::find($id);

        return view('campaigns.send', compact('user_token', $user_token), compact('list_id', $list_id))->with('lists', $lists)->with('groups', $groups)->with('subscribers', $subscribers)->with('campaign', $campaign);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if( $request->ajax() ) {
            
            $campaigns = Campaigns::where('id', '=', $request->id)
                ->where('id_user', '=', Auth::user()->id)
                ->get();

            if( $campaigns->count() > 0 ) {
                $campaign = Campaigns::find($request->id);
                $campaign->destroy($campaign->id);
            }
        }
    }
}
