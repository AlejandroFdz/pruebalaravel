@extends('layouts.admin.base')

@section('content')
<div id="app" class="container web-container">
	<div class="row topbar">
		<div class="home-slide text-center" style="max-height: 200px; padding-top: 20px; padding-bottom: 40px;">
			<h1>Correo Hormiga</h1>
		</div>
		<div class="row section home-section-2" style="padding-bottom: 50px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<h2>Estadísticas</h2>
				
				<div class="row">
					<div class="col-md-6">
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-dont-mix">
							<h4>Clientes activos: {{$total_users}}</h4>
						</div>
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-dont-mix">
							<h4>Suscritos activos: {{$total_subscribers}}</h4>
						</div>
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-dont-mix">
							<h4>Listas activas: {{$total_lists}}</h4>
						</div>
					</div>
					<div class="col-md-6">
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-dont-mix">
							<h4>Grupos activos: {{$total_groups}}</h4>
						</div>
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-dont-mix">
							<h4>Tickets creados: {{$total_tickets}}</h4>
						</div>
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-dont-mix">
							<h4>Posts publicados: {{$total_posts}}</h4>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
				</div>

			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
@endsection