@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Ciudades
    </h3>
    
    {!! Form::open(['id' => 'newForm', 'action' => 'CityController@store', 'method' => 'POST']) !!}

    <div class="form-group row mt-4">
        <label for="countryId" class="col-sm-2 col-form-label">Pais</label>
        <div class="col-sm-10">
            {{Form::select('countryId', $countries, $countryId, ['id' => 'countryId', 'class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Activo</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody id="tbbody" >
            <tr id="trNew" >
                
                    @csrf
                    <td>
                        {{-- <input id="countryId" name="countryId" type="hidden" value="0"> --}}
                    </td>
                    <td>
                        {{Form::text('nombre', '', ['id' => 'nombre', 'class' => 'form-control form-control-sm', 'placeholder' => 'Nombre' ])}}
                    </td>
                    <td><input name="activo" type="hidden" value="1"></td>
                    <td colspan="2">
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        {{-- {{Form::submit('Guardar', [ 'id' => 'save', 'class' => 'btn btn-success btn-sm', 'onclick' => 'return false;'])}} --}}
                    </td>
                
            </tr> 
        </tbody>
    </table>
    
    <input id="page" name="page" type="hidden" value="1">
    {!! Form::close() !!}

    {{-- @if (count($cities) > 0)
    {{ $cities->links() }}
    @endif --}}
@endsection
@section('postJquery')
    @parent
    $("#trNew").hide();
    LoadCities($('select#countryId option:checked').val());  
    $(document).on('change', '#countryId', function()
    {
        //$("#countryId").val($('select#countryId option:checked').val());
        LoadCities($('select#countryId option:checked').val());  
    });
    function LoadCities(countryId)
    {
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('combo.cities') }}",
            method: "GET",
            data: { 
                val: countryId,
                selIt: 0, 
                _token: _token
            },
            success:function(result)
            {
                $("[id*='trCity']").remove();
                $(result).insertBefore( "#trNew" );

                if (countryId != '' && countryId != undefined)
                    $("#trNew").show();
            }
        })
    }

    {{-- $('#save').on("click", function(e) {
        console.log('aaaaa');
        alert($('select#countryId option:checked').val());
        $("#countryId").val($('select#countryId option:checked').val());
        $( "#newForm" ).submit();
    }); --}}


    $('#nombre').focus();

    $(document).on("click", "a[class='page-link']", function()
    {
        //alert($(this).html());
        $("#page").val($(this).html());
    });
@endsection