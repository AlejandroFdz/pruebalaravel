@extends('layouts.app')

@section('content')

  <div class="home-slide text-center" style="max-height:200px;padding-top:40px;padding-bottom:40px;">
      <h1>Soporte técnico.</h1>
  </div>

  <div class="row section home-section-2" style="padding-bottom:50px;">

      <div id="addPostForm" class="row">

        <div class="col-md-1"></div>

        <div class="col-md-10">

          @if( Auth::user()->admin == 1 )

            @if( count($tickets) == 0 )

              <div class="text-center">No hay ningún ticket.</div>

            @else

              <table class="table table-striped">
              <thead>
                <tr>
                  <th>Correo</th>
                  <th>Fecha</th>
                  <th>Asunto</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($tickets as $ticket)
                  <tr>
                    <td>
                      {{$ticket->email}}
                    </td>
                    <td>
                      {{$ticket->created_at}}
                    </td>
                    <td>
                      {{$ticket->subject}}
                    </td>
                    <td>
                      {{$ticket->status}}
                    </td>
                    <td>
                      @if($ticket->status != 'cerrado')
                        {!! Form::open(['route' => array('tickets.update', $ticket->id), 'method' => 'PUT', 'class' => 'form-horizontal pull-right']) !!}
                          {!! Form::submit('Cerrar Ticket', ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;']) !!}
                        {!! Form::close() !!}
                      @endif
                      <a href="{{url('tickets/'.$ticket->id.'/edit')}}" class="btn btn-primary pull-right">
                        Ver Ticket
                      </a>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>

            {{ $tickets->links() }}

            @endif

          @else

            <div class="bs-callout bs-callout-warning" id="callout-inputgroup-dont-mix" style="margin-bottom:20px;">
              <h4>Correo Hormiga</h4>
              <p>
                Si necesitas crear un ticket de soporte técnico por que has detectado algún error en <strong>Correo Hormiga</strong> o tienes alguna duda sobre el funcionamiento del sistema no dudes en crear un ticket.<br><br>

                @if( $user->trial_ends_at != NULL & $days > 0 || $premium_days > 0 )
                  <a href="{{url('tickets/create')}}" class="btn btn-success">Crear ticket</a>
                @else
                  <span class="label label-danger" style="font-size: 12px;">
                    No puedes crear un Ticket en Soporte. Tu periodo de 30 días gratis han concluido o no te suscribiste al plan Premium.
                  </span>
                @endif
              
              </p>
            </div>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Asunto</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($tickets as $ticket)
                  <tr>
                    <td>
                      {{$ticket->created_at}}
                    </td>
                    <td>
                      {{$ticket->subject}}
                    </td>
                    <td>
                      {{$ticket->status}}
                    </td>
                    <td>
                      @if($ticket->status != 'cerrado')
                        {!! Form::open(['route' => array('tickets.update', $ticket->id), 'method' => 'PUT', 'class' => 'form-horizontal pull-right']) !!}
                          {!! Form::submit('Cerrar Ticket', ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;']) !!}
                        {!! Form::close() !!}
                      @endif
                      <a href="{{url('tickets/'.$ticket->id.'/edit')}}" class="btn btn-primary pull-right">
                        Ver Ticket
                      </a>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>

            {{ $tickets->links() }}

          @endif

        </div>

        <div class="col-md-1"></div>

      </div>

  </div>

  </div>
@endsection

@section('scripts')

  <!-- include summernote css/js-->
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

  <script type="text/javascript">

    $( document ).ready(function() {

      $('#summernote').summernote({
        height:300,
      });

      $(".ticket").click(function() {
        $("#ticket_content_" + $(this).data("id")).toggle();
      });

    });

  </script>

@endsection
