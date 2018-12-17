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
                        <div class="col-sm-3">
                            {{Form::text('bornDate', $student->fecha_nacimiento, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
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
                            {{Form::select('bornCountry', $countries, $student->pais_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornCity', 'Ciudad',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">    
                            {{Form::select('bornCity', $cities, $student->ciudad_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row pt-2 pl-3">
            
                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('profesion', 'Profesion',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('profesion', $professions, $student->profesion_id, ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('profBack', 'Experiencia Laboral',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::text('profBack', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
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
                        
                        <div class="col-sm-3">    
                            
                        </div>
                    </div>
                </div>

            </div>
    
            <hr class="mb-4">
<!--
            <div class="form-row pt-2 pl-3">

                <div class="col">
                    <div class="form-inline p-1">

                        <button class="btn btn-outline-success" type="submit">Crear</button>
                        <button class="btn btn-sm btn-outline-secondary" type="button">Cancelar</button>
                        
                    </div>
                </div>

            </div>

            <button class="btn btn-primary btn-lg btn-block" type="submit">Actualizar</button>
-->
            <div class="form-row pl-3 pb-3">

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Actualizar', ['class' => 'btn btn-outline-primary'])}}
                
                <a class="btn btn-outline-success" href="/editStep2/{{$advisory->asesoria_id}}}" role="button">Asesoria</a>

                <a class="btn btn-outline-secondary" href="/advisory" role="button">Seguimientos</a>
                            
            </div>
           

            {!! Form::close() !!}
        </div>
    </nav>
@endsection