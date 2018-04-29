@extends('layouts.subscriptor.base')

@section('title')
  <h1>Enviar Campaña: {{$campaign->name}}</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')

	{!! Form::open(['url' => 'campaigns', 'class' => 'form-horizontal', 'role' => 'form']) !!}
		
		<div class="row">

			<div class="col-md-8">
				<div class="form-group">
					<h2>Listas y Grupos</h2>
				</div>
				<div class="form-group">
					@if(count($lists) == 0)
						<div class="alert alert-danger" role="alert">
							No has importado ningún contacto, crea al menos un grupo de subscriptores para crear la campaña y 
							empezar a enviar correos promocionales.<br>
							<a href="#" class="btn btn-danger" style="margin-top:10px;">Cargar contactos</a>
						</div>
					@else

						<input type="hidden" id="user_token" name="user_token" value="{{$user_token}}">
						<input type="hidden" id="list_id" name="list_id" value="{{$list_id}}">

						<select class="form-control list-select">
							@foreach($lists as $list)
								<option value="{{$list->id}}">{{$list->name}}</option>
							@endforeach
						</select>
						
						<ul class="list groups-list" style="margin-top:15px;">
							@foreach($groups as $group)
								<li>
									<input type='checkbox' class='groupsel' data-idgroup='{{$group->id}}'> 
									{{$group->name}}
									<span class="contacts-tag">
										<?php $contador = 0; ?>
											@foreach( $subscribers as $subscriber )
												@if($subscriber->group_id == $group->id)
													<?php $contador++; ?> 
												@endif
											@endforeach
										<?php echo $contador . " contactos"; ?>
									</span>
								</li>
							@endforeach
						</ul>

						<input type="hidden" id="groups_ids" name="groups_ids" value="">

						<div class="form-group ajaxmsg" style="display:none;">
							<div class="alert alert-danger errors" role="alert">
								
							</div>
						</div>

					@endif
				</div>
				<div class="form-group">
					<h2>Plantilla</h2>
				</div>
				<div class="form-group">
					<div class="alert alert-danger" role="alert">
						No has importado o creado ninguna plantilla. Por favor, para crear una nueva campaña crea antes una
						plantilla o elije alguna de nuestro sistema.<br>
						<a href="#" class="btn btn-danger" style="margin-top:10px;">Crear plantilla</a>
					</div>
				</div>
			</div>
			<div class="col-md-2"></div>

		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					{!! Form::submit('Enviar campaña', ['class' => 'btn btn-primary btn-lg']) !!}
				</div>
			</div>
		</div>

	{!! Form::close() !!}
@endsection

@section('scripts')
	<script type="text/javascript">
		$( document ).ready(function() {

			var userToken = $("#user_token").val();

			var getSubscribersCount = function(userToken, groupId, groupName) {

				var output = "";

				$.ajax({					
					url: "/groups/scount/" + userToken + "/" + groupId,
			        type: "GET",
			        data: "",
			        dataType   :'json',
			        success    :'success',
			        success: function( result ) {
			        	
			        	if( result.error != "" ) {
			        		$(".ajaxmsg").show();
				        	$(".errors").html(result.error);
			        	} else {
			        		
			        		$(".ajaxmsg").hide();
			        		
			        		$.each(result.result, function(i,index) {
			        			output += "<li>";
			        			output += "<input type='checkbox' data-idgroup='"+groupId+"' class='groupsel'> ";
			        			output += groupName + " ";
			        			output += "<span class='contacts-tag'>";
			        			output += index.cant;
			        			output += "</span>";
			        			output += "</li>";
			        		});

			        		$(".groups-list").append(output);
			        	}
			        	
			        }
			    })
			}

			$(".list-select").on('change', function() {

				$(".groups-list").html("");
				$("#groups_ids").val("");

				$("#list_id").val($(this).val());
				var listId = $(this).val();

				$.ajax({					
					url: "/groups/glist/" + userToken + "/" + listId,
			        type: "GET",
			        data: "",
			        dataType   :'json',
			        success    :'success',
			        success: function( result ) {
			        	
			        	if( result.error != "" ) {

			        		$(".ajaxmsg").show();
				        	$(".errors").html(result.error);

			        	} else {
			        		
			        		$(".ajaxmsg").hide();
			        		
			        		$.each(result.result, function(i,index) {
			        			getSubscribersCount(userToken, index.id, index.name);
			        		});
			        	}
			        	
			        }
			    })
			})

			$(".groups-list").on("click", ".groupsel", function() {

				var groupIdsVal = $("#groups_ids").val();
				var groupIdsValTmp = groupIdsVal + $(this).data("idgroup") + ",";
				
				if( groupIdsValTmp.substr(0, groupIdsValTmp.length) == "," ) {
					groupIdsValTmp = groupIdsValTmp.substr(0, groupIdsValTmp.length - 1);
				}

				$("#groups_ids").val( groupIdsValTmp );
			})

		});
	</script>
@endsection