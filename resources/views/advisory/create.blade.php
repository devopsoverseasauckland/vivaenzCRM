@extends('layouts.app')

@section('content')
    
    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Nueva Asesoria
    </h3>
    <nav class="col-md- d-none d-md-block bg-light sidebar shadow pt-2">
        <div class="mx-auto sidebar-sticky">
            
            {!! Form::open(['action' => 'AdvisoryController@storeStep1', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            
            <img class="img-fluid sidebar-sticky"  src="{{ asset('img/FlowStep1.png') }}" usemap="#processmap" >

            <map name="processmap">
                <area id="advisoryStep" shape="rect" shape="rect" coords="350,0,560,40" >
                <area id="enrollmentStep" shape="rect" shape="rect" coords="600,0,950,40" >
            </map>

            <div class="form-row pt-3 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('firstName', 'Primer Nombre',  ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::text('firstName', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('secondName', 'Segundo Nombre',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('secondName', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('flastName', 'Primer Apellido',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('flastName', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('slastName', 'Segundo Apellido',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('slastName', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('typeDoc', 'Tipo Documento',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('typeDoc', $docTypes, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('numDoc', 'Numero Documento',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('numDoc', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornDate', 'Fecha Nacimiento',  ['class' => 'w-50'])}}
                        <div class="col-sm-5">
                            
                            <div class="input-group ">
                                {{Form::text('bornDate', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('maritalStatus', 'Estado Civil',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('maritalStatus', $maritalStatus, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornCountry', 'Pais Origen',  ['class' => 'w-50'])}}
                        <a href="#" class="pull-right" >
                            <i id="addCountry" class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        <div class="col-sm-3">
                            {{Form::select('bornCountry', $countries, '', ['id' => 'bornCountry', 'class' => 'form-control form-control-sm w-auto dynamic', 
                            'placeholder' => '-- Seleccione --', 'data-dependent' => 'bornCity' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornCity', 'Ciudad',  ['class' => 'w-50'])}}
                        <a href="#" class="pull-right" >
                            <i id="addCity" class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        <div class="col-sm-3">    
                            {{ Form::hidden('cityBId', '', array('id' => 'cityBId')) }}
                            <select id="bornCity" name="bornCity" class="form-control form-control-sm w-auto" >
                                <option value="" >-- Select --</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
            
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('email', 'Correo Electronico',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">    
                            {{Form::text('email', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('whatsapp', 'Telefono/Whatsapp',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">    
                            {{Form::text('whatsapp', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('engLevel', 'Nivel Ingles',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('engLevel', $englishLev, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('profesion', 'Profesion',  ['class' => 'w-50'])}}
                        <a href="#" class="pull-right" >
                            <i id="addProf" class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        <div class="col-sm-3">
                            {{Form::select('profesion', $professions, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>

                </div>

            </div>
    
            <hr class="mb-4">

            <div class="form-row pl-3 pb-3">

                {{ Form::hidden('redirect', '0', array('id' => 'redirect')) }}

                {{ Form::submit('Create', ['class' => 'btn btn-outline-success']) }}
                
                <a class="btn btn-outline-secondary" href="/advisory" role="button">Cancelar</a>
                            
            </div>
           

            {!! Form::close() !!}
        </div>
    </nav>

    <!-- Modal -->
    <div id="addDialog" title="">

        <div class="form-row">

            <div class="form-group col-md-8">
                <label id="lbItem" for="courseType" class="col-form-label col-form-label-sm" >Nombre</label>
                <input class="form-control form-control-sm" id="descripcion" >
            </div>

        </div>
        <input id="type" name="type" type="hidden" value="">
        <button id="btnAddItem" type="submit" class="btn btn-primary">Agregar</button>

    </div>

@endsection
@section('postJquery')
    @parent
    $("#bornDate").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0"
    });

    $('.dynamic').change(function() {
        var slDependent = $(this).data('dependent');
        LoadCities($(this), slDependent, 0);

        {{-- if ($(this).val() != '')
        {
            var bornCountry = $(this).val();
            var slDependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('combo.cities') }}",
                method: "GET",
                data: { 
                    val: bornCountry, 
                    selIt: 1,
                    _token: _token
                },
                success:function(result)
                {
                    $('#' + slDependent ).empty();
                    $( result ).appendTo( '#' + slDependent );
                }
            })
        } --}}
    });

    LoadCities($('#bornCountry'), 'bornCity', 1);
    function LoadCities(countryCtrl, slDependent, load)
    {
        if (countryCtrl.val() != '')
        {
            var bornCountry = countryCtrl.val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('combo.cities') }}",
                method: "GET",
                data: { 
                    val: bornCountry, 
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
            })
        }
    }

    $('#bornCity').change(function() {
        $('#cityBId').val($(this).val());
    });
    
    $('#addDialog').dialog({ autoOpen: false });
    $( "#addDialog" ).dialog( "option", "position", { my: "left top", at: "left+40 top+40", of: "#dvMessages" } );

    $('#addCountry').click(function() {
        //$('#lbItem').innerHtml('');
        $('#descripcion').val('');
        $('#type').val('CO');
        $('#addDialog').dialog('option', 'title',  'Agregar Pais');
        $('#addDialog').dialog('open');
    });

    $('#addCity').click(function() {
        var country = $('select#bornCountry option:checked').val();
        if (country == "")
        {
            alert("Seleccione el pais al que pertenece la ciudad antes de agregarla");
        } else {
            $('#descripcion').val('');
            $('#type').val('CI');
            $('#addDialog').dialog('option', 'title',  'Agregar Ciudad');
            $('#addDialog').dialog('open');
        }
    });
    
    $('#addProf').click(function() {
        $('#descripcion').val('');
        $('#type').val('PR');
        $('#addDialog').dialog('option', 'title',  'Agregar Profesion');
        $('#addDialog').dialog('open');
    });

    $('#btnAddItem').click(function() {
        var type = $('#type').val();
        var description = $('#descripcion').val();
        var _token = $('input[name="_token"]').val();
        var route = '';
        var inputData = {};
        var slc = '';

        switch(type)
        {
            case 'CO':
                slc = 'bornCountry';
                route = "{{ route('country.store') }}";
                inputData = { 
                        nombre: description,
                        activo: 1,
                        _token: _token
                    };
                break;
            case 'CI':
                slc = 'bornCity';
                countryId = $('select#bornCountry option:checked').val();
                route = "{{ route('city.store') }}";
                inputData = { 
                    nombre: description,
                    countryId: countryId,
                    activo: 1,
                    _token: _token
                };
                break;
            case 'PR':
                slc = 'profesion';
                route = "{{ route('profession.store') }}";
                inputData = { 
                    nombre: description,
                    activo: 1,
                    _token: _token
                };
                break;
            default:
                break;
        }
        
        $.ajax({
            url: route,
            method: "POST",
            data: inputData,
            success:function(result)
            {
                switch(type)
                {
                    case 'CO':
                        route = "{{ route('combo.countries') }}";
                        inputData = { 
                            _token: _token
                        };
                        break;
                    case 'CI':
                        countryId = $('select#bornCountry option:checked').val();
                        route = "{{ route('combo.cities') }}";
                        inputData = { 
                            val: countryId, 
                            selIt: 1,
                            _token: _token
                        };
                        break;
                    case 'PR':
                        route = "{{ route('combo.professions') }}";
                        inputData = { 
                            _token: _token
                        };
                        break;
                    default:
                        break;
                }

                $.ajax({
                    url: route,
                    method: "GET",
                    data: inputData,
                    success: function(result)
                    {
                        $('#' + slc ).empty();
                        $( result ).appendTo( '#' + slc );
                    }
                })
            }
        });

    });

    $('#advisoryStep').click(function() {
        $('#redirect').val('1');
        $link = $('.btn-outline-success');
        $link[0].click();
    });

    $('#enrollmentStep').click(function() {
        alert('Debe diligenciar los datos del estudiante y de la asesoria antes de acceder a la inscripcion ');
    });

@endsection