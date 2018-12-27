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
                <td>{{$institution['institucion_id']}}</td>
                <td>{{$institution['nombre']}}</td>
                <td>{{$institution['categoria_nzqa']}}</td>
                <td>{{$institution['activo']}}</td>
                
                <td>
                    <a href="{{action('InstitutionController@edit', $institution['institucion_id'])}}" class="btn btn-outline-primary btn-sm">
                        Modificar
                    </a>
                </td>
                <td>
                    <form action="{{action('InstitutionController@destroy', $institution['institucion_id'])}}" method="post">
                    @csrf
                        @if( $institution->activo == 1 )
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-outline-danger btn-sm" type="submit">Inactivar</button>
                        @else
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-outline-success btn-sm" type="submit">Activar</button>
                        @endif
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                {{-- <form method="post" action="{{url('passports')}}" enctype="multipart/form-data"> --}}
                {!! Form::open(['action' => 'InstitutionController@store', 'method' => 'POST']) !!}
                    @csrf
                    <td></td>
                    <td>
                        {{Form::text('nombre', '', ['id' => 'nombre', 'class' => 'form-control form-control-sm', 'placeholder' => 'Nombre' ])}}
                    </td>
                    <td>
                        {{Form::text('categoria_nzqa', '', ['class' => 'form-control form-control-sm', 'placeholder' => 'Categoria' ])}}
                    </td>
                    <td><input name="activo" type="hidden" value="1"></td>
                    <td colspan="2">
                        <button type="submit" class="btn btn-outline-success btn-sm">Guardar</button>
                    </td>
                {!! Form::close() !!}
                {{-- </form> --}}
            </tr>
        </tbody>
    </table>
    @if (count($institutions) > 0)
    {{ $institutions->links() }}
    @endif
@endsection
@section('postJquery')
    @parent
    $('#nombre').focus();
@endsection