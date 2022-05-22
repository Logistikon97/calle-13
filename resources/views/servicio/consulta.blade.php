@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-outline-danger mt-2 mb-4" href="{{url('/servicio')}}" class="d-flex align-content-center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
        </svg> Volver atrás</a>
    <h1>Está en consultar</h1>
    <span>Buscar por abonado</span>

    <form class="d-flex mb-3" action="{{url('/consultar/abonado')}}" method="POST">
        @csrf
        <input name="abonado" class="form-control me-2" type="search" placeholder="Ej: 86354687" aria-label="Search" value="{{isset($respuesta)&&sizeOf($respuesta)!=0?$respuesta['0']->abonado:old('abonado')}}">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>
    @if (isset($respuesta)&&sizeOf($respuesta)!=0)
    <table class="table">
        <thead>
            <tr>
                <th>Abonado</th>
                <th>Listón</th>
                <th>Puertos</th>
                <th>Técnico</th>
                <th>Fecha</th>
                <th>Comentarios</th>
                <th class="w-1">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($respuesta as $elemento)
            <tr>
                <td scope="row">{{$elemento->abonado}}</td>
                <td>{{$elemento->liston}}</td>
                <td>{{$elemento->puertos}}</td>
                <td>{{$elemento->tecnico}}</td>
                <td>{{$elemento->fecha}}</td>
                <td>{{$elemento->comentarios}}</td>
                <td class="d-flex gap-3">
                    <a href="{{url('/servicio/'.$elemento->id.'/edit')}}" class="btn btn-outline-success">Modificar</a>

                    <form action="{{url('/servicio/'.$elemento->id)}}" method="post">
                        @csrf
                        {{method_field('DELETE')}}
                        <input class="btn btn-outline-danger" type="submit" value="Borrar" onclick="return confirm('¿Realmente quieres borrar?')">
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @else
    <h3>No se han encontrado resultados</h3>
    @endif

    <hr>
    <span class="">Buscar por puertos</span>
    <form class="" action="{{url('/consultar/puertos')}}" method="post">
        @csrf
        <label for="pots" class="me-3">POTS:</label>
        <input class="form-control me-2" type="text" placeholder="Ej: 3-15" name="pots" id="pots">

        <label for="adsl" class="me-3">ADSL:</label>
        <input class="form-control me-2" type="text" placeholder="Ej: 5-15" name="adsl" id="pots">

        <label for="dslam" class="">DSLAM</label>
        <select class="form-select mb-3" name="dslam" id="dslam">
            <option selected disabled>Elige un dslam</option>
            <option value="19.2">10.33.19.2</option>
            <option value="19.6">10.33.19.6</option>
            <option value="19.22">10.33.19.22</option>
            <option value="19.34">10.33.19.34</option>
            <option value="19.54">10.33.19.54</option>
            <option value="19.66">10.33.19.66</option>
            <option value="14.131">10.34.14.131</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>
    @if (isset($puertos)&&sizeOf($puertos)!=0)
    <table class="table">
        <thead>
            <tr>
                <th>Abonado</th>
                <th>Listón</th>
                <th>Puertos</th>
                <th>Técnico</th>
                <th>Fecha</th>
                <th>Comentarios</th>
                <th class="w-1">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($puertos as $elemento)
            <tr>
                <td scope="row">{{$elemento->abonado}}</td>
                <td>{{$elemento->liston}}</td>
                <td>{{$elemento->puertos}}</td>
                <td>{{$elemento->tecnico}}</td>
                <td>{{$elemento->fecha}}</td>
                <td>{{$elemento->comentarios}}</td>
                <td class="d-flex gap-3">
                    <a href="{{url('/servicio/'.$elemento->id.'/edit')}}" class="btn btn-outline-success">Modificar</a>

                    <form action="{{url('/servicio/'.$elemento->id)}}" method="post">
                        @csrf
                        {{method_field('DELETE')}}
                        <input class="btn btn-outline-danger" type="submit" value="Borrar" onclick="return confirm('¿Realmente quieres borrar?')">
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <a class="btn btn-outline-danger mt-4 mb-4" href="{{url('/servicio')}}" class="d-flex align-content-center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
        </svg> Volver atrás</a>
</div>



@endsection