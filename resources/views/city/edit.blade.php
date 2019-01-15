@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Ciudades
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
            
            @foreach($cities as $city)
            <tr>
                @if ($city->ciudad_id == $id)
                <form action="{{action('CityController@update', $city['ciudad_id'])}}?page={{$page}}" method="post">
                    @csrf
                    <td>{{$city['ciudad_id']}}</td>
                    <td><input type="text" class="form-control" name="nombre" value="{{$city->nombre}}"></td>
                    <td>
                        {{$city['activo']}}
                        <input name="activo" type="hidden" value="{{$city['activo']}}">
                        {{-- <input id="countryId" name="countryId" type="hidden" value="{{ $countryId }}">  --}}
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success" style="margin-left:38px">Guardar</button>
                    </td>
                    <td>
                        <input name="_method" type="hidden" value="PATCH">
                        <a href="{{action('CityController@index')}}?page={{$page}}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </td>
                </form>
                @else
                    <td>{{$city['ciudad_id']}}</td>
                    <td>{{$city['nombre']}}</td>
                    <td>{{$city['activo']}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @if (count($cities) > 0)
    {{ $cities->links() }} 
    @endif--}}
@endsection