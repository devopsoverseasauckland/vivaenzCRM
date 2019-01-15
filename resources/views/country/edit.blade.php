@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Paises
    </h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Activo</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($countries as $country)
            <tr>
                @if ($country->pais_id == $id)
                <form action="{{action('CountryController@update', $country['pais_id'])}}?page={{$page}}" method="post">
                    @csrf
                    <td>{{$country['pais_id']}}</td>
                    <td><input type="text" class="form-control" name="nombre" value="{{$country->nombre}}"></td>
                    <td>
                        {{$country['activo']}}
                        <input name="activo" type="hidden" value="{{$country['activo']}}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success" style="margin-left:38px">Guardar</button>
                    </td>
                    <td>
                        <input name="_method" type="hidden" value="PATCH">
                        <a href="{{action('CountryController@index')}}?page={{$page}}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </td>
                </form>
                @else
                    <td>{{$country['pais_id']}}</td>
                    <td>{{$country['nombre']}}</td>
                    <td>{{$country['activo']}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @if (count($countries) > 0)
    {{ $countries->links() }} 
    @endif--}}
@endsection