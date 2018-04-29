@extends('layouts.subscriptor.base')

@section('title')
  <h1>Lista: {{$list->name}}</h1>
@endsection

@section('topbar_button')
@endsection

@section('content')
<div class="row">

	
		
		{!! Form::open(['url' => 'contacts', 'method' => 'GET', 'id' => 'form_contacts', 'class' => 'form-inline', 'role' => 'form']) !!}

		<table class="table table-striped">
			<thead>
				<tr class="nodrag nodrop">
					<th class="center fixed-width-xs">
						<input type="checkbox" class="chck_all" name="chck_all">
					</th>
					<th>
						<span class="title_box">
							Correo
							<a href="#">
								<i class="fa fa-caret-down" aria-hidden="true"></i>
							</a>
							<a href="#">
								<i class="fa fa-caret-up" aria-hidden="true"></i>
							</a>
						</span>
					</th>
					<th>
						<span class="title_box">
							Nombre
						</span>
					</th>
					<th>
						<span class="title_box">
							Apellidos
						</span>
					</th>					
					<th>
						<span class="title_box">
							Grupo
						</span>
					</th>
					<th>
					</th>
				</tr>
				<tr class="nodrag nodrop table-filter-header">
					<th class="center fixed-width-xs">						
					</th>
					<th>
						{!! Form::text('email', app('request')->input('email'), ['class' => 'form-control']) !!}
					</th>
					<th>
						{!! Form::text('name', app('request')->input('name'), ['class' => 'form-control']) !!}
					</th>
					<th>
						{!! Form::text('lastname', app('request')->input('lastname'), ['class' => 'form-control']) !!}
					</th>					
					<th>
						{!! Form::select('filter_groups_id', $groups, app('request')->input('filter_groups_id'), array('class' => 'form-control')) !!}
					</th>
					<th>
						{!! Form::submit('Filtrar', array('class' => 'btn btn-primary', 'name' => 'contacts_filter_submit', 'style' => 'width:100px;')) !!}
					</th>
				</tr>
			</thead>
			<tbody>    	
				@foreach($subscribers as $subscriber)
				<tr>
					<td>
						<input type="checkbox" name="chk_subscribers[]" class="chk_subscribers_items" value="{{ $subscriber->id }}">
					</td>
					<td>
						{{ $subscriber->email }}
					</td>						        
					<td>
						{{ $subscriber->name }}
					</td>
					<td>
						{{ $subscriber->lastname }}
					</td>					
					<td>
						{{ $subscriber->group_name }}
					</td>
					<td></td>
				</tr>
				@endforeach

			</tbody>
		</table>

		<div class="row" style="display:none;">
			<div class="col-md-4">
					{!! Form::hidden('subscribers_ids', null, ['id' => 'subscribers_ids'])  !!}
			</div>
		</div>

		@if(count($subscribers) == 0)
			<div class="row sin-resultados">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					No se encontraron resultados
				</div>
				<div class="col-md-4"></div>
			</div>
		@endif

		{!! Form::hidden('id', $list->id)  !!}

		{{ $subscribers->appends([
			'id' => $list->id, 
			'email' => app('request')->input('email'),
			'name' => app('request')->input('name'),
			'lastname' => app('request')->input('lastname'),
			'filter_groups_id' => app('request')->input('filter_groups_id')
		])->render() }}

		{!! Form::close() !!}
	
		<div class="remove-contacts-container">
			<div class="remove-contacts-form">
				{!! Form::open(['method' => 'DELETE', 'id' => 'formDeleteProduct', 'action' => ['ContactsController@destroy', 0], 'class' => 'form-horizontal']) !!}
					{!! Form::hidden('subscribers_ids_delete', null, ['id' => 'subscribers_ids_delete']) !!}
					{!! Form::hidden('id', $list->id)  !!}
					{!! Form::submit('Eliminar', array('class' => 'btn btn-danger subscribers_delete_submit')) !!}			
				{!! Form::close() !!}
			</div>
		</div>

</div>
@endsection
@section('scripts')
	<script type="text/javascript">

		if( $(".pagination").length ) {
			$(".remove-contacts-container").css("top", "-49px");
		} else {
			$(".remove-contacts-container").css("top", "0px");
		}

		var subscribersIds = "";

		$(".chck_all").click(function() {

			subscribersIds = ""
			$("#subscribers_ids").val("");

			if( $(this).prop('checked') == true ) {

				$(".chk_subscribers_items").prop('checked', true);
				$(".remove-contacts-form").show();

				$('.chk_subscribers_items').each(function() {
					if( subscribersIds == "" ) {
	    				subscribersIds += $(this).val();
	    			} else {
	    				subscribersIds += "," + $(this).val();
	    			}
				})

			} else {
				$(".chk_subscribers_items").prop('checked', false);
				$(".remove-contacts-form").hide();
			}

			$("#subscribers_ids").val( subscribersIds );
			$("#subscribers_ids_delete").val( subscribersIds );

		})

		$(".chk_subscribers_items").click(function() {

			var groupCheckedItems = 0;
			subscribersIds = "";

			if( $(this).prop('checked') == true ) {
				$(".remove-contacts-form").show();
			}

			// Recorremos todos los grupos y contamos el total de grupos activados
	    	$('.chk_subscribers_items:checked').each(function() {
	    		groupCheckedItems++;
	    	})

	    	if( groupCheckedItems == 0 ) {
	    		$(".remove-contacts-form").hide();
	    	}

	    	if( $(this).prop('checked') == true ) {

	    		subscribersIds = $("#subscribers_ids").val();

	    		if( subscribersIds.search( $(this).val() ) == -1 ) {

	    			if( subscribersIds == "" ) {
	    				subscribersIds += $(this).val();
	    			} else {
	    				subscribersIds += "," + $(this).val();
	    			}
	    		}

	    	} else {

	    		subscribersIds = $("#subscribers_ids").val();

	    		if( subscribersIds.search(",") == -1 ) {
	    			subscribersIds = subscribersds.replace( $(this).val(), "" );
	    		} else {
	    			if( subscribersIds.search( "," + $(this).val() ) > -1 ) {
	    				subscribersIds = subscribersIds.replace( ","+$(this).val(), "" );
	    			} else {
	    				subscribersIds = subscribersIds.replace( $(this).val() + ",", "" );
	    			}
	    		}

	    	}

	    	$("#subscribers_ids").val( subscribersIds );
	    	$("#subscribers_ids_delete").val( subscribersIds );

		})
	</script>
@endsection