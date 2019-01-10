@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Gestion Seguimiento
    </h3>
    @if(count($advisories) > 0)

    <div class="form-group row mt-4">
        <label for="statesFl" class="col-sm-2 col-form-label">Filtrar por</label>
        <div class="col-sm-10">
            {{Form::select('statesFl', $states, '', ['id' => 'statesFl', 'class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Seleccione --' ])}}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th></th>
                <th>Estudiante</th>
                <th>Estado</th>
                <th>Notas</th>
            </tr>
            </thead>
            <tbody id="tbbody" >
        @foreach($advisories as $advisory)
                <tr>
                    <td>
                        {{-- <input type="checkbox" id="check{{ $advisory->asesoria_id }}"  /> --}}
                        <a id="instDetail{{ $advisory->asesoria_id }}" href="#" class="btn btn-warning btn-sm" 
                            data-adv-id="{{ $advisory->asesoria_id }}" data-cli-name="{{ $advisory->cliente }}" 
                            data-ins-id="{{ $advisory->insurance_id }}" data-visa-id="{{ $advisory->visa_id }}" 
                            data-cli-id="{{ $advisory->estudiante_id }}" >
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <input type="hidden" value="{{ $advisory->asesoria_id }}" />
                        <input type="hidden" value="{{ $advisory->estudiante_id }}" />
                    </td>
                    <td><a href="/advisory/{{$advisory->asesoria_id}}">{{ $advisory->cliente }}</a></td>
                    <td>{{ $advisory->estado  }}</td>
                    <td></td>
                </tr>
        @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No existen asesorias</p>
    @endif

    {{ Form::hidden('advisoryId', '', array('id' => 'advisoryId')) }}
    {{ Form::hidden('studentId', '', array('id' => 'studentId')) }}
    {{ Form::hidden('insuranceId', '', array('id' => 'insuranceId')) }}
    {{ Form::hidden('visaId', '', array('id' => 'visaId')) }}

    <!-- Modal -->
    <div id="dialog" class="container m-1" title="Detalle proceso">

        <div class="card w-auto">
            {{-- <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                            <tr class="text-light bg-primary" >
                                <th class="text-center" scope="row" >Hito</th>
                                <th class="text-center" >Fecha</th>
                            </tr>
                            </thead>
                            <tbody id="tbProcessbody" >
                        
                            </tbody>
                        </table>
                    </div>
            {{-- </div> --}}
        </div>

        {{-- <div class="form-row">
            <div class="form-group col-md-9">
                {{ Form::textarea('observ', '', ['class'=>'form-control', 'rows' => 10, 'cols' => 25]) }}
            </div>
            <div class="form-group col-md-3">
                <button id="btnUpdate" type="submit" class="btn btn-primary btn-sm">+</button>
            </div>
        </div> --}}

    </div>

    <div id="dialogVA" class="container m-1" title="Detalle Visa">

            <div class="card w-auto">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-center" scope="row" >Inicio visa</td>
                            <td class="text-center" scope="row" >Vencimiento visa</td>
                        </tr>
                        <tr>
                            <td >
                                <div class="form-inline text-center mt-3">
                                    <small>
                                        <input type="text" class="form-control form-control-sm p-0 w-50 text-center" id="dateVisaIni" readonly>
                                    </small>
                                </div>
                            </td>
                            <td  >
                                <div class="form-inline text-center mt-3">
                                    <small>
                                        <input type="text" class="form-control form-control-sm p-0 w-50 text-center" id="dateVisaFin" readonly >
                                    </small>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        {{-- <div class="form-row" >
            <div class="form-group col-md-4">
                <label for="courseType" class="col-form-label col-form-label-sm" >Fecha inicio visa</label>
                <div class="input-group ">
                <small>
                    <input type="text" class="form-control" id="dateVisaIni" >
                </small>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="courseType" class="col-form-label col-form-label-sm" >Fecha fin visa</label>
                <small>
                    <input type="text" class="form-control" id="dateVisaFin" >
                </small>
            </div>
        </div> --}}

        <button id="btnUpdateVisa" type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <button id="btnNewVisa" type="submit" class="btn btn-primary mt-3">Nuevo Registro</button>

    </div>

    <div id="dialogSG" class="container m-1" title="Detalle Seguro Medico">

        <div class="card w-auto">
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <td class="text-center" scope="row" >Inicio visa</td>
                        <td class="text-center" scope="row" >Vencimiento visa</td>
                    </tr>
                    <tr>
                        <td >
                            <div class="form-inline text-center mt-1 mb-1">
                                <small>
                                    <input type="text" class="form-control form-control-sm p-0 w-50 text-center" id="dateInsIni" readonly>
                                </small>
                            </div>
                        </td>
                        <td  >
                            <div class="form-inline text-center mt-1 mb-1">
                                <small>
                                    <input type="text" class="form-control form-control-sm p-0 w-50 text-center" id="dateInsFin" readonly >
                                </small>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center" scope="row" colspan="2" >Poliza No</td>
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <input type="text" class="form-control mt-3" id="policy" >
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- <div class="form-row">
            <div class="form-group col-md-4">
                <label for="courseType" class="col-form-label col-form-label-sm" >Fecha Inicio</label>
                <small>
                    <input type="text" class="form-control" id="dateInsIni" >
                </small>
            </div>
            <div class="form-group col-md-4">
                <label for="courseType" class="col-form-label col-form-label-sm" >Fecha Fin</label>
                <small>
                    <input type="text" class="form-control" id="dateInsFin" >
                </small>
            </div>
        </div>
        <div class="form-group">
            <label for="policy" class="col-form-label col-form-label-sm" >Poliza No</label>
            <input type="text" class="form-control" id="policy" >
        </div> --}}

        <button id="btnUpdateIns" type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <button id="btnNewIns" type="submit" class="btn btn-primary mt-3">Nuevo Registro</button>

    </div>

@endsection
@section('postJquery')
    @parent
    $('#dialog').dialog({ 
        autoOpen: false,
        width: 350
    });
    $( "#dialog" ).dialog( "option", "position", { my: "left top", at: "left+40 top+40", of: "#dvMessages" } );

    $('#dialogVA').dialog({ 
        autoOpen: false,
        width: 350
    });

    $('#dialogSG').dialog({ 
        autoOpen: false,
        width: 350
    });

    $(document).on('change', '#statesFl', function()
    {
        var stateId = $('select#statesFl option:checked').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('combo.advisories') }}",
            method: "GET",
            data: { 
                stateId: stateId,
                _token: _token
            },
            success:function(result)
            {
                //$('li').remove('#li' + result);
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
            }
        })
    });

    $(document).on('click', '.btn-warning', function()
    {
        $('#dialog').dialog('close');
        var advisoryId = $(this).data('adv-id');
        var _token = $('input[name="_token"]').val();
        $('#advisoryId').val(advisoryId);
        $('#studentId').val($(this).data('cli-id'))
        $('#insuranceId').val($(this).data('ins-id'));
        $('#visaId').val($(this).data('visa-id'));

        $('#dialog').dialog('option', 'title', $(this).data('cli-name') + ' (Estado Asesoria)');

        $.ajax({
            url: "{{ route('combo.advisoryProcess') }}",
            method: "GET",
            data: { 
                advisoryId: advisoryId,
                _token: _token
            },
            success:function(result)
            {
                $('#tbProcessbody').empty();
                $( result ).appendTo('#tbProcessbody');
                $("[id*='procStep']").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "img/calendar.gif",
                    buttonImageOnly: true,
                    buttonText: "Select date"
                });
                $('#dialog').dialog('open');
                //$("[id*='procStep']").datepicker("hide");
            }
        })
    });

    $(document).on("change", "[id*='procStep']", function()
    {
        var advProcessId = $(this).data('proc-id');
        var date = $(this).val();
        var advisoryId = $('#advisoryId').val();
        var cod = $(this).data('co-id');
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('advisoryProcess.registerDate') }}",
            method: "POST",
            data: { 
                advProcessId: advProcessId,
                date: date,
                advisoryId: advisoryId,
                cod: cod,
                _token: _token
            },
            success:function(result)
            {
                //alert(result);
                $("#statesFl option:selected").prop("selected", false);
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
            }
        });
    });

    $("[id*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        showOn: "button",
        buttonImage: "img/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date"
    });

    $(document).on('click', '#spVA', function()
    {
        var visaId = $('#visaId').val();
        if (visaId == '')
        {
            $('#btnUpdateVisa').toggleClass( 'disabled', true ); 
            $('#btnUpdateVisa').prop('disabled', true);
            $('#btnNewVisa').addClass('btn-primary');
            $('#btnNewVisa').removeClass('btn-outline-danger');
        } else 
        {
            LoadVisaDetails(visaId);
            $('#btnUpdateVisa').toggleClass( 'disabled', false ); 
            $('#btnUpdateVisa').prop('disabled', false);
            
            $('#btnNewVisa').removeClass('btn-primary');
            $('#btnNewVisa').addClass('btn-outline-danger');
        }

        $('#dialogVA').dialog('open');
    });

    function LoadVisaDetails(visaId)
    {
        $.ajax({
            url: "{{ route('studentVisaHist.get') }}",
            method: "GET",
            data: { 
                visaId: visaId
            },
            success:function(result)
            {
                //alert('Actualizado');

                $('#dateVisaIni').val(result.inicio_fecha);
                $('#dateVisaFin').val(result.fin_fecha);
            }
        });
    }

    $(document).on('click', '#btnUpdateVisa', function()
    {
        var advId = $('#advisoryId').val();
        var visaId = $('#visaId').val();
        var dateIni = $('#dateVisaIni').val();
        var dateFin = $('#dateVisaFin').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('studentVisaHist.update') }}",
            method: "POST",
            data: {
                advId: advId, 
                visaId: visaId,
                dateIni: dateIni,
                dateFin: dateFin,
                _token: _token
            },
            success:function(result)
            {
                //alert('Actualizado');
            }
        });
    });

    $(document).on('click', '#btnNewVisa', function()
    {
        var visaId = $('#visaId').val();
        var advId = $('#advisoryId').val();
        var studId = $('#studentId').val();
        var dateIni = $('#dateVisaIni').val();
        var dateFin = $('#dateVisaFin').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('studentVisaHist.register') }}",
            method: "POST",
            data: { 
                advId: advId,
                studId: studId,
                visaId: visaId,
                dateIni: dateIni,
                dateFin: dateFin,
                _token: _token
            },
            success:function(result)
            {
                //alert('Actualizado');
                if (result.estudiante_visa_historial_id > 0)
                {
                    $('#visaId').val(result.estudiante_visa_historial_id);
                    $('#btnUpdateVisa').toggleClass( 'disabled', false ); 
                    $('#btnUpdateVisa').prop('disabled', false);

                    $('#btnNewVisa').toggleClass('btn-outline-danger');
                }
            }
        });
    });

    $(document).on('click', '#spSG', function()
    {
        var insId = $('#insuranceId').val();
        if (insId == '')
        {
            $('#btnUpdateIns').toggleClass( 'disabled', true ); 
            $('#btnUpdateIns').prop('disabled', true);
            $('#btnNewIns').addClass('btn-primary');
            $('#btnNewIns').removeClass('btn-outline-danger');
        } else 
        {
            LoadInsDetails(insId);
            $('#btnUpdateIns').toggleClass( 'disabled', false ); 
            $('#btnUpdateIns').prop('disabled', false);
            
            $('#btnNewIns').removeClass('btn-primary');
            $('#btnNewIns').addClass('btn-outline-danger');
        }

        $('#dialogSG').dialog('open');
    });

    function LoadInsDetails(insId)
    {
        $.ajax({
            url: "{{ route('studentInsuranceHist.get') }}",
            method: "GET",
            data: { 
                insId: insId
            },
            success:function(result)
            {
                //alert('Actualizado');

                $('#dateInsIni').val(result.inicio_fecha);
                $('#dateInsFin').val(result.fin_fecha);
                $('#policy').val(result.numero_poliza);
            }
        });
    }

    $(document).on('click', '#btnUpdateIns', function()
    {
        var advId = $('#advisoryId').val();
        var insId = $('#insuranceId').val();
        var dateIni = $('#dateInsIni').val();
        var dateFin = $('#dateInsFin').val();
        var policy = $('#policy').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('studentInsuranceHist.update') }}",
            method: "POST",
            data: { 
                advId: advId,
                insId: insId,
                dateIni: dateIni,
                dateFin: dateFin,
                policy: policy,
                _token: _token
            },
            success:function(result)
            {
                //alert('Actualizado');
            }
        });
    });

    $(document).on('click', '#btnNewIns', function()
    {
        var advId = $('#advisoryId').val();
        var studId = $('#studentId').val();
        var insId = $('#insuranceId').val();
        var dateIni = $('#dateInsIni').val();
        var dateFin = $('#dateInsFin').val();
        var policy = $('#policy').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('studentInsuranceHist.register') }}",
            method: "POST",
            data: { 
                advId: advId,
                studId: studId,
                insId: insId,
                dateIni: dateIni,
                dateFin: dateFin,
                policy: policy,
                _token: _token
            },
            success:function(result)
            {
                //alert('Actualizado');

                if (result.estudiante_seguro_historial_id > 0)
                {
                    $('#insuranceId').val(result.estudiante_seguro_historial_id);
                    $('#btnUpdateIns').toggleClass( 'disabled', false ); 
                    $('#btnUpdateIns').prop('disabled', false);

                    $('#btnNewIns').toggleClass('btn-outline-danger');
                }
            }
        });
    });

@endsection