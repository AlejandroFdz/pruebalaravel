@extends('layouts.subscriptor.base')

@section('title')
  <h1></h1>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-9" style="margin-bottom:10px;">
            {!! Form::open(array('route' => 'templates.previewtofile', 'method' => 'POST', 'id' => 'template_form')) !!}

                <div class="col-md-10" style="padding:0px!important;">

                    {!! Form::text('template_name', $template_name, array('class' => 'form-control', 'id' => 'template_name', 'placeholder' => 'Nombre de la plantilla', 'required' => 'required')) !!}
                    {!! Form::hidden('auth_id', $user_id, ['id' => 'auth_id']) !!}
                    {!! Form::hidden('template_id', $id, ['id' => 'template_id']) !!}
                    {!! Form::hidden('default_template_id', $id, ['id' => 'default_template_id']) !!}
                    {!! Form::hidden('template_preview', null, ['id' => 'template_preview']) !!}

                    <!-- Componentes -->
                    @foreach($components as $component)
                      {!! Form::hidden($component->name, $component->content, ['id' => 'COMP_' . $component->name]) !!}
                    @endforeach

                    {!! Form::hidden('component_names', $component_names, ['id' => 'component_names']) !!}

                </div>

                <div class="col-md-2 text-right" style="padding:0px!important;">

                    <button id="save_template" class="btn btn-primary">
                      @if($template_option == 'create')
                        Guardar
                      @else
                        Modificar
                      @endif
                    </button>

                </div>

            {!! Form::close() !!}
		</div>

		<div id="template" class="col-md-9">

      <div id="template_edit_errors" class="alert alert-danger" role="alert" style="display:none;"></div>

			@foreach($components as $component)

				@include('components/' . $component->name, ['component' => $component])

			@endforeach

		</div>
		<div class="col-md-3" style="padding:20px;padding-top:0;border-left:dashed 3px #ededed;">
			@foreach($components as $component)
				@include('components/admin/' . $component->name, ['component' => $component])
			@endforeach
		</div>
	</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $( document ).ready(function() {

    $(".component").hover(function(){
      $(this).find(".btn-settings").fadeIn();
    }, function() {
      $(this).find(".btn-settings").fadeOut();
    }
  );

  $(".btn-settings").click(function() {
    var componentName = $(this).data("component");
    $(".mod-settings").hide();
    $("#admin_"+componentName).show();
  });

  $('.colorpicker').colorpicker();

  /** Capturamos la plantilla en una imagen. */
  function captureTemplate() {

      /** Generamos una imagen de la plantilla editaba por el usuario. */
      html2canvas($("#template")).then(function(canvas) {

          //$("html, body").animate({ scrollTop: $(document).height() }, 1000);
          
          //document.body.appendChild(canvas);
          
          var dataURL = canvas.toDataURL();
          var userId = $("#auth_id").val();

          $("#template_preview").val(dataURL);

          var inputData = $('#template_form').serialize();

          if( $.isNumeric(userId) && $("#template_preview").val() != "" && $("#template_name").val() != "" ) {
            
              $.ajax({
                  url: "/templates/previewtofile",
                  type: "POST",
                  data: inputData,
                  success: function( msg ) {
                      if ( msg.status === 'success' ) {
                          //console.log(msg.result);
                          $(location).attr("href", "/templates/"+msg.result+"/edit");
                      }
                  }
              });

          } else {

              console.log("error");

          }
      });

    }

  /** Template save submit */
  $("#save_template").click(function(event) {

      event.preventDefault();

      if( $("#template_name").val() == "" ) {

        $("#template_edit_errors").text("Tienes que introducir un nombre de plantilla para crearla.");
        $("#template_edit_errors").show();

      } else {

        captureTemplate("previewtofile");

      }

  });

});
</script>

@if( $default_template_id == 1 )
  <script src="{{ asset('js/templates/templates.js') }}"></script>
@elseif( $default_template_id > 1 )
  <script src="{{ asset('js/templates/template-'.$default_template_id.'.js') }}"></script>
@endif

@endsection
