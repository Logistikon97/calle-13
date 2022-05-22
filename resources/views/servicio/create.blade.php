@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{url('/servicio')}}" method="post">
    @csrf
    @include('servicio.formulario')
</form>
</div>
@endsection