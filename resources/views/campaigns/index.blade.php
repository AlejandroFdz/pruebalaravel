@extends('layouts.subscriptor.base')

@section('title')
  <h1>Campañas</h1>
@endsection

@section('topbar_button')
  <a href="{{ route('campaigns.create') }}" class="btn btn-primary">Crear Campaña</a>
@endsection

@section('content')

  @if(count($campaigns) != 0)

    <table class="table table-striped">
      <thead>
        <tr class="nodrag nodrop">
          <th class="center fixed-width-xs">
          </th>
          <th>
            <span class="title_box">
              Campaña
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
              Acciones
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($campaigns as $campaign)
          <tr>
            <td>
              <input type="checkbox" class="campaign_checkbox" name="chck_list" value="{{$campaign->id}}">
            </td>
            <td>
              <a href="campaigns/{{$campaign->id}}/edit">{{$campaign->name}}</a>
              <h4>{{$campaign->subject}}</h4>
              <p>Creada {{$campaign->created_at}}</p>
            </td>
            <td>
              <a href="campaigns/{{$campaign->id}}/edit" class="btn btn-default">Enviar</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <button class="btn btn-danger remove-campaign" style="display: none;">Eliminar</button>
    {{ csrf_field() }}

  @else

    <div class="row">
      <div class="alert alert-danger" role="alert">
        No has creado ninguna campaña, crea alguna para empezar a enviar correos
      </div>
    </div>

  @endif
@endsection

@section('scripts')
  <script type="text/javascript">
    $( document ).ready(function() {

      var campaignIdSelected = 0

      $('.campaign_checkbox').click(function() {

        var allUnchecked = true;
        
        $('.campaign_checkbox').prop('checked', false);
        $(this).prop('checked', true);

        campaignIdSelected = $(this).val()

        $( ".campaign_checkbox" ).each(function( index ) {
          
          if( $(this).is(":checked") ) {
            allUnchecked = false
          }

        });

        if( allUnchecked == false ) {
          $(".remove-campaign").show();
        }

      })

      $(".remove-campaign").click(function() {

        if( campaignIdSelected != 0 ) {

          var _token = $('input[name="_token"]').val()

          $.ajax({
              type: "DELETE",
              url: "campaigns/" + campaignIdSelected,
              data: { id: campaignIdSelected, _token : _token },
              success: function (data) {
                window.location.reload();
              },
              error: function (data) {
                console.log('Error:', data);
              }         
          });

        }

      })

    });
  </script>
@endsection