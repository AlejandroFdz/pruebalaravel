<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Correo Hormiga') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Font awesome -->
    <script src="https://use.fontawesome.com/f4045ea5f5.js"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/webpage.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

    <div id="app" class="container web-container">

        <div class="row topbar">
            <div class="col-md-4 logo">
                <a href="{{url('')}}">CORREO HORMIGA</a>
            </div>
            <div class="col-md-8">

                <ul class="mainmenu">
                  @if (Auth::user() && Auth::user()->admin == 1)
                      <li>
                        <a href="{{route('admin.dashboard')}}">Administrar</a>
                      </li>
                      <li class="current-item">
                        <a href="{{url('/blog')}}">Blog</a>
                      </li>
                      <li>
                        <a href="{{url('/tickets')}}">Tickets</a>
                      </li>
                    @else
                      @if (Auth::user())
                        <li>
                          <a href="{{route('campaigns.index')}}" class="home-dashboard">Campañas</a>
                        </li>
                      @endif
                      <li>
                          <a href="{{url('/planes')}}">Planes</a>
                      </li>
                      <li class="current-item">
                          <a href="{{url('blog')}}">Blog</a>
                      </li>
                      <li>
                          <a href="{{url('tickets')}}">Soporte</a>
                      </li>                      
                    @endif
                    <li>
                        @if(Auth::user())
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Bienvenido/a, <strong>{{ Auth::user()->name }}</strong>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownAccount">
                                    <li><a href="#">Mi cuenta</a></li>
                                    <li><a href="#">Panel de control</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="/logout" class="logout">Cerrar sesión</a></li>
                                </ul>
                            </div>
                            <!-- <a href="#" class="account">Bienvenido/a, <strong>{{ Auth::user()->name }}</strong></a><br />
                            <a href="/logout" class="logout">Cerrar sesión</a> -->
                        @else
                            <a href="/acceso" class="login">Acceder</a>
                        @endif
                    </li>
                </ul>

            </div>
        </div>

        <div class="home-slide text-center" style="max-height:200px;padding-top:40px;padding-bottom:40px;">
            <h1>Blog</h1>
        </div>

        <div class="row section home-section-2" style="padding-bottom:50px;">

          @if( $is_admin == 1 )

            <div class="col-md-12 text-center" style="margin-bottom:25px;">
            
              <button id="addPost" class="btn btn-primary">Añadir Entrada</button>            

            </div>

            <div id="addPostForm" class="row" style="display:none;">
            
              <div class="col-md-3"></div>

              <div class="col-md-6">
                
                {!! Form::open(['route' => 'blog.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'role' => 'form', 'files' => true]) !!}
                  
                  <div class="box-body">

                    <div class="form-group">
                      {{Form::label('post_picture', 'Imagen destacada')}}
                      <div id="inputfilesjs" class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Elegir… {!! Form::file('featured_picture', array('class' => 'form-control', 'id' => 'post_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                            </span>
                        </label>
                        <input id="create_picture_filename" name="create_picture_filename" class="input_filename form-control" readonly="" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      {{Form::label('title', 'Título')}}
                      {{Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Título', 'required' => 'required'))}}
                    </div>

                    <div class="form-group">
                      {{Form::label('body', 'Contenido')}}
                      {{Form::textarea('body', null, array('class' => 'form-control', 'placeholder'=>'Contenido', 'id' => 'summernote', 'required' => 'required'))}}
                    </div>

                    {!! Form::token() !!}
                    
                    <div class="form-group">
                      {!! Form::submit('Publicar', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top:10px;']) !!}
                    </div>

                  </div>

                {!! Form::close() !!}

              </div>

              <div class="col-md-3"></div>

            </div>

          @endif


          <div class="col-md-3"></div>

          <div class="col-md-6">

              @foreach($posts as $post)
                
                <div class="post">

                  @if($post->featured_picture != '')
                    <img src="{{url('storage')}}/app/{{$post->featured_picture}}" style="width:100%;">
                  @endif
                  
                  <h2>{{$post->title}}</h2>

                  <div style="display:block;">

                    {!! html_entity_decode($post->content) !!}

                  </div>

                  @if( $is_admin == 1 )

                    <a href="{{url('blog/'.$post->id.'/edit')}}" class="btn btn-warning pull-right" style="margin-left:10px;margin-right:10px;">Editar</a>
                    
                    <button id="show_delete_warning" class="btn btn-danger">Eliminar</button>

                    {!! Form::open(['route' => array('blog.destroy', $post->id), 'method' => 'DELETE', 'class' => 'form-horizontal form-delete', 'style' => 'display:none;margin-top:20px;']) !!}

                      <div class="alert alert-danger" role="alert">

                        ¿Estás seguro de que quieres eliminar esta entrada?

                        {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}

                        <button id="close_delete_warning" class="btn-delete-warning pull-right">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </button>

                      </div>
                      
                    {!! Form::close() !!}

                  @endif

                </div>

              @endforeach

              @if(count($posts) == 0)
                <div class="text-center">
                  <span>No hay entradas en el blog.</span>
                </div>
              @endif

          </div>

          <div class="col-md-3"></div>

        </div>

    </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

  <script type="text/javascript">
    
    $( document ).ready(function() {

      $('#summernote').summernote({
        height:300,
      });

      $("#addPost").click(function() {
        $("#addPostForm").show("fast");
      });

      $("#show_delete_warning").click(function(event) {
        
        event.preventDefault();

        $(".form-delete").toggle("slow");

      });

      $("#close_delete_warning").click(function(event) {
        event.preventDefault();
        $(".form-delete").toggle("slow");
      });

      $(document).on('change', ':file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        $(this).parent().parent().parent().find(".input_filename").val(label);
    });

    });

  </script>

</body>
</html>
