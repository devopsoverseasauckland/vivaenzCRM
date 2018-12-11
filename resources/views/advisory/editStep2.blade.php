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
            
            {!! Form::open(['action' => ['AdvisoryController@updateStep2', $advisory->asesoria_id], 'method' => 'POST']) !!}

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
                            {{Form::text('purpose', $advisory->intencion_viaje_id, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
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
                            {{Form::text('contactMean', $advisory->metodo_contacto_id, ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div>
                    </div>
                    <div class="form-inline pl-1 pt-3">
                        {{Form::label('famAdvisory', 'Asesoria familia', ['class' => 'w-50'])}}
                        <div class="col-sm-1">
                            {{Form::checkbox('famAdvisory', $advisory->asesoria_familia, $advisory->asesoria_familia, ['class' => 'form-check-input'])}}
                        </div>                        
                    </div>
                    
                    <!--<div class="form-inline p-1">
                        {Form::label('famAdvisory', 'Asesoria familia',  ['class' => 'w-50'])}
                    </div>-->

                </div>

                <div class="col-6 ml-3 pt-3" >

                    <div class="jumbotron pt-2 pb-0 mb-0">

                        <div class="form-row p-0 m-0">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="col-form-label col-form-label-sm" >Tipo de curso</label>
                                <input type="email" class="form-control form-control-sm" id="inputEmail4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4" class="col-form-label col-form-label-sm" >Tiempo</label>
                                <input type="password" class="form-control form-control-sm" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-row  p-0 m-0">
                            <div class="form-group col-md-6">
                                <label for="inputEmail5" class="col-form-label col-form-label-sm" >Institucion</label>
                                <input type="email" class="form-control form-control-sm" id="inputEmail4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-3 pt-2 pl-2">
                                <label for="inputEmail6" class="col-form-label col-form-label-sm" ></label>
                                <button type="submit" class="btn btn-primary btn-sm btn-block">Agregar</button>
                            </div>
                        </div>

                        <ul class="list-group">
                                <li class="list-group-item active">Cras justo odio</li>
                                <li class="list-group-item">Dapibus ac facilisis in</li>
                                <li class="list-group-item">Morbi leo risus</li>
                                <li class="list-group-item">Porta ac consectetur ac</li>
                                <li class="list-group-item">Vestibulum at eros</li>
                              </ul>

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

                <a class="btn btn-outline-secondary" href="/editStep1/{{$advisory->asesoria_id}}" role="button">Volver</a>

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Actualizar', ['class' => 'btn btn-outline-primary'])}}

                {{Form::submit('Inscripcion', ['class' => 'btn btn-outline-success'])}}
                
                <a class="btn btn-outline-secondary" href="/advisory" role="button">Cerrar</a>
                            
            </div>

            {!! Form::close() !!}
        </div>
    </nav>
@endsection