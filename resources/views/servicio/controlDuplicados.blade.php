@extends('layouts.app')

@section('content')


<div class="container">
    <h1>Esto está duplicado</h1>
    <p>Los marcados en <span style="color:#dc3545">Rojo serán eliminados</span> y reemplazados por el <span style="color:#20c997">nuevo registro</span></p>
    <table class="table">
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
            <tr class="table-info">
                <td>{{$datosActuales['abonado']}}</td>
                <td>{{$datosActuales['liston']}}</td>
                <td>{{$datosActuales['puertos']}}</td>
                <td>{{$datosActuales['tecnico']}}</td>
                <td>{{$datosActuales['fecha']}}</td>
                <td>{{$datosActuales['comentarios']}}</td>
                <td>Esta es la actual</td>
            </tr>
            @foreach ($datosDuplicados as $elemento)
            <tr class="table-warning">
                <td scope="row">{{$elemento->abonado}}</td>
                <td>{{$elemento->liston}}</td>
                <td>{{$elemento->puertos}}</td>
                <td>{{$elemento->tecnico}}</td>
                <td>{{$elemento->fecha}}</td>
                <td>{{$elemento->comentarios}}</td>
                <td>Se eliminarán</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a class="btn btn-outline-danger" href="{{url('/servicio')}}">Cancelar</a>
    <form action="{{url('/servicio')}}" method="post">
        @csrf
        <input type="hidden" name="abonado" value="{{$datosActuales['abonado']}}">
        <input type="hidden" name="liston" value="{{$datosActuales['liston']}}">
        <input type="hidden" name="puertos" value="{{$datosActuales['puertos']}}">
        <input type="hidden" name="tecnico" value="{{$datosActuales['tecnico']}}">
        <input type="hidden" name="fecha" value="{{$datosActuales['fecha']}}">
        <input type="hidden" name="comentarios" value="{{$datosActuales['comentarios']}}">
        <input type="hidden" name="llave" value="true">
        <input type="hidden" name="islast" value="1">
        <input class="btn btn-primary" type="submit" value="Guardar">
    </form>
    <!--<a class="btn btn-primary" href="{{url('/confirmar',$datosActuales)}}">Guardar</a>-->
</div>
@endsection