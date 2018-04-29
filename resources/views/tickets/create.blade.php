@extends('layouts.app')

@section('content')

  <div class="home-slide text-center" style="max-height:200px;padding-top:40px;padding-bottom:40px;">
      <h1>Crear ticket.</h1>
  </div>

  <div class="row section home-section-2" style="padding-bottom:50px;">

      <div id="addPostForm" class="row">
      
        <div class="col-md-3"></div>

        <div class="col-md-6">

          {!! Form::open(['route' => 'tickets.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'role' => 'form', 'files' => true]) !!}

            <div class="box-body">

              <div class="form-group">
                {{Form::label('subject', 'Asunto')}}
                {{Form::text('subject', null, array('class' => 'form-control', 'placeholder'=>'Asunto', 'required' => 'required'))}}
              </div>

              <div class="form-group">
                {{Form::label('body', 'Descripción')}}
                {{Form::textarea('body', null, array('class' => 'form-control', 'placeholder'=>'Describe el problema.', 'id' => 'summernote', 'required' => 'required'))}}
              </div>

              <div class="form-group">
                {{Form::label('post_picture', 'Captura')}}
                <div id="inputfilesjs" class="input-group">
                  <label class="input-group-btn">
                      <span class="btn btn-primary">
                          Elegir… {!! Form::file('capture_picture', array('class' => 'form-control', 'id' => 'capture_picture', 'value' => 'Elegir', 'style' => 'display:none;')) !!}
                      </span>
                  </label>
                  <input id="capture_picture_filename" name="capture_picture_filename" class="input_filename form-control" readonly="" type="text">
                </div>
              </div>

              {!! Form::token() !!}
              
              <div class="form-group">
                {!! Form::submit('Crear Ticket', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top:10px;']) !!}
              </div>

            </div>

          {!! Form::close() !!}

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

      $(document).on('change', ':file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        $(this).parent().parent().parent().find(".input_filename").val(label);
      });

    });

  </script>

@endsection