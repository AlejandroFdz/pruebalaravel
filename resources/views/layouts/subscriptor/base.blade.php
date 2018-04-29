<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

  <!-- Font awesome -->
  <script src="https://use.fontawesome.com/f4045ea5f5.js"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
  <!-- Textarea line numbers -->
  <link href="{{ asset('css/app/set-number.css') }}" rel="stylesheet">

  <!-- Custom css styles -->
  <link href="{{ asset('css/app/styles.css') }}" rel="stylesheet">

  <!-- html2Canvas -->
  <script src="{{ asset('js/html2canvas.js')  }}"></script>

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
      ]) !!};
  </script>

  @yield('styles')

  </head>
  
  <body>

    <div class="topbar row">
      <div class="logo col-md-2">
        <img src="/imgs/logo.png" alt="">
      </div>
      <div class="col-md-8 text-center">
        <ul class="topmenu">
          <li {{{ (Request::is('home') ? 'class=current-item' : '') }}}>
            <a href="{{ url('/home') }}">Inicio</a>
          </li>
          <li {{{ (Request::is('campaigns') ? 'class=current-item' : '') }}}>
            <a href="{{ route('campaigns.index') }}">Campañas</a>
          </li>
          <li {{{ (Request::is('lists') ? 'class=current-item' : '') }}}>
            <a href="{{ route('lists.index') }}">Listas</a>
          </li>
          <li {{{ (Request::is('templates') ? 'class=current-item' : '') }}}>
            <a href="{{ route('templates.index') }}">Plantillas</a>
          </li>
          <li {{{ (Request::is('planes') ? 'class=current-item' : '') }}}>
            <a href="{{ route('plans.index') }}">Planes</a>
          </li>
          <li>
            <a href="{{ url('tickets') }}">Soporte</a>
          </li>
        </ul>
      </div>
      <div class="col-md-2 top-subscriptor">
        
        <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle subscriber-account-btn" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">            
            <strong>{{ Auth::user()->name }}</strong><br>
            {{ Auth::user()->lastname }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="{{ route('user.profile') }}">Mi cuenta</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{url('/logout')}}">Cerrar sesión</a></li>
          </ul>
      </div>

      <img src="{{ Avatar::create( Auth::user()->name )->toBase64() }}" class="avatar pull-right">

      </div>
    </div>

    <div id="app" class="container lists_section">

      <div class="col-md-12 app-contents">

        <div class="row app-header">
          <div class="col-md-6" style="padding-left:0px!important;">
            @yield('title')
          </div>
          <div class="col-md-6 text-right">
            @yield('topbar_button')
          </div>
        </div>

        @yield('content')

      </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.1/jquery.autosize.min.js"></script>
    <script src="{{ asset('js/set-number.min.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>

    @yield('scripts')
    
  </body>
  </html>
