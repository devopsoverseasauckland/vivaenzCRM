@extends('layouts.app')

@section('content')
    
    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        {{ $advStudent }}
    </h3>
    <nav class="col-md- d-none d-md-block bg-light sidebar shadow pt-2">
        <div class="mx-auto sidebar-sticky">
            
            {!! Form::open(['id' => 'step3Form', 'action' => ['AdvisoryController@updateStep3', $advisoryEnroll->asesoria_enrollment_id], 'method' => 'POST']) !!}

            <img class="img-fluid sidebar-sticky"  src="{{ asset('img/FlowStep3.png') }}" > 

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('prog1', 'Programa Elegido 1',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('prog1', $progs, $advisoryEnroll->opcion1_asesoria_informacion_enviada_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="form-inline p-1">
                      
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                   
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('prog2', 'Programa Elegido 2',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('prog2', $progs, $advisoryEnroll->opcion2_asesoria_informacion_enviada_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        
                    </div>
                </div>    

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('prog3', 'Programa Elegido 3',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('prog3', $progs, $advisoryEnroll->opcion3_asesoria_informacion_enviada_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateArrive', 'Fecha Llegada',  ['class' => 'w-50'])}}

                        <div class="col-sm-6">
                            
                            <div class="input-group ">
                                {{Form::text('dateArrive', $advisoryEnroll->fecha_llegada, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateHomestay', 'Fecha Inicio Homestay',  ['class' => 'w-50'])}}
                        
                        <div class="col-sm-6">

                            <div class="input-group ">
                                {{Form::text('dateHomestay', $advisoryEnroll->fecha_inicio_homestay, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateStartClass', 'Fecha Inicio Clases',  ['class' => 'w-50'])}}

                        <div class="col-sm-6">

                            <div class="input-group ">
                                {{Form::text('dateStartClass', $advisoryEnroll->fecha_inicio_clases, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateFinishClass', 'Fecha Fin Clases',  ['class' => 'w-50'])}}

                        <div class="col-sm-6">
                            
                            <div class="input-group ">
                                {{Form::text('dateFinishClass', $advisoryEnroll->fecha_fin_clases, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <hr class="mb-4">

            <div class="form-row pl-3 pb-3">

                <a class="btn btn-outline-secondary" href="/editStep2/{{$advisoryEnroll->asesoria_id}}" role="button">Asesoria</a>

                {{ csrf_field() }}
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Actualizar', ['class' => 'btn btn-outline-primary'])}}
                {{ Form::hidden('advStateCod', $advState, array('id' => 'advStateCod')) }}

                {{Form::submit('Finalizar Inscripcion', [ 'id' => 'finalizar', 'class' => 'btn btn-outline-success', 'onclick' => 'return false;'])}}
                
                <a class="btn btn-outline-secondary" href="/advisory" role="button">Seguimientos</a>
                            
            </div>

            {!! Form::close() !!}
        </div>
    </nav>
@endsection
@section('postJquery')
    @parent
    $("#dateArrive,#dateHomestay,#dateStartClass,#dateFinishClass").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+10"
    });

    $('#finalizar').on("click", function(e) {
        var prog1 = $('select#prog1 option:checked').val();
        if(prog1 == '')
        {
            alert('Debe elegir un programa para seguir con el montaje de la visa');
        } else 
        {   
            $('#step3Form').attr('action', '{{ route('advisory.finishEnrollment', ['id'=>$advisoryEnroll->asesoria_id]) }}').submit();
        }
    });

    DisableControls();
    function DisableControls()
    {
        var state = $('#advStateCod').val();
        if(state == 'FI' || state == 'DE')
        {
            $('.form-control-sm').prop( "disabled", true );
            $('.btn-outline-primary, .btn-outline-success').prop( "disabled", true );
            $('.form-control').prop( "disabled", true );
            //$('.pull-right').hide();
        }
    }
@endsection