@extends('layouts.subscriptor.base')

@section('title')
  <h1>Editar Lista</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')
	
	{{ Form::model($list, array('route' => array('lists.update', $list->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
		
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
						{!! Form::text('name', $list->name, ['class' => 'form-control', 'placeholder' => 'Nombre de la Lista']) !!}
						<small>Para uso interno en la applicación. Ej: "Lista Clientes#1"</small>
					</div>
				</div>

				<div class="form-group">
					<label for="description" class="col-lg-2 control-label">
						<span>Descripción</span>
					</label>
					<div class="col-lg-10">
						{!! Form::textarea('description', $list->description, ['class' => 'form-control', 'placeholder' => 'Descripción de la Lista', 'size' => '30x3']) !!}
						<small>Texto descriptivo que verán los usuarios y que los alentará a subscribirse a tu newsletter.</small>
					</div>
				</div>

			</div>

			<div class="col-md-2"></div>

		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					{!! Form::submit('Modificar lista', ['class' => 'btn btn-primary']) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<ul class="nav nav-pills nav-lists">
			  <li role="presentation" class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			      Gestionar contactos <span class="caret"></span>
			    </a>
			    <ul class="dropdown-menu">
			      <li>			      	
			      	<a href="{{ route('contacts.index', array('id' => $list->id)) }}"><strong>Ver todos los contactos</strong></a>
			      	<a href="{{ route('contacts.create', array('id' => $list->id)) }}">Añadir contactos</a>
			      </li>
			    </ul>
			  </li>
			  <li role="presentation">
			  	<a href="#" class="inscription-forms">Formulario de inscripción</a>
			  </li>
			</ul>
		</div>

		{!! Form::close() !!}

		<div class="row subscription-forms">
			
			<p>
				<strong>					
					Copia y pega éste código en tu sitio web, tienda online o blog para que los usuarios puedan suscribirse directamente a la lista de contactos: <span style="text-transform: uppercase;">{{ $list->name }}</span>.
					}
				</strong>
			</p>

			<h4 style="margin-top:15px;">Elige el grupo donde quieres que se suscriban los usuarios.</h4>

			<select id="select_group" class="form-control" style="margin-bottom:20px;">
				@foreach ($groups as $group)
					<option value="{{$group->id}}">{{$group->name}}</option>
				@endforeach
			</select>

			<div class="form_code">
				<link href="http://correo.hormiga/css/forms/styles.css" rel="stylesheet" type="text/css">
				<form action="http://correo.hormiga/contacts/form_subscribe" method="POST">
					<input type="text" name="u_name" placeholder="Nombre" required>
					<input type="text" name="u_lastname" placeholder="Apellidos" required>
					<input type="email" name="u_email" placeholder="Correo" required>
					<input type="hidden" id="group_id" name="group_id" value="{{$first_group_id}}">
					<input type="hidden" name="token" value="{{$u_token}}">
					<input type="submit" name="f_submit" value="Suscribirme">
				</form>
			</div>

			<pre id="form_text"></pre>

		</div>	

@endsection

@section('scripts')
<script type="text/javascript">
	$( document ).ready(function() {

		var html = $('.form_code').html().replace(/</g, "&lt;").replace(/>/g, "&gt;\n");
		$("#form_text").append(html);
		
	    $(".inscription-forms").click(function(event) {
	    	event.preventDefault();
	    	$(".subscription-forms").toggle();
	    });

	    $("#select_group").change(function(){

	    	$("#group_id").val($("#select_group option:selected").val());
	    	$("#form_text").html("");
	    	
	    	var html = $('.form_code').html().replace(/</g, "&lt;").replace(/>/g, "&gt;\n");
			$("#form_text").append(html);

	    });

	});
</script>
@endsection