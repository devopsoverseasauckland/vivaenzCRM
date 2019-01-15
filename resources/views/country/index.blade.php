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
                <td>{{$country['pais_id']}}</td>
                <td>{{$country['nombre']}}</td>
                <td>
                    {{-- {{$institution['activo']}} --}}
                    <form action="{{action('CountryController@destroy', $country['pais_id'])}}" method="post">
                        @csrf
                        @if( $country->activo == 1 )
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-outline-success btn-sm" type="submit">Activo</button>
                        @else
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-outline-danger btn-sm" type="submit">Inactivo</button>
                        @endif
                    </form>
                </td>
                <td>
                    <a href="{{action('CountryController@edit', $country['pais_id'])}}?page={{$page}}" class="btn btn-outline-primary btn-sm">
                        Modificar
                    </a>
                </td>
                <td>
                    
                </td>
            </tr>
            @endforeach
            <tr>
                {{-- <form method="post" action="{{url('passports')}}" enctype="multipart/form-data"> --}}
                {!! Form::open(['action' => 'CountryController@store', 'method' => 'POST']) !!}
                    @csrf
                    <td></td>
                    <td>
                        {{Form::text('nombre', '', ['id' => 'nombre', 'class' => 'form-control form-control-sm', 'placeholder' => 'Nombre' ])}}
                    </td>
                    <td><input name="activo" type="hidden" value="1"></td>
                    <td colspan="2">
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    </td>
                {!! Form::close() !!}
                {{-- </form> --}}
            </tr>
        </tbody>
    </table>
    <input id="page" name="page" type="hidden" value="1">
    @if (count($countries) > 0)
    {{ $countries->links() }}
    @endif
@endsection
@section('postJquery')
    @parent
    $('#nombre').focus();

    $(document).on("click", "a[class='page-link']", function()
    {
        //alert($(this).html());
        $("#page").val($(this).html());
    });
@endsection