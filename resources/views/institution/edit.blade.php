@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Instituciones
    </h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoria NZQA</th>
                <th>Activo</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($institutions as $institution)
            <tr>
                @if ($institution->institucion_id == $id)
                <form action="{{action('InstitutionController@update', $institution['institucion_id'])}}?page={{$page}}" method="post">
                    @csrf
                    <td>{{$institution['institucion_id']}}</td>
                    <td><input type="text" class="form-control" name="nombre" value="{{$institution->nombre}}"></td>
                    <td><input type="text" class="form-control" name="categoria_nzqa" value="{{$institution->categoria_nzqa}}"></td>
                    <td>
                        {{$institution['activo']}}
                        <input name="activo" type="hidden" value="{{$institution['activo']}}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success" style="margin-left:38px">Guardar</button>
                    </td>
                    <td>
                        <input name="_method" type="hidden" value="PATCH">
                        <a href="{{action('InstitutionController@index')}}?page={{$page}}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </td>
                </form>
                @else
                    <td>{{$institution['institucion_id']}}</td>
                    <td>{{$institution['nombre']}}</td>
                    <td>{{$institution['categoria_nzqa']}}</td>
                    <td>{{$institution['activo']}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @if (count($institutions) > 0)
    {{ $institutions->links() }} 
    @endif--}}
@endsection