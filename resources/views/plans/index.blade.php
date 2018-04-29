@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Planes</div>
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item clearfix">
								<div class="pull-left">
									<h4>Trial</h4>										
									<p>Envío de correos ilimitados. Periodo de prueba por 30 días gratis.</p>
								</div>
								@if( $user->trial_ends_at == NULL )								
									<a href="http://correo.hormiga/trial/activar" class="btn btn-success pull-right">
										Elegir
									</a>
									<br><br>
									<span class="label label-info pull-right">Te quedan 30 días.</span>
								@else
									@if( $premium_days == 0 )
										<span class="label label-danger pull-right">Te quedan {{$days}} días.</span><br>
										@if( $days == 0 )
											<span class="label label-danger pull-right">Tu periodo de Trial ha expirado.</span>
										@endif
									@endif
								@endif															
							</li>
							<li class="list-group-item clearfix">
								<div class="pull-left">
									<h4>Premium</h4>
									<h4>$199MXN/mes</h4>
									<p>Campañas de Marketing Online y envío de correos ilimitados.</p>
								</div>

								@if( $premium_days == 0 || $premium_days > 30 )
									<a href="{{ route('paypal.express-checkout', ['recurring' => true]) }}" class="btn btn-primary pull-right">
										Elegir
									</a>
								@else
									<span class="label label-success pull-right">Tienes contratado el plan Premium.</span>
								@endif

							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
