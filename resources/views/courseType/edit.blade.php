@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Tipos de cursos
    </h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                {{-- <th>Categoria NZQA</th> --}}
                <th>Activo</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($coursetypes as $courseType)
            <tr>
                @if ($courseType->tipo_curso_id == $id)
                <form action="{{action('CourseTypeController@update', $courseType['tipo_curso_id'])}}" method="post">
                    @csrf
                    <td>{{$courseType['tipo_curso_id']}}</td>
                    <td><input type="text" class="form-control" name="descripcion" value="{{$courseType->descripcion}}"></td>
                    {{-- <td><input type="text" class="form-control" name="categoria_nzqa" value="{{$courseType->categoria_nzqa}}"></td> --}}
                    <td>
                        {{$courseType['activo']}}
                        <input name="activo" type="hidden" value="{{$courseType['activo']}}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success" style="margin-left:38px">Guardar</button>
                    </td>
                    <td>
                        <input name="_method" type="hidden" value="PATCH">
                        <a href="{{action('CourseTypeController@index')}}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </td>
                </form>
                @else
                    <td>{{$courseType['tipo_curso_id']}}</td>
                    <td>{{$courseType['descripcion']}}</td>
                    {{-- <td>{{$institution['categoria_nzqa']}}</td> --}}
                    <td>{{$courseType['activo']}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection