@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Profesiones
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
            @foreach($professions as $profession)
            <tr>
                @if ($profession->profesion_id == $id)
                <form action="{{action('ProfessionController@update', $profession['profesion_id'])}}?page={{$page}}" method="post">
                    @csrf
                    <td>{{$profession['profesion_id']}}</td>
                    <td><input type="text" class="form-control" name="nombre" value="{{$profession->nombre}}"></td>
                    <td>
                        {{$profession['activo']}}
                        <input name="activo" type="hidden" value="{{$profession['activo']}}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success" style="margin-left:38px">Guardar</button>
                    </td>
                    <td>
                        <input name="_method" type="hidden" value="PATCH">
                        <a href="{{action('ProfessionController@index')}}?page={{$page}}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </td>
                </form>
                @else
                    <td>{{$profession['profession_id']}}</td>
                    <td>{{$profession['nombre']}}</td>
                    <td>{{$profession['activo']}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection