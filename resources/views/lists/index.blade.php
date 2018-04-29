@extends('layouts.subscriptor.base')

@section('title')
  <h1>Listas</h1>
@endsection

@section('topbar_button')
  <a href="{{route('lists.create')}}" class="btn btn-primary">Crear Lista</a>
@endsection

@section('content')

  @if( count($lists) > 0 )
    <table class="table table-striped">
      <thead>
        <tr class="nodrag nodrop">
          <th class="center fixed-width-xs">
            <input type="checkbox" name="chck_all">
          </th>
          <th>
            <span class="title_box">
              Lista
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
              Estadísticas
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

        @foreach($lists as $list)
          <tr>
          <td>
            <input type="checkbox" name="chck_list" value="1">
          </td>
          <td>
            <a href="lists/{{ $list->id }}/edit">{{ $list->name }}</a>
            <h4>Creada el {{ $list->created_at }}</h4>
            <p>No rating yet</p>
          </td>
          <td>
            <div class="list_stats">
              <h4>{{ $subscriber_count[$loop->index] }}</h4>
              @if( $subscriber_count[$loop->index] > 1 )
                <p>Suscritos</p>
              @else
                <p>Suscrito</p>
              @endif
            </div>
            <div class="list_stats">
              <h4>{{ $list_opens[$loop->index] }}%</h4>
              <p>Vistos</p>
            </div>
            <div class="list_stats">
              <h4>{{ $list_clicked[$loop->index] }}%</h4>
              <p>Clicks</p>
            </div>
          </td>
          <td>

            <div class="dropdown pull-right">
              <button class="btn btn-default dropdown-toggle subscriber-account-btn" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Opciones
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="alert-danger">
                  <a href="{{url('/lists/')}}/{{$list->id}}" class="remove-list" data-id="{{$list->id}}">Eliminar</a>
                </li>
              </ul>
              {{ csrf_field() }}
            </div>

            <a href="{{ route('contacts.create', array('id' => $list->id)) }}" class="btn btn-default pull-right" style="margin-right: 8px;">
              <i class="fa fa-user-plus" aria-hidden="true"></i>
            </a>

          </td>
        </tr>

        @endforeach

      </tbody>
    </table>

  @else
    
    <div class="row">
      <div class="alert alert-danger" role="alert">
        No hay ninguna lista, crea alguna para empezar a importar contactos
      </div>
    </div>

  @endif

@endsection

@section('scripts')
  
  <script type="text/javascript">
    $( document ).ready(function() {
      
      $(".remove-list").click(function(event) {
        event.preventDefault();
        var listId = $(this).data("id")

        var _token = $('input[name="_token"]').val()

        $.ajax({
          type: "DELETE",
          url: "lists/" + listId,
          data: { id: listId, _token : _token },
          success: function (data) {
            window.location.reload();
          },
          error: function (data) {
            console.log('Error:', data);
          }         
        });

      })

    });
  </script>

@endsection
