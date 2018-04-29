<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Tickets;
use App\TicketComments;

use Mail;
use App\Mail\NewTicketComment;
use App\Mail\NewTicketAdminComment;

use Barryvdh\Debugbar\Facade as Debugbar;

class TicketCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = [
            'subject' => $request->subject,
            'description' => $request->body,
            'ticket_id' => $request->ticket_id,
            'client_id' => Auth::user()->id
        ];

        TicketComments::create($input);

        /** Enviamos un correo de notificación. */
        if(Auth::user()->admin == 1) {

          /** Obtenemos el email del usuario que creó el ticket. */
          $ticketUser = Tickets::where('id', '=', $request->ticket_id)->pluck('client_id');
          $emailUser = User::where('id', '=', $ticketUser[0])->pluck('email');

          $data = [
            'ticket_id' => $request->ticket_id
          ];

          Mail::to($emailUser[0])->send(new NewTicketComment($data));

        } else {

          $data = [
            'ticket_id' => $request->ticket_id
          ];

          Mail::to(config('mail.from.address'))->send(new NewTicketAdminComment($data));

        }

        return redirect('tickets/'.$request->ticket_id.'/edit');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
