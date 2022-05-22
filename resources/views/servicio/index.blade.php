@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3 container-fluid">
        <a class="btn btn-success mb-3"  href="{{url('/servicio/create')}}">Agregar vías nuevas</a>
        <a class="btn btn-primary mb-3"  href="{{url('/consultar')}}">Consultar/editar vías</a>
        <a class="btn btn-outline-primary mb-3"  href="{{url('/listones')}}">Ver datos por listón</a>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Abonado</th>
                <th>Listón</th>
                <th>Puertos</th>
                <th>Técnico</th>
                <th>Fecha</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($elementos as $elemento)
            @if ($elemento->islast)
                <tr style="background-color:#a8dadc;">
            @else
            <tr>
            @endif
                <td scope="row">{{$elemento->abonado}}</td>
                <td>{{$elemento->liston}}</td>
                <td>{{$elemento->puertos}}</td>
                <td>{{$elemento->tecnico}}</td>
                <td>{{$elemento->fecha}}</td>
                <td>{{$elemento->comentarios}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection