@extends('layouts.app')

@section('content')
    <!--<br/>
    <br/>
    <br/>-->
    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Nueva Asesoria
    </h3>
    <nav class="col-md- d-none d-md-block bg-light sidebar shadow pt-2">
        <div class="mx-auto sidebar-sticky">
            
            {!! Form::open(['action' => ['AdvisoryController@updateStep3', $advisoryEnroll->asesoria_enrollment_id], 'method' => 'POST']) !!}

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
                        <div class="col-sm-3">
                            {{Form::text('dateArrive', $advisoryEnroll->fecha_llegada, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateHomestay', 'Fecha Inicio Homestay',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('dateHomestay', $advisoryEnroll->fecha_inicio_homestay, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
                
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateStartClass', 'Fecha Inicio Clases',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('dateStartClass', $advisoryEnroll->fecha_inicio_clases, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('dateFinishClass', 'Fecha Inicio Clases',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('dateFinishClass', $advisoryEnroll->fecha_fin_clases, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <hr class="mb-4">

            <div class="form-row pl-3 pb-3">

                <a class="btn btn-outline-secondary" href="/editStep2/{{$advisoryEnroll->asesoria_id}}" role="button">Asesoria</a>

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Actualizar', ['class' => 'btn btn-outline-primary'])}}

                {{Form::submit('Finalizar', [ 'id' => 'finalizar', 'class' => 'btn btn-outline-success', 'onclick' => 'return false;'])}}
                
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
        changeYear: true
      });
@endsection