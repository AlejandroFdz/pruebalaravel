@extends('layouts.subscriptor.base')

@section('title')
  <h1>Debug...</h1>
@endsection

@section('content')

  @foreach($components as $component)
    {{$component->name}}<br>
  @endforeach

@endsection