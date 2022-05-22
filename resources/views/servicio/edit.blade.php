@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Está en edit</h1>

    <form action="{{url('/servicio/'.$datos->id)}}" method="post" class="d-flex ">
        @csrf
        {{method_field('PATCH')}}
        @include('servicio.formulario')
    </form>
    <a class="btn btn-outline-danger" href="{{url('/consultar')}}">Cancelar</a>
    
</div>
@endsection