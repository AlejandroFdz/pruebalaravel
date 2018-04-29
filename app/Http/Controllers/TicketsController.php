<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tickets;
use App\TicketComments;
use App\User;
use Auth;

use Mail;
use App\Mail\NewTicketNotify;
use App\Mail\NewTicketAdminNotify;
use App\Invoice;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::user()->admin == 1 ) {

            $tickets = Tickets::join('users', 'users.id', '=', 'tickets.client_id')
                ->orderBy('tickets.id', 'desc')
                ->select(['tickets.*', 'users.email'])
                ->paginate(20);

        } else {

            $tickets = Tickets::where('client_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate(20);

            /** Obtenemos el estado del plan al que suscribió el usuario. */
            $user = User::find(Auth::user()->id);

            $fecha_actual = date('Y-m-d H:i:s');
            $fecha_fin_trial = $user->trial_ends_at;

            if( $fecha_actual > $fecha_fin_trial ) {
                $days = 0;
            } else {
                $days = $this->dias_transcurridos($fecha_actual, $fecha_fin_trial);
            }

            /** Obtenemos el estado de la cuenta Premium de Correo Hormiga. */
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

        }

        return view('tickets.index', compact('user', 'days', 'premium_days'))->with('tickets', $tickets);
    }

    function dias_transcurridos($fecha_i, $fecha_f)
    {
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias); 
        $dias = floor($dias);     
        
        return $dias;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( isset($request->capture_picture_filename) ) {

            $year_folder = date('Y');
            $month_folder = date('m');

            if( file_exists( storage_path('uploads/tickets/' . $year_folder) === false ) ) {
                mkdir( storage_path('uploads/tickets/' . $year_folder) );
            }

            if( file_exists( storage_path('uploads/tickets/') . $year_folder . '/' . $month_folder ) ) {
                mkdir( storage_path('uploads/tickets/') . $year_folder . '/' . $month_folder );
            }

            $upload_folder = 'uploads/tickets/' . $year_folder . '/' . $month_folder;

            $path = $request->file('capture_picture')->store($upload_folder);

            $ticket = new Tickets(array(
                'subject' => $request->subject,
                'description' => $request->body,
                'status' => 'abierto',
                'picture' => $path,
                'client_id' => Auth::user()->id
            ));

        } else {

            $ticket = new Tickets(array(
                'subject' => $request->subject,
                'description' => $request->body,
                'status' => 'abierto',
                'client_id' => Auth::user()->id
            ));
        }

        $ticket->save();

        /** Enviamos un correo de notificación. */
        Mail::to(config('mail.from.address'))->send(new NewTicketAdminNotify());
        Mail::to(Auth::user()->email)->send(new NewTicketNotify());

        return redirect('/tickets');
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
        $ticket = Tickets::where('id', '=', $id)->get();

        $comments = TicketComments::join('tickets', 'tickets.id', '=', 'comments.ticket_id')
            ->join('users', 'comments.client_id', '=', 'users.id')
            ->where('tickets.id', '=', $id)
            ->select(['comments.*', 'users.name', 'users.lastname'])
            ->orderBy('comments.id', 'desc')
            ->get();

        return view('tickets.edit')->with('ticket', $ticket)->with('comments', $comments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        Tickets::where('id', '=', $id)->update([
                'status' => 'cerrado'
            ]);

        return redirect('/tickets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
