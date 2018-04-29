@extends('layouts.subscriptor.base')

@section('title')
  <h1>{{ $list->name }}</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')
	
	<div class="row import-contacts">
	
		<div class="col-md-8">

			<div class="row">

				<ol class="breadcrumb">
				  <li><a href="{{ route('subscriptor.dashboard') }}">Dashboard</a></li>
				  <li><a href="{{ route('lists.index') }}">Listas</a></li>
				  <li><a href="/lists/{{ $list->id }}/edit">{{ $list->name }}</a></li>
				  <li class="active">Añadir contactos</li>
				</ol>

				<h3 class="form-subtitles">
					<i class="fa fa-users" aria-hidden="true"></i>
					Crea y selecciona grupos de contactos para importarlos
				</h3>
				
				{!! Form::open(['route' => 'groups.store', 'class' => 'form-inline', 'role' => 'form']) !!}

					<div class="form-group" style="margin-bottom:10px;">

						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del grupo...']) !!}

						{!! Form::hidden('list_id', $list->id) !!}

						{!! Form::submit('Crear grupo', array('class' => 'btn btn-primary')) !!}

					</div>

				{!! Form::close() !!}

				<h4>Selecciona el grupo donde importarás los contactos</h4>
				
				{!! Form::open(['method' => 'DELETE', 'id' => 'formDeleteGroup', 'action' => ['GroupsResourceController@destroy', 0], 'class' => 'form-horizontal']) !!}

					<div class="row">

						<div class="col-md-12">

							@if( count($groups) > 0 )
								<ul class="list groups-list">
									@foreach( $groups as $group )
										<li> 
											<input type="checkbox" name="groups[]" class="group_item" value="{{$group->id}}">
											{{ $group->name }}
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
							@else					
								<div class="alert alert-danger" role="alert" >
									No se encontró ningún grupo, agrega alguno para empezar a importar contactos
								</div>
							@endif

							<div class="alert alert-danger remove_groups" role="alert" >
								¿Estás seguro de que quieres eliminar los grupos y sus contactos?
								<div class="pull-right">
									<button type="submit" class="removeSubmit">
										<i class="fa fa-check" aria-hidden="true"></i>
									</button>
									<button type="button" class="cancelSubmit">
										<i class="fa fa-times" aria-hidden="true"></i>
									</button>
								</div>
							</div>

						</div>

					</div>
					
					<div class="row removeGroup">

						<div class="col-md-12">

							<button type="button" class="btn btn-danger remove-button">Eliminar</button>

						</div>

					</div>

					{!! Form::token() !!}

				{!! Form::close() !!}

				<h3 class="form-subtitles">
					<i class="fa fa-list" aria-hidden="true"></i>
					Añade un contacto por línea
				</h3>

				{!! Form::open(['url' => 'contacts', 'class' => 'form-inline', 'role' => 'form']) !!}

					<div class="form-group form_inputs" style="margin-bottom:10px;">

						{!! Form::email('email[]', null, ['class' => 'form-control', 'placeholder' => 'Dirección de correo...', 'required' => 'required']) !!}
						{!! Form::text('name[]', null, ['class' => 'form-control', 'placeholder' => 'Nombre...']) !!}
						{!! Form::text('lastname[]', null, ['class' => 'form-control', 'placeholder' => 'Apellidos...']) !!}

						{!! Form::hidden('list_id', $list->id) !!}
						{!! Form::hidden('groups_id', null, ['id' => 'groups_id']) !!}

					</div>

					<div id="more_contacts"></div>

					<div class="form-group" style="display:block;">
						
						<button type="button" class="btn btn-default addRow pull-left" title="Agregar otro contacto">
							<i aria-hidden="true" class="fa fa-user-plus"></i>
							Añadir contacto
						</button>						

						{!! Form::submit('Agregar contactos', array('class' => 'btn btn-primary ClientsPerRow pull-right', 'name' => 'clients_per_line')) !!}

					</div>
					
					@if ( session('request_submit') == 'clients_per_line' )

						@if ( session('contacts') )
							@foreach( session('contacts') as $contacts )
								<div class="alert alert-danger subscriber-warning" role="alert" style="float:left;">
									El correo <strong>{{ $contacts->email }}</strong> ya estaba registrado en la lista.
								</div>
							@endforeach
						@endif

						@if ( session('contacts_imported') )
							<div class="alert alert-success subscriber-warning" role="alert" style="float:left;">							
								<strong>{{ session('contacts_imported') }}</strong> 
								@if(session('contacts_imported') > 1)
									contactos importados
								@else
									contacto importado
								@endif
							</div>
						@endif

					@endif
					
					{!! Form::token() !!}

				{!! Form::close() !!}

			</div>

			<div class="row">

				<h3 class="form-subtitles" style="margin-top: 50px;">
					<i class="fa fa-file-excel-o" aria-hidden="true"></i>
					Importa un archivo CSV/XLS
				</h3>

				{!! Form::open(['url' => 'contacts', 'files' => true, 'class' => 'form-inline', 'role' => 'form']) !!}
					<div class="form-group">
						<input type="file" name="csv_file" >
					</div>

					{!! Form::hidden('groups_id_2', null, ['id' => 'groups_id_2']) !!}
					{!! Form::submit('Subir CSV/XLS', array('class' => 'btn btn-primary ClientsPerCSV pull-right', 'name' => 'import_csv')) !!}
					{!! Form::button('Cancelar', array('class' => 'btn btn-default pull-right', 'style' => 'margin-right:5px;')) !!}

					@if ( session('request_submit') == 'import_csv' )

						@if ( session('file_errors') )
							@foreach( session('file_errors') as $file_error )
								<div class="alert alert-danger subscriber-warning" role="alert" style="float:left;">
									{{ $file_error }}
								</div>
							@endforeach
						@endif

						@if ( session('contacts_imported') )
							<div class="alert alert-success subscriber-warning" role="alert" style="float:left;">							
								<strong>{{ session('contacts_imported') }}</strong> 
								@if(session('contacts_imported') > 1)
									contactos importados
								@else
									contacto importado
								@endif
							</div>
						@endif

						@if ( session('contacts') )
							@foreach( session('contacts') as $contacts )
								<div class="alert alert-danger subscriber-warning" role="alert" style="float:left;">
									El correo <strong>{{ $contacts->email }}</strong> ya estaba registrado en la lista.
								</div>
							@endforeach
						@endif

						@if ( session('error_lines') )
							@foreach( session('error_lines') as $error_line )
								<div class="alert alert-danger subscriber-warning" role="alert" style="float:left;">
									Error en la línea <strong>{{ $error_line }}</strong>, escribiste mal el correo del contacto o separaste mal los campos.
								</div>
							@endforeach
						@endif

					@endif

					{!! Form::token() !!}

				{!! Form::close() !!}

			</div>

			<div class="row">
				
				<h3 class="form-subtitles" style="margin-top:50px;">
					<i class="fa fa-clipboard" aria-hidden="true"></i>
					Copia y Pega los contactos
					<small>Separa los distintos campos con comas simples</small>
				</h3>

				{!! Form::open(['url' => 'contacts', 'class' => 'form-inline', 'role' => 'form']) !!}
					<div class="form-group">
						{!! Form::textarea('contacts_per_line', old('contacts_per_line'), 
							array(
								'class' => 'form-control subscribers_per_line', 
								'cols' => '90',
								'placeholder' => 'Correo electrónico, Nombre, Apellidos',
								'style' => 'margin-bottom:10px;',
								'required' => 'required'
								)
							) 
						!!}
						{!! Form::hidden('groups_id_3', null, ['id' => 'groups_id_3']) !!}
						{{ csrf_field() }}
					</div>

					@if ( session('request_submit') == 'subscribers_per_line' )

						@if ( session('contacts') )
							@foreach( session('contacts') as $contacts )
								<div class="alert alert-danger subscriber-warning" role="alert" style="float:left;">
									El correo <strong>{{ $contacts->email }}</strong> ya estaba registrado en la lista.
								</div>
							@endforeach
						@endif

						@if ( session('contacts_imported') )
							<div class="alert alert-success subscriber-warning" role="alert" style="float:left;">							
								<strong>{{ session('contacts_imported') }}</strong> 
								@if(session('contacts_imported') > 1)
									contactos importados
								@else
									contacto importado
								@endif
							</div>
						@endif

						@if ( session('error_lines') )
							@foreach( session('error_lines') as $error_line )
								<div class="alert alert-danger subscriber-warning" role="alert" style="float:left;">
									Error en la línea <strong>{{ $error_line }}</strong>, escribiste mal el correo del contacto o separaste mal los campos.
								</div>
							@endforeach
						@endif

					@endif
					
					{!! Form::token() !!}

					{!! Form::submit('Importar contactos', array('name' => 'subscribers_per_line', 'class' => 'btn btn-primary ClientsPerLine pull-right')) !!}
				
				{!! Form::close() !!}

			</div>

		</div>

	</div>

@endsection

@section('scripts')
<script type="text/javascript">
	$( document ).ready(function() {

		$(".subscribers_per_line").setNumber({
          activeLine: 9
        });
        // jquery-autosize (optional)
        $(".subscribers_per_line").autosize({
          callback: function(textarea) {
            $(textarea).scroll();
          }
        });
        $(".subscribers_per_line").focus();

		// Add new contact line
		$('.addRow').on('click', function() {
	    	//$("#more_contacts").append($(".form_inputs:first").clone()).html();
	    	$("#more_contacts").append('<div class="form-group form_inputs" style="margin-bottom: 10px;"><input placeholder="Dirección de correo..." name="email[]" type="email" class="form-control"> <input placeholder="Nombre..." name="name[]" type="text" class="form-control"> <input placeholder="Apellidos..." name="lastname[]" type="text" class="form-control"></div>');
	    });

	    // Desactivamos los botones de importación en caso de que
	    // no existan grupos seleccionados
	    var groupCheckedItems = 0;
	    $('.group_item:checked').each(function() {
	    	groupCheckedItems++;
	   	})

	   	if( groupCheckedItems == 0 ) {
	    	$('.ClientsPerRow').attr('disabled','disabled');
	    	$('.ClientsPerCSV').attr('disabled','disabled');
	    	$('.ClientsPerLine').attr('disabled','disabled');
	   	}

	   	$(".remove-button").click(function() {
	   		$(".remove_groups").fadeIn("slow");
	   	})

	   	$(".cancelSubmit").click(function() {
	   		$(".remove_groups").fadeOut("slow");
	   	})

	    // Remove groups	    
	    $(".group_item").click(function() {
	    	
	    	var groupCheckedItems = 0;
	    	var groupIds = "";

	    	if( $(this).prop('checked') == true ) {

	    		groupIds = $("#groups_id").val();

	    		if( groupIds.search( $(this).val() ) == -1 ) {

	    			if( groupIds == "" ) {
	    				groupIds += $(this).val();
	    			} else {
	    				groupIds += "," + $(this).val();
	    			}
	    		}

	    	} else {

	    		groupIds = $("#groups_id").val();

	    		if( groupIds.search(",") == -1 ) {
	    			groupIds = groupIds.replace( $(this).val(), "" );
	    		} else {
	    			if( groupIds.search( "," + $(this).val() ) > -1 ) {
	    				groupIds = groupIds.replace( ","+$(this).val(), "" );
	    			} else {
	    				groupIds = groupIds.replace( $(this).val() + ",", "" );
	    			}
	    		}

	    	}

	    	// Asignamos los ids de los grupos al campo oculto
	    	$("#groups_id").val( groupIds );
	    	$("#groups_id_2").val( groupIds );
	    	$("#groups_id_3").val( groupIds );
	    	
	    	// Recorremos todos los grupos y contamos el total de grupos activados
	    	$('.group_item:checked').each(function() {
	    		groupCheckedItems++;
	    	})

	    	// Si hay algún grupo seleccionado mostramos el botón de eliminar grupo
	    	// y activamos los botones de submit para importar contactos
	    	if( groupCheckedItems > 0 ) {

	    		$(".removeGroup").fadeIn("slow");

	    		$('.ClientsPerRow').removeAttr('disabled');
	    		$('.ClientsPerCSV').removeAttr('disabled');
	    		$('.ClientsPerLine').removeAttr('disabled');

	    	} else if( groupCheckedItems == 0 ) {
	    		
	    		$(".removeGroup").hide();

	    		$('.ClientsPerRow').attr('disabled','disabled');
	    		$('.ClientsPerCSV').attr('disabled','disabled');
	    		$('.ClientsPerLine').attr('disabled','disabled');
	    		
	    	}
	    })

	    // Validación para la importación de subscriptores por línea
	    var subscribersPerLine = $(".subscribers_per_line").val();

	});
</script>
@endsection
