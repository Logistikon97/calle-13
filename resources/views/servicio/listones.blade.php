@extends('layouts.app')


@section('content')
<div class="container">
    <h1>Listones</h1>
    <form action="{{url('/listones/mostrar')}}" method="post">
        @csrf
        <label for="liston" class="control-label">Listón:</label>
        <div class="hstack">
            <input type="text" name="liston" id="liston" class="form-control me-2" placeholder="Ej: 0102">
            <input type="submit" value="Buscar" class="btn btn-outline-success">
        </div>
    </form>

    <div class="container mt-5 mb-5" style="border: 1px solid #bc6c25;">
        @if (isset($liston))
        @php($cont=0)
        @for ($i = 1; $i <= 20; $i++) <div class="row mb-2">
            <hr>
            @for ($j = 0; $j < 5; $j++) @php($cont++) @php($llave=true) @foreach ($liston as $valor) @php($texto=$valor->liston)
                @php($array = explode('-',$texto))
                @php($par = $array[1])
                @if ($cont==$par)
                <!-- Botón Modal -->
                <div class="col">
                    <button type="button" class="btn btn-primary p-1" data-bs-toggle="modal" data-bs-target="#lapiz{{$par}}">par {{$par}}</button>
                    <!-- Modal -->
                    <div class="modal fade" id="lapiz{{$par}}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">{{$valor->liston}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>abonado</th>
                                                <th>puertos</th>
                                                <th>fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row">{{$valor->abonado}}</td>
                                                <td>{{$valor->puertos}}</td>
                                                <td>{{$valor->fecha}}</td>
                                            </tr>
                                            <form action="{{url('/servicio/'.$valor->id)}}" method="post">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <input class="btn btn-outline-danger" type="submit" value="Borrar" onclick="return confirm('¿Realmente quieres borrar?')">
                                            </form>
                                        </tbody>
                                    </table>
                                    <div class="mt-1">
                                        <p style="color:#adb5bd">Sí hay duplicados. Deberías eliminar el dato más antiguo</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Listo </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php($llave=false)
                @endif
                @endforeach
                @if($llave)
                @php($llave=true)
                <div class="col">par {{$cont}}</div>
                @endif

                @endfor
    </div>
    <div>

    </div>
    @endfor
    @endif

</div>
<p>La información sobre los puertos se muestran al hacer clic sobre el botón</p>
@endsection