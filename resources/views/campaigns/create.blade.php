@extends('layouts.subscriptor.base')

@section('title')
  <h1>Crear Campaña</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')

	{!! Form::open(['route' => 'campaigns.store', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
		
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
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la Campaña']) !!}
						<small>Para uso interno en la applicación. Ej: "Newsletter Prueba#2"</small>
					</div>
				</div>
				<div class="form-group">
					<label for="company" class="col-lg-2 control-label">
						<span>Empresa</span>
					</label>
					<div class="col-lg-10">
						{!! Form::text('company', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la Empresa']) !!}
						<small>Escribe el nombre de la empresa que aparecerá como emisora de la campaña.</small>
					</div>
				</div>
				<div class="form-group">
					<label for="subject" class="col-lg-2 control-label">
						<span>Asunto</span>
					</label>
					<div class="col-lg-10">
						{!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Asunto del correo']) !!}
						<small>Escribe un buen asunto, sólo así leerán tus newsletters.</small>
					</div>
				</div>
				<div class="form-group">
					<label for="from" class="col-lg-2 control-label">
						<span>Nombre desde:</span>
					</label>
					<div class="col-lg-10">
						{!! Form::text('from', null, ['class' => 'form-control', 'placeholder' => 'Nombre del emisor']) !!}
						<small>Usa algo que tus subscritores reconozcan instantáneamente, como tu nombre de empresa.</small>
					</div>
				</div>
				<div class="form-group">
					<label for="from_email" class="col-lg-2 control-label">
						<span>Correo desde:</span>
					</label>
					<div class="col-lg-10">
						{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo del emisor']) !!}
					</div>
				</div>
			</div>

			<div class="col-md-2"></div>

		</div>

		<div class="row" style="margin-top:25px;">
			<div class="col-md-8">
				<div class="form-group">
					{!! Form::submit('Crear campaña', ['class' => 'btn btn-primary btn-lg']) !!}
				</div>
			</div>
		</div>

	{!! Form::close() !!}

@endsection