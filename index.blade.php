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
                <th>Instituciones</th>
                <th>Estado</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($courseTypes as $courseType)
            <tr>
                <td>{{$courseType['tipo_curso_id']}}</td>
                <td>{{$courseType['descripcion']}}</td>
                <td>
                    <a id="instDetail{{ $courseType['tipo_curso_id'] }}" href="#" class="btn btn-warning btn-sm" data-ct-id="{{ $courseType['tipo_curso_id'] }}" >
                        <i class="fa fa-university"></i>
                    </a>
                </td>
                <td>
                    {{-- {{$courseType['activo']}} --}}
                    <form action="{{action('CourseTypeController@destroy', $courseType['tipo_curso_id'])}}" method="post">
                        @csrf
                        @if( $courseType->activo == 1 )
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-outline-success btn-sm" type="submit">Activo</button>
                        @else
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-outline-danger btn-sm" type="submit">Inactivo</button>
                        @endif
                    </form>
                </td>
                <td>
                    <a href="{{action('CourseTypeController@edit', $courseType['tipo_curso_id'])}}" class="btn btn-outline-primary btn-sm">
                        Modificar
                    </a>
                </td>
                <td>
                    
                </td>
            </tr>
            @endforeach
            <tr>
                {{-- <form method="post" action="{{url('passports')}}" enctype="multipart/form-data"> --}}
                {!! Form::open(['action' => 'CourseTypeController@store', 'method' => 'POST']) !!}
                    @csrf
                    <td></td>
                    <td>
                        {{Form::text('descripcion', '', ['id' => 'descripcion', 'class' => 'form-control form-control-sm', 'placeholder' => 'Descripcion' ])}}
                    </td>
                    <td><input name="activo" type="hidden" value="1"></td>
                    <td></td>
                    <td colspan="2">
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    </td>
                {!! Form::close() !!}
                {{-- </form> --}}
            </tr>
        </tbody>
    </table>
    @if (count($courseTypes) > 0)
    {{ $courseTypes->links() }}
    @endif

    {{-- {{ csrf_field() }} --}}
    {{ Form::hidden('courseTypeId', '', array('id' => 'courseTypeId')) }}

    <!-- Modal -->
    <div id="dialog" class="container" title="Instituciones">

        <div class="form-row">
            <div class="form-group col-md-9">
                {{Form::select('institutions', $institutions, '', ['id' => 'institutions', 'class' => 'form-control form-control-sm', 'placeholder' => '-- Seleccione --' ])}}
            </div>
            <div class="form-group col-md-3">
                <button id="btnAddInstitution" type="submit" class="btn btn-primary btn-sm">+</button>
            </div>
        </div>

        <div class="card w-auto">
            <div class="card-body">
                <ul class="list-group" >
                    
                    <li class="list-group-item">No se han registrado instituciones</li>
                    
                </ul>
            </div>
        </div>

    </div>

@endsection
@section('postJquery')
    @parent
    $('#descripcion').focus();
    $('#dialog').dialog({ 
        autoOpen: false,
        width: 350
    });
    $( "#dialog" ).dialog( "option", "position", { my: "left top", at: "left+40 top+40", of: "#dvMessages" } );

    $('#btnAddInstitution').click(function() {
        var courseTypeId = $('#courseTypeId').val();
        var institutionId = $('select#institutions option:checked').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('coursetype.registerInstitution') }}",
            method: "POST",
            data: { 
                courseTypeId: courseTypeId,
                institutionId: institutionId, 
                _token: _token
            },
            success:function(result)
            {
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });

    $(document).on('click', '.fa-trash', function()
    {
        var courseTypeId = $('#courseTypeId').val();
        var institucionId = $(this).data('inst-id');
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('coursetype.deleteInstitution') }}",
            method: "POST",
            data: { 
                courseTypeId: courseTypeId,
                institucionId: institucionId,
                _token: _token
            },
            success:function(result)
            {
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });

    $(document).on('click', '.btn-warning', function()
    {
        $('#dialog').dialog('close');
        var courseTypeId = $(this).data('ct-id');
        var _token = $('input[name="_token"]').val();
        $('#courseTypeId').val(courseTypeId);
        $.ajax({
            url: "{{ route('combo.courseTypeInstitutions') }}",
            method: "GET",
            data: { 
                val: courseTypeId,
                selIt: 0, 
                _token: _token
            },
            success:function(result)
            {
                $('#dialog').dialog('open');
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });
    
    $(document).on("click", "a[class='page-link']", function()
    {
        var courseTypeId = $('#courseTypeId').val();
        var page = $(this).data('pg-id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('combo.courseTypeInstitutions') }}" + "?page=" + page,
            method: "GET",
            data: { 
                val: courseTypeId,
                selIt: 0, 
                _token: _token
            },
            success:function(result)
            {
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });

@endsection