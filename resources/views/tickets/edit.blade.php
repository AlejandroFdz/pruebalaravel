@extends('layouts.app')

@section('content')

  <div class="home-slide text-center" style="max-height:200px;padding-top:40px;padding-bottom:40px;">
      <h1>Editar Ticket</h1>
  </div>

  <div class="row section home-section-2" style="padding-bottom:50px;">

      <div id="addPostForm" class="row">

        <div class="col-md-3"></div>

        <div class="col-md-6">

          <ol class="breadcrumb">
            <li><a href="{{url('/tickets')}}">Soporte</a></li>
            <li>Ticket</li>
            <li class="active">{{$ticket[0]->subject}}</li>
          </ol>

          <div class="box-body">

            <div class="jumbotron" style="padding-bottom:25px;border-radius:5px;">
              <div class="container">
                <h2>{{$ticket[0]->subject}}</h2>
                <p>{!! $ticket[0]->description !!}</p>
              </div>
            </div>

            <div class="row ticket-comments">

              @if( count($comments) == 0 )
                <div class="text-center">
                  <span>No hay comentarios.</span>
                </div>
              @else

                @foreach($comments as $comment)

                    <div class="ticket-comment">

                      <div class="ticket-comment-head">

                        <div class="user-comment pull-left">
                          <i class="fa fa-user comment-icon" aria-hidden="true"></i>
                          <span class="uname">
                            <strong>{{$comment->name}} {{$comment->lastname}}</strong>
                          </span><br>
                          <span class="utype">
                            @if( Auth::user()->admin == 1 )
                              Administrador de <strong>Correo hormiga</strong>
                            @else
                              Cliente de <strong>Correo Hormiga</strong>
                            @endif
                          </span>
                        </div>

                        <div class="comment-date pull-right" style="padding-top:8px;">
                          {{$comment->created_at}}
                        </div>

                      </div>

                      <div class="ticket-comment-body">

                        <h3>{{$comment->subject}}</h3>

                        <p>
                          {!! $comment->description !!}
                        </p>

                      </div>

                    </div>

                @endforeach

              @endif
            </div>

            @if( $ticket[0]->status != 'cerrado' )

              <div class="row text-center" style="margin-top:25px;">
                <a id="post_comment" class="btn btn-primary">Añadir Comentario</a>
              </div>

            @endif

          </div>

          @if( $ticket[0]->status != 'cerrado' )

            <div id="new_comment_form" class="box-body" style="display:none;">

              {!! Form::open(['route' => 'ticket_comments.store', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}

                <div class="form-group">
                  {{Form::label('subject', 'Asunto')}}
                  {{Form::text('subject', null, array('class' => 'form-control', 'placeholder'=>'Asunto', 'required' => 'required'))}}
                </div>

                <div class="form-group">
                  {{Form::label('body', 'Descripción')}}
                  {{Form::textarea('body', null, array('class' => 'form-control', 'placeholder'=>'Describe el problema.', 'id' => 'summernote', 'required' => 'required'))}}
                </div>

                {!! Form::token() !!}
                {{Form::hidden('ticket_id', $ticket[0]->id)}}

                <div class="form-group">
                  {!! Form::submit('Comentar', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top:10px;']) !!}
                </div>

              {!! Form::close() !!}

          </div>

        @endif

      </div>

      <div class="col-md-3"></div>

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

      $("#post_comment").click(function() {
        $("#new_comment_form").fadeIn("fast");
      });

    });

  </script>

@endsection
