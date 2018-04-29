@extends('layouts.subscriptor.base')

@section('title')
  <h1>Crear Lista</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')

	{!! Form::open(['url' => 'lists', 'class' => 'form-horizontal', 'role' => 'form']) !!}
		
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
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la Lista']) !!}
						<small>Para uso interno en la applicación. Ej: "Lista Clientes#1"</small>
					</div>
				</div>

				<div class="form-group">
					<label for="description" class="col-lg-2 control-label">
						<span>Descripción</span>
					</label>
					<div class="col-lg-10">
						{!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Descripción de la Lista', 'size' => '30x3']) !!}
						<small>Texto descriptivo que verán los usuarios y que los alentará a subscribirse a tu newsletter.</small>
					</div>
				</div>

			</div>

			<div class="col-md-2"></div>

		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					{!! Form::submit('Crear lista', ['class' => 'btn btn-primary']) !!}
				</div>
			</div>
		</div>

	{!! Form::close() !!}
@endsection
