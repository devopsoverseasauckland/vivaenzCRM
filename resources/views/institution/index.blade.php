@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Instituciones
    </h3>

    {!! Form::open(['id' => 'newForm', 'action' => 'InstitutionController@store', 'method' => 'POST']) !!}

    <div class="form-row m-4">
                
        <div class="col">
            <div class="form-inline">
                {{Form::label('countryId', 'Pais',  ['class' => 'col-sm-2 col-form-label w-50'])}}
                <div class="col-sm-10">
                    {{Form::select('countryId', $countries, $countryId, ['id' => 'countryId', 
                    'class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --',
                    'data-dependent' => 'cityId' ])}}
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-inline">
                {{Form::label('cityId', 'Ciudad',  ['class' => 'col-sm-2 col-form-label w-auto'])}}
                <div class="col-sm-3">
                    {{Form::select('cityId', $cities, $cityId, ['id' => 'cityId', 
                    'class' => 'form-control form-control-sm w-auto', 
                    'placeholder' => '-- Seleccione --' ])}}
                    {{ Form::hidden('cityBId', '', array('id' => 'cityBId')) }}
                </div>
            </div>
        </div>

    </div>

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
        <tbody id="tbbody" >
            <tr id="trNew" >
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
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    </td>
            </tr>
        </tbody>
    </table>

    <input id="page" name="page" type="hidden" value="1">
    {!! Form::close() !!}

    {{-- @if (count($institutions) > 0)
    {{ $institutions->links() }}
    @endif --}}
@endsection
@section('postJquery')
    @parent
    $("#trNew").hide();
    //LoadCities($('select#countryId option:checked').val(), $('countryId').data('dependent'), 1);
    LoadInstitutions($('select#cityId').val());

    $(document).on('change', '#countryId', function()
    {
        $("#trNew").hide();
        var slDependent = $(this).data('dependent');
        LoadCities($('select#countryId option:checked').val(), slDependent, 0);
    });

    function LoadCities(countryId, slDependent, load)
    {
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('combo.cities') }}",
            method: "GET",
            data: { 
                val: countryId,
                selIt: 1, 
                _token: _token
            },
            success:function(result)
            {
                $('#' + slDependent ).empty();
                $( result ).appendTo( '#' + slDependent );

                if (load == 1)
                {
                    var cityId = $('#cityBId').val();
                    $('#' + slDependent + ' option[value="' + cityId + '"]').prop('selected', true);
                }
            }
        });
    }

    $(document).on('change', '#cityId', function()
    {
        LoadInstitutions($('select#cityId option:checked').val());
    });

    function LoadInstitutions(cityId)
    {
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('combo.institutions') }}",
            method: "GET",
            data: { 
                val: cityId,
                selIt: 0, 
                _token: _token
            },
            success:function(result)
            {
                $("[id*='trInstitution']").remove();
                $(result).insertBefore( "#trNew" );

                if (cityId != '' && cityId != undefined)
                {
                    $("#trNew").show();
                    $('#nombre').focus();
                }
            }
        });

        $('.pagination').remove();
        $.ajax({
            url: "{{ route('combo.institutionsPagination') }}",
            method: "GET",
            data: { 
                val: cityId,                
                _token: _token
            },
            success:function(result)
            {
                $('#newForm').after( result );
            }
        });
    }

    $(document).on("click", "a[class='page-link']", function()
    {
        var cityId = $('select#cityId option:checked').val();
        var page = $(this).data('pg-id');
        var _token = $('input[name="_token"]').val();
        
        $.ajax({
            url: "{{ route('combo.institutions') }}" + "?page=" + page,
            method: "GET",
            data: { 
                val: cityId,
                selIt: 0, 
                _token: _token
            },
            success:function(result)
            {
                $("[id*='trInstitution']").remove();
                $(result).insertBefore( "#trNew" );

                if (cityId != '' && cityId != undefined)
                {
                    $("#trNew").show();
                    $('#nombre').focus();
                }
            }
        });

        $('.pagination').remove();
        $.ajax({
            url: "{{ route('combo.institutionsPagination') }}" + "?page=" + page,
            method: "GET",
            data: { 
                val: cityId,                
                _token: _token
            },
            success:function(result)
            {
                $('#newForm').after( result );
            }
        });
    });

    $('#nombre').focus();
@endsection