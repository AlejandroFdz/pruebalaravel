@extends('layouts.app')

@section('content')
<div id="app" class="container web-container">
	<div class="row topbar">
		<div class="home-slide text-center" style="max-height: 200px; padding-top: 20px; padding-bottom: 40px;">
			<h1>{{Auth::user()->name}} {{Auth::user()->lastname}}</h1>
		</div>
		<div class="row section home-section-2" style="padding-bottom: 50px;">
			<div class="col-md-3"></div>
			<div class="col-md-6">

				{!! Form::open(['route' => 'user.update', 'method' => 'PUT', 'class' => 'form-horizontal', 'role' => 'form']) !!}

					@if(count($errors))
						<div class="form-group alert alert-danger">
							<strong>Whoops!</strong> Ocurrieron algunos errores al modificar tu información.
							<br/>
							<ul>
								@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
				
					<div class="form-group">
		                {{Form::label('name', 'Nombre')}}
		                {{Form::text('name', Auth::user()->name, array('class' => 'form-control', 'placeholder'=>'Nombre', 'required' => 'required'))}}
		                <span class="text-danger">{{ $errors->first('name') }}</span>
	              	</div>
	              	<div class="form-group">
		                {{Form::label('lastname', 'Apellidos')}}
		                {{Form::text('lastname', Auth::user()->lastname, array('class' => 'form-control', 'placeholder'=>'Apellidos', 'required' => 'required'))}}
		                <span class="text-danger">{{ $errors->first('lastname') }}</span>
	              	</div>
	              	<div class="form-group">
		                {{Form::label('company', 'Empresa')}}
		                {{Form::text('company', Auth::user()->company, array('class' => 'form-control', 'placeholder'=>'Empresa', 'required' => 'required'))}}
		                <span class="text-danger">{{ $errors->first('company') }}</span>
	              	</div>
	              	<div class="form-group">
		                {{Form::label('phone', 'Teléfono')}}
		                {{Form::text('phone', Auth::user()->phone, array('class' => 'form-control', 'placeholder'=>'Teléfono', 'required' => 'required'))}}
		                <span class="text-danger">{{ $errors->first('phone') }}</span>
	              	</div>	              	
	              	<div class="form-group">
		                {{Form::label('password', 'Contraseña')}}
		                {{Form::password('password', array('class' => 'form-control'))}}
		                <span class="text-danger">{{ $errors->first('password') }}</span>
	              	</div>
	              	<div class="form-group">
		                {{Form::label('confirm_password', 'Repetir Contraseña')}}
		                {{Form::password('confirm_password', array('class' => 'form-control'))}}
		                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
	              	</div>
	              	<div class="form-group">
	              		{!! Form::submit('Guardar Cambios', ['class' => 'btn btn-primary', 'style' => 'margin-top:10px;']) !!}
	              	</div>

	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	              	{{Form::hidden('id', Auth::user()->id)}}
	              	{{Form::hidden('email', Auth::user()->email)}}

				{!! Form::close() !!}

				@if( $message != '' )
					<div class="alert-success">
						{{ $message }}
					</div>
				@endif

			</div>
			<div class="col-md-3"></div>
		</div>
	</div>

	</div>
</div>
@endsection