@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        {{ $advStudent }}
    </h3>
    <nav class="col-md- d-none d-md-block bg-light sidebar shadow pt-2">
        <div class="mx-auto sidebar-sticky">
            
            {!! Form::open(['action' => ['AdvisoryController@updateStep1', $advisory->asesoria_id], 'method' => 'POST']) !!}

            <img class="img-fluid sidebar-sticky"  src="{{ asset('img/FlowStep1.png') }}" > 

            <div class="form-row pt-3 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('firstName', 'Primer Nombre',  ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::text('firstName', $student->primer_nombre, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('secondName', 'Segundo Nombre',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('secondName', $student->segundo_nombre, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('flastName', 'Primer Apellido',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('flastName', $student->primer_apellido, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('slastName', 'Segundo Apellido',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('slastName', $student->segundo_apellido, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('typeDoc', 'Tipo Documento',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('typeDoc', $docTypes, $student->tipo_documento_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('numDoc', 'Numero Documento',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('numDoc', $student->numero_documento, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornDate', 'Fecha Nacimiento',  ['class' => 'w-50'])}}
                        
                        <div class="col-sm-6">

                            <div class="input-group ">
                                {{Form::text('bornDate', $student->fecha_nacimiento, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
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
                            {{Form::select('maritalStatus', $maritalStatus, $student->estado_civil_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornCountry', 'Pais Origen',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('bornCountry', $countries, $student->pais_id, ['id' => 'bornCountry', 
                            'class' => 'form-control form-control-sm w-auto dynamic', 
                            'placeholder' => '-- Seleccione --', 'data-dependent' => 'bornCity' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornCity', 'Ciudad',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">    
                            {{-- {{Form::select('bornCity', $cities, $student->ciudad_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}} --}}
                            <select id="bornCity" name="bornCity" class="form-control form-control-sm w-auto dynamic" >
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
                            {{Form::text('email', $student->correo_electronico, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('whatsapp', 'Whatsapp',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">    
                            {{Form::text('whatsapp', $student->celular_whatsapp, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('engLevel', 'Nivel Ingles',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('engLevel', $englishLev, $student->nivel_ingles_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('profesion', 'Profesion',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('profesion', $professions, $student->profesion_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

            </div>


            <div class="form-row pt-2 pl-3">
            
                <div class="col">
                    <div class="form-inline pt-3">
                       
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('profBack', 'Experiencia Laboral',  ['class' => 'w-50'])}}
                        <div class="col-sm-5">

                            <div class="card-header">
                                <a id="docPlus" href="#" >
                                    <div>
                                        Detalle
                                        <span class="pull-right" >
                                            <i  class="fa fa-plus" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
    
            <hr class="mb-4">

            <div class="form-row pl-3 pb-3">

                {{ Form::hidden('studentId', $student->estudiante_id, array('id' => 'studentId')) }}
                {{ Form::hidden('countryBId', $student->pais_id, array('id' => 'countryBId')) }}
                {{ Form::hidden('cityBId', $student->ciudad_id, array('id' => 'cityBId')) }}
                {{ Form::hidden('advStateCod', $advState, array('id' => 'advStateCod')) }}

                {{ csrf_field() }}
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Actualizar', ['class' => 'btn btn-outline-primary'])}}
                
                <a class="btn btn-outline-success" href="/editStep2/{{$advisory->asesoria_id}}}" role="button">Asesoria</a>

                <a class="btn btn-outline-secondary" href="/advisory" role="button">Seguimientos</a>
                            
            </div>
           

            {!! Form::close() !!}
        </div>
    </nav>

    <!-- Modal -->
    <div id="dialog" title="Experiencia laboral">

        <div id="dvProfDg" class="form-row">
            <div class="form-group col-md-8">
                {{-- <label for="courseType" class="col-form-label col-form-label-sm" >Tipo de curso</label> --}}
                {{-- {{Form::label('profesionExp', 'Profesion',  ['class' => 'w-50'])}} --}}
                {{Form::select('profesionExp', $professions, '', ['id' => 'profesionExp', 'class' => 'form-control w-auto', 'placeholder' => '-- Seleccione --' ])}}
            </div>
            <div class="form-group col-md-3">
                <button id="btnAddExperience" type="submit" class="btn btn-primary">Agregar</button>
            </div>
        </div>

        {{-- <div class="form-group">
            {{Form::label('profesionExp', 'Profesion',  ['class' => 'w-50'])}}
            {{Form::select('profesionExp', $professions, $student->profesion_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
        </div> --}}

        <div class="card w-auto">
            <div class="card-body">
                <ul class="list-group">
                    @if ($experience->count() > 0)
                        @foreach ($experience as $exp)
                            <li class="list-group-item" id="li{{ $exp->profesion_id }}" >{{ $exp->nombre }}
                                <a href="#" class="pull-right">
                                    <i id="docTrash{{ $exp->profesion_id }}" class="fa fa-trash" aria-hidden="true" data-prof-id="{{ $exp->profesion_id }}" ></i>
                                </a>
                            </li>
                        @endforeach
                    @else 
                        <li class="list-group-item">No se ha registrado experiencia</li>
                    @endif
                </ul>
            </div>
        </div>
        
    </div>


@endsection
@section('postJquery')
    @parent
    $('#dialog').dialog({ 
        autoOpen: false,
        width: 350
    });
    $('#docPlus').click(function() {
        $('#dialog').dialog('open');
    });

    $("#bornDate").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0"
    });

    $(document).on('click', '.fa-trash', function()
    {
        var studentId = $('#studentId').val();
        var profesionId = $(this).data('prof-id');
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('studentExperience.deleteExperience') }}",
            method: "POST",
            data: { 
                studentId: studentId,
                profesionId: profesionId,
                _token: _token
            },
            success:function(result)
            {
                //$('li').remove('#li' + result);
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });

    $('#btnAddExperience').click(function() {
        var studentId = $('#studentId').val();
        var profesionId = $('select#profesionExp option:checked').val();
        var _token = $('input[name="_token"]').val();
        
        $.ajax({
            url: "{{ route('studentExperience.registerExperience') }}",
            method: "POST",
            data: { 
                studentId: studentId,
                profesionId: profesionId, 
                _token: _token
            },
            success:function(result)
            {
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });

    $('.dynamic').change(function() {
        var slDependent = $(this).data('dependent');
        LoadCities($(this), slDependent, 0);
    });

    LoadCities($('#countryBId'), 'bornCity', 1);
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

    DisableControls();
    function DisableControls()
    {
        var state = $('#advStateCod').val();
        if(state == 'FI' || state == 'DE')
        {
            $('.form-control-sm').prop( "disabled", true );
            $('.btn-outline-primary').prop( "disabled", true );
            $('#dvProfDg').hide();
        }
    }
@endsection