@extends('layouts.subscriptor.base')

@section('title')
<h1>{{$campaign->name}}</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')

{{ Form::model($campaign, array('route' => array('campaigns.update', $campaign->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'campaign_form')) }}

<div class="row">

	<div class="col-md-8">

		@foreach ($errors->all() as $error)
		<div class="alert alert-danger" role="alert">{{ $error }}</div>
		@endforeach

		<div class="form-group">
			<label for="name" class="col-lg-2 control-label">
				<span>Nombre</span>
			</label>
			<div class="col-lg-10">
				{!! Form::text('name', $campaign->name, ['class' => 'form-control', 'placeholder' => 'Nombre de la Campaña']) !!}
				<small>Para uso interno en la applicación. Ej: "Newsletter Prueba#2"</small>
			</div>
		</div>
		<div class="form-group">
			<label for="subject" class="col-lg-2 control-label">
				<span>Asunto</span>
			</label>
			<div class="col-lg-10">
				{!! Form::text('subject', $campaign->subject, ['class' => 'form-control', 'id' => 'subject', 'placeholder' => 'Asunto del correo']) !!}
				<small>Escribe un buen asunto, sólo así leerán tus newsletters.</small>
			</div>
		</div>
		<div class="form-group">
			<label for="from" class="col-lg-2 control-label">
				<span>Empresa:</span>
			</label>
			<div class="col-lg-10">
				{!! Form::text('company', $campaign->company, ['class' => 'form-control', 'id' => 'company', 'placeholder' => 'Nombre de la empresa o titular']) !!}
				<small>Es el nombre del titular o empresa que aparecerá en el pie del correo.</small>
			</div>
		</div>
		<div class="form-group">
			<label for="from" class="col-lg-2 control-label">
				<span>Nombre desde:</span>
			</label>
			<div class="col-lg-10">
				{!! Form::text('from', $campaign->from, ['class' => 'form-control', 'id' => 'from_name', 'placeholder' => 'Nombre del emisor']) !!}
				<small>Usa algo que tus subscritores reconozcan instantáneamente, como tu nombre de empresa.</small>
			</div>
		</div>
		<div class="form-group">
			<label for="from_email" class="col-lg-2 control-label">
				<span>Correo desde:</span>
			</label>
			<div class="col-lg-10">
				{!! Form::email('email', $campaign->email, ['class' => 'form-control', 'id' => 'from_email', 'placeholder' => 'Correo del emisor']) !!}
			</div>
		</div>
	</div>

	<!-- Lista de subscriptores -->
	{!! Form::hidden('subscriber_list', null, ['id' => 'subscriber_list']) !!}
	{!! Form::token() !!}

	<div class="col-md-2"></div>

</div>

<div class="col-md-12" style="margin-bottom:65px;">

	<h2>Plantillas</h2>

	<ul class="list template-list">
		@foreach( $templates as $template )
			<li data-id="{{$template->id}}" data-default-template-id="{{$template->default_template_id}}">
				<h4 style="color:#333;">{{ str_limit($template->name, $limit = 28, $end = '...') }}</h4>
				<img src="/uploads/default_templates/template-{{$template->default_template_id}}.jpg">
			</li>
		@endforeach
	</ul>

	@if( count($templates) == 0 )

	<div class="col-md-12 text-center" style="margin-top:20px;">
		<div class="alert alert-info" role="alert">
			No has creado ninguna plantilla.<br><br>
			<a class="btn btn-primary" href="{{url('/templates')}}">Crearla</a>
		</div>
	</div>

	@endif

</div>

<div class="col-md-12" style="margin-bottom:45px;">

	<h2>Listas</h2>

	<select id="list_id_select" class="form-control">
		@foreach( $lists as $key => $list )
		<option value="{{$list->id}}">{{$list->name}} ({{$total_subscribers_array[$key]}}
			@if($total_subscribers_array[$key] > 1)
			subscriptores)
			@elseif($total_subscribers_array[$key] == 1)
			subscriptor)
			@endif
		</option>
		@endforeach
	</select>

</div>

@if( count($lists) == 0 )

<div class="col-md-12 text-center" style="margin-top:20px;">
	<div class="alert alert-info" role="alert">
		No has creado ninguna lista.<br><br>
		<a class="btn btn-primary" href="{{url('lists')}}">Crearla</a>
	</div>
</div>

@endif

<div class="row" style="margin-top:35px;">
	<div class="col-md-6 text-left">
		{!! Form::submit('Guardar campaña', ['class' => 'btn btn-primary btn-lg']) !!}
	</div>
	<div class="col-md-6 text-right">
		@if( $campaign->status == 'open' )
			
			@if( $user->trial_ends_at != NULL && $days > 0 || $premium_days > 0 )
				<span id="send" class="btn btn-lg btn-success" data-toggle="modal" data-target="#myModal">Enviar</span>
			@else
				<span class="label label-danger" style="font-size:12px;">Tu periodo de 30 días gratis han concluido o no te suscribiste al plan Premium.</span>
			@endif

		@else
			<span class="btn btn-lg btn-default" data-toggle="modal" data-target="#warningModal">Enviar</span>
		@endif
	</div>
</div>

<div id="warningModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Campaña enviada</h4>
			</div>
			<div class="modal-body text-center">
				<p>
					<strong>Ya habías enviado esta campaña.</strong><br> Crea otra campaña y asígnale una plantilla para enviarla.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enviar correos</h4>
			</div>
			<div class="modal-body text-center">
				<i class="fa fa-bell-o" aria-hidden="true" style="font-size:100px;color:#d0d0d0;"></i><br><br>
				<span id="send_emails" class="btn btn-success">Confirmar envío</span>
				<div id="sending_success" class="alert alert-success text-center" role="alert" style="margin-top:10px;display:none;">
					<strong>Tu envío se puso en cola</strong>,<br> recibirás un correo notificándote que tu campaña se envió con éxito.
				</div>
				<div id="template-select-alert" class="alert alert-danger" role="alert" style="margin-top:10px;">
					Antes de enviar tienes que seleccionar la plantilla de tu correo.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>

	</div>
</div>

{!! Form::close() !!}

<input type="hidden" name="campaign_id" value="{{$campaign->id}}">

@endsection

@section('scripts')

<script type="text/javascript">

	$( document ).ready(function() {

		var templateId = 0;
		var defaultTemplateId = 0;
		var templateSelected = false;

		$(".template-list li").click(function() {

			templateId = $(this).data("id");
			defaultTemplateId = $(this).data("default-template-id");

			$(".template-list li").css("padding", "0px");
			$(".template-list li").css("background-color", "#fff");
			$(".template-list li img").css("width", "281px");

			$(this).find("img").css("width", "271px");
			$(this).css("background-color", "#2579a9");
			$(this).css("color", "#fff");
			$(this).css("padding", "3px");
			$(this).find("h4").css("color", "#fff");

			templateSelected = true;
			$("#template-select-alert").hide();

		});

		/** Enviamos los correos */
		$("#send_emails").click(function() {

			if( templateSelected == true ) {

				$("#sending_success").show();
				
				var campaignData = {
					campaign_id: $("input[name='campaign_id']").val(),
					template_id: templateId,
					company: $("#company").val(),
					default_template_id: defaultTemplateId,
					list_id: $("#list_id_select").val(),
					subject: $("#subject").val(),
					from_name: $("#from_name").val(),
					from_email: $("#from_email").val(),
					_token: $("input[name='_token']").val(),
				}

				$.ajax({
					url: "/campaigns/send_campaign",
					type: "POST",
					data: campaignData,
					success: function( response ) {
						if ( response.status === 'success' ) {
                    		//console.log(response.result);
               			}
            		}
        		});
			}

		});

	});

</script>

@endsection
