@extends('layouts.app')

@section('content')
    
    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Nueva Asesoria
    </h3>
    <nav class="col-md- d-none d-md-block bg-light sidebar shadow pt-2">
        <div class="mx-auto sidebar-sticky">
            
            {!! Form::open(['action' => 'AdvisoryController@storeStep1', 'method' => 'POST']) !!}

            <img class="img-fluid sidebar-sticky"  src="{{ asset('img/FlowStep1.png') }}" > 

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
                        <div class="col-sm-3">
                            {{Form::select('bornCountry', $countries, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{Form::label('bornCity', 'Ciudad',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">    
                            {{Form::select('bornCity', $cities, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
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
                        {{Form::label('whatsapp', 'Whatsapp',  ['class' => 'w-50'])}}
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
                        <div class="col-sm-3">
                            {{Form::select('profesion', $professions, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label class="control-label">Input addons</label>
                        <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                          </div>
                        </div>
                      </div> --}}


                      {{-- <div class="form-group">
                            <label class="control-label">Input addons</label>
                            <div class="form-group">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                              </div>
                            </div>
                          </div> --}}


                </div>

            </div>


            {{-- <div class="form-row pt-2 pl-3">
            
                <div class="col">
                    <div class="form-inline pt-3">
                        {{Form::label('profesion', 'Profesion',  ['class' => 'w-50'])}}
                        <div class="col-sm-3">
                            {{Form::select('profesion', $professions, '', ['class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-inline p-1">
                        {{-- {{-- {{Form::label('profBack', 'Experiencia Laboral',  ['class' => 'w-50'])}} 
                        <div class="col-sm-3">
                            {{Form::text('profBack', '', ['class' => 'form-control form-control-sm', 'placeholder' => '' ])}}
                        </div> 
                    </div>
                </div>

            </div> --}}

    
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

                {{Form::submit('Create', ['class' => 'btn btn-outline-success'])}}
                
                <button class="btn btn-outline-secondary" type="button">Cancelar</button>
                            
            </div>
           

            {!! Form::close() !!}
        </div>
    </nav>
@endsection
@section('postJquery')
    @parent
    $("#bornDate").datepicker({
        changeMonth: true,
        changeYear: true
    });
@endsection