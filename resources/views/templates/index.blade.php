@extends('layouts.subscriptor.base')

@section('title')
  <h1>¿Cómo crearás tu plantilla?</h1>
@endsection

@section('content')
	
	<ul class="nav nav-tabs nav-justified">
	  <li class="active" role="presentation">
	  	<a href="#" class="tab-option estructuras" data-toggle="estructuras">Estructuras</a>
	  </li>
	  <li>
	  	<a href="#" class="tab-option plantillas" data-toggle="plantillas">Tus plantillas</a>
	  </li>
	</ul>

	<section id="estructuras">
		<ul class="list template-list">
			@foreach($templates as $template)
				<li>
					<a href="templates/{{$template->id}}/edit">
						<img src="uploads/default_templates/{{$template->featured_picture}}">
					</a>
				</li>
			@endforeach
		</ul>
	</section>

	<section id="plantillas" style="display:none;">
		@if( $user_templates->count() > 0 )
			<ul class="list template-list">
				@foreach($user_templates as $user_template)
					<li class="template_id_{{$user_template->id}}">
						<a href="templates/{{$user_template->id}}/edit">
							<span class="out-overlay">
								<span class="overlay text-center">
									<span>
									<p>{{ str_limit($user_template->name, $limit = 28, $end = '...') }}</p>
									<p>{{$user_template->created_at}}</p>
									</span>
								</span>
							</span>
							<img src="uploads/default_templates/template-{{$user_template->default_template_id}}.jpg">
						</a>
						<button data-template="{{$user_template->id}}" class="btn btn-danger remove_template" style="margin-top: 20px;margin-bottom:35px;">Eliminar</button>
					</li>
				@endforeach			
			</ul>
		@else
			<div style="text-align:center;margin-top:40px;">
				<span>
					No hay ninguna plantilla guardada.
				</span>
			</div>
		@endif
		{{ csrf_field() }}
	</section>

@endsection

@section('scripts')
	<script type="text/javascript">
		$( document ).ready(function() {

			$(".tab-option").click(function(event) {
				
				event.preventDefault();
				
				$("#"+$(this).data("toggle")).show();
				
				if($(this).data("toggle") == "estructuras") {
					$(this).parent().addClass("active")
					$(".html").parent().removeClass("active")
					$(".platillas").parent().removeClass("active")
					$("#html").hide();
					$("#plantillas").hide();
				} else if($(this).data("toggle") == "plantillas") {
					$(this).parent().addClass("active");
					$(".estructuras").parent().removeClass("active");
					$(".html").parent().removeClass("active");
					$("#estructuras").hide();
					$("#html").hide();
				}
			})

			$(".remove_template").click(function(event) {
				
				event.preventDefault();
				var _token = $('input[name="_token"]').val()
				var templateId = $(this).data("template")

				deleteData = {id: templateId, token: _token}

				$.ajax({
				    type: "DELETE",
				    url: "templates/destroy/" + templateId,
				    data: { id: templateId, _token : _token },
				    success: function (data) {
				    	$(".template_id_" + templateId).remove()

				    	if( $("#plantillas").find("li").length == 0 ) {
				    		$("#plantillas").html('<div style="text-align: center; margin-top: 40px;"><span>No hay ninguna plantilla guardada.</span></div>');
				    	}
				    },
				    error: function (data) {
				      console.log('Error:', data);
				    }				  
	            });
			})
		});
	</script>
@endsection