@extends('layouts.app')

@section('content')
    
    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Nueva Asesoria
    </h3>

    <nav class="col-md- d-none d-md-block bg-light sidebar shadow pt-2">
        <div class="mx-auto sidebar-sticky">
            
            {!! Form::open(['id' => 'step2Form', 'action' => ['AdvisoryController@updateStep2', $advisory->asesoria_id], 'method' => 'POST']) !!}

            <img class="img-fluid sidebar-sticky"  src="{{ asset('img/FlowStep2.png') }}" > 

            <div class="row" >

                <div class="col-5 pt-3" >

                    <div class="form-inline p-1">
                        {{Form::label('dateAdvisory', 'Fecha Asesoria',  ['class' => 'w-50'])}}
                        <div class="col-sm-5">
                            {{Form::label('dateAdvisory', $advisory->creacion_fecha, ['class' => 'form-control-plaintext', 'placeholder' => '' ])}}
                        </div>
                    </div>

                    <div class="form-inline p-1">
                        {{Form::label('purpose', 'Intencion',  ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::select('purpose', $purpouses, $advisory->intencion_viaje_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>

                    <div class="form-inline p-1">
                        {{Form::label('dateAproxFlight', 'Fecha Estimada Viaje',  ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::text('dateAproxFlight', $advisory->fecha_estimada_viaje, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>

                    <div class="form-inline p-1">
                        {{Form::label('contactMean', 'Metodo de contacto',  ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::select('contactMean', $contactMeans, $advisory->metodo_contacto_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>

                    <div class="form-inline pl-1 pt-3">
                        {{Form::label('famAdvisory', 'Asesoria familia', ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::checkbox('famAdvisory', $advisory->asesoria_familia, $advisory->asesoria_familia, ['class' => 'form-check-input'])}}
                        </div>                        
                    </div>

                </div>

                <div class="col-6 ml-5 pt-3" >

                    <div class="card w-auto">
                        <div class="card-header">
                            Check list informacion Enviada
                            <a href="#" class="pull-right" >
                                <i id="docPlus" class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @if ($docsSent->count() > 0)
                                    @foreach ($docsSent as $doc)
                                        <li class="list-group-item" id="li{{ $doc->asesoria_informacion_enviada_id }}" >{{ $doc->descripcion }}
                                            <a href="#" class="pull-right">
                                                <i id="docTrash{{ $doc->asesoria_informacion_enviada_id }}" class="fa fa-trash" aria-hidden="true" data-doc-id="{{ $doc->asesoria_informacion_enviada_id }}" ></i>
                                            </a>
                                        </li>
                                    @endforeach
                                @else 
                                    <li class="list-group-item">No se han enviado documentos</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    
                    
                </div>

            </div>

            <hr class="mb-4">

            <div class="form-row pl-3 pb-3">

                <a class="btn btn-outline-secondary" href="/editStep1/{{$advisory->asesoria_id}}" role="button">Estudiante</a>

                {{ Form::hidden('advisoryId', $advisory->asesoria_id, array('id' => 'advisoryId')) }}

                {{ csrf_field() }}
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Actualizar', ['class' => 'btn btn-outline-primary'])}}

                {{Form::submit('Inscripcion', [ 'id' => 'inscripcion', 'class' => 'btn btn-outline-success', 'onclick' => 'return false;'])}}
                
                <a class="btn btn-outline-secondary" href="/advisory" role="button">Seguimientos</a>
                            
            </div>

            {!! Form::close() !!}

        </div>

    </nav>

    <!-- Modal -->
    <div id="dialog" title="Basic dialog">

        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="courseType" class="col-form-label col-form-label-sm" >Tipo de curso</label>
                {{Form::select('courseType', $courseTypes, '', ['id' => 'courseType', 'class' => 'form-control dynamic', 
                    'placeholder' => '-- Seleccione --', 'data-dependent' => 'institution' ])}}
            </div>
            <div class="form-group col-md-3">
                <label for="time" class="col-form-label col-form-label-sm" >Tiempo</label>
                <input type="number" class="form-control" id="time" >
            </div>
        </div>
        <div class="form-group">
            <label for="institution" class="col-form-label col-form-label-sm" >Institucion</label>
            <select id="institution" name="institution" class="form-control dynamic w-100" >
                <option value="" >-- Select --</option>
            </select>
        </div>
        <button id="btnAddDocument" type="submit" class="btn btn-primary">Agregar</button>

    </div>


@endsection

@section('postJquery')
    @parent
    $('#dialog').dialog({ autoOpen: false });
    $('#docPlus').click(function() {
        $('#dialog').dialog('open');
    });

    $(document).on('click', '.fa-trash', function()
    {
        var advisoryId = $('#advisoryId').val();
        var docId = $(this).data('doc-id');
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('advisoryInfoSent.deleteDocument') }}",
            method: "POST",
            data: { 
                advisoryId: advisoryId,
                docId: docId,
                _token: _token
            },
            success:function(result)
            {
                $('li').remove('#li' + result);
            }
        })
    });

    $('#btnAddDocument').click(function() {
        var advisoryId = $('#advisoryId').val();
        var courseTypeId = $('select#courseType option:checked').val();
        var institutionId = $("select#institution option:checked").val();
        var time = $("#time").val();
        var _token = $('input[name="_token"]').val();
        
        $.ajax({
            url: "{{ route('advisoryInfoSent.registerDocument') }}",
            method: "POST",
            data: { 
                advisoryId: advisoryId,
                courseTypeId: courseTypeId, 
                institutionId: institutionId,
                time: time,
                _token: _token
            },
            success:function(result)
            {
                $('.list-group').empty();
                $( result ).appendTo('.list-group');
            }
        })
    });

    $('#inscripcion').on("click", function(e) {
        if($('.fa-trash').length == '0')
        {
            alert('No ha registrado documentos. Debe registrar documentos para avanzar a la inscripcion.');
        } else 
        {            
            window.location.href = "{{ route('advisory.editStep3', ['id'=>$advisory->asesoria_id]) }}";
        }
    });

    $('.dynamic').change(function() {
        if ($(this).val() != '')
        {
            var courseTypeId = $(this).val();
            var slDependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('combo.institutions') }}",
                method: "GET",
                data: { 
                    val: courseTypeId, 
                    _token: _token
                },
                success:function(result)
                {
                    $('#' + slDependent ).empty();
                    $( result ).appendTo( '#' + slDependent );
                }
            })
        }
    });

@endsection