@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Gestion Seguimiento
    </h3>

    <div class="form-row m-4">
    
        <div class="col-sm-4">
            <div class="form-inline">
                {{Form::label('statesFl', 'Estado',  ['class' => 'col-sm-2 col-form-label w-50'])}}
                <div class="col-sm-6">
                    {{Form::select('statesFl', $states, '', ['id' => 'statesFl', 'class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Todas activas --' ])}}
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-inline">
                {{Form::label('studentFl', 'Estudiante',  ['class' => 'col-sm-2 col-form-label w-auto'])}}
                <div class="col-sm-10">
                    {{Form::text('studentFl', '', ['class' => 'form-control form-control-sm w-100', 'placeholder' => 'nombre, apellido... ' ])}}
                </div>
            </div>
        </div>
    
    </div>

    @if(count($advisories) > 0)

    <div id="tbAdvisories" class="table-responsive">
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th></th>
                <th>
                    <a id="ordStud" href="#" data-ord-id="Stud" >Estudiante</a>
                    <i id="ordIconStud" class="" aria-hidden="true"></i>
                </th>
                <th>Estado</th>
                <th>
                    <a id="ordTrack" href="#" data-ord-id="Track" >Prox Seguimiento</a>
                    <i id="ordIconTrack" class="fa fa-sort-asc" aria-hidden="true"></i>
                </th>
                <th>Notas</th>
                <th></th>
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
                        <input type="hidden" value="{{ $advisory->estadoCod }}" />
                    </td>
                    <td><a href="/advisory/{{$advisory->asesoria_id}}">{{ $advisory->cliente }}</a></td>
                    <td>{{ $advisory->estado }}</td>
                    <td class="form-inline text-left" >
                        <small>
                            <input type="text" id="proxTrack{{ $advisory->asesoria_id }}" 
                                data-adv-id="{{ $advisory->asesoria_id }}" value="{{ $advisory->realizado_fecha }}" 
                                data-adv-advproc="{{ $advisory->asesoria_proceso_id }}" 
                                data-co-id="{{ $advisory->codigo }}"
                                class="form-control form-control-sm p-0 w-50 text-center" readonly>
                        </small>
                    </td>
                    <td>
                        <a id="advComments{{ $advisory->asesoria_id }}" href="#" class="btn btn-warning btn-sm" 
                            data-adv-id="{{ $advisory->asesoria_id }}" data-cli-name="{{ $advisory->cliente }}" >
                            <i class="fa fa-comment" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a id="advDelete{{ $advisory->asesoria_id }}" href="#" class="btn btn-warning btn-sm" title="Eliminar"
                            data-adv-id="{{ $advisory->asesoria_id }}" data-adv-scode="{{ $advisory->estadoCod }}" >
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                        <a id="advExtend{{ $advisory->asesoria_id }}" href="#" class="btn btn-warning btn-sm" title="Extender"
                            data-adv-id="{{ $advisory->asesoria_id }}" data-adv-scode="{{ $advisory->estadoCod }}" >
                            <i class="fa fa-clone" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
        @endforeach
            </tbody>
        </table>
    </div>
    @if (count($advisories) > 0)
    {{ $advisories->links() }}
    @endif
    <input id="page" name="page" type="hidden" value="1">
    @else
    <p>No existen asesorias</p>
    @endif

    {{ Form::hidden('advisoryId', '', array('id' => 'advisoryId')) }}
    {{ Form::hidden('studentId', '', array('id' => 'studentId')) }}
    {{ Form::hidden('insuranceId', '', array('id' => 'insuranceId')) }}
    {{ Form::hidden('visaId', '', array('id' => 'visaId')) }}
    {{ Form::hidden('order', 'Track', array('id' => 'order')) }}
    {{ Form::hidden('orderBy', 'desc', array('id' => 'orderBy')) }}
    

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

    </div>

    <div id="dialogVA" class="container m-1" title="Detalle Visa" >

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

        <button id="btnUpdateVisa" type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <button id="btnNewVisa" type="submit" class="btn btn-primary mt-3">Nuevo Registro</button>

    </div>

    <div id="dialogSG" class="container m-1" title="Detalle Seguro Medico" >

        <div class="card w-auto">
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <td class="text-center" scope="row" >Inicio</td>
                        <td class="text-center" scope="row" >Vencimiento</td>
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

        <button id="btnUpdateIns" type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <button id="btnNewIns" type="submit" class="btn btn-primary mt-3">Nuevo Registro</button>

    </div>

    <div id="dialogCM" class="container m-1" title="Comentarios de la asesoria" >

        <div class="card w-auto">
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <td colspan="2" >
                            <textarea id="txaComments" rows="4" cols="50">
                            </textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <button id="btnUpdateComment" type="submit" class="btn btn-primary mt-3">Actualizar</button>
        {{-- <button id="btnNewIns" type="submit" class="btn btn-primary mt-3">Nuevo Registro</button> --}}

    </div>

@endsection
@section('postJquery')
    @parent
    $( document ).ready(function() {
        loadDatePickersGrid();
        SetGridIcons();
    });

    function SetGridIcons() {
        $("[id*='advDelete']").each(function( index, value ) {
            var state = $(this).data('adv-scode')
            switch(state)
            {
                case 'RE':
                    break;
                default:
                    $(this).css('visibility', 'hidden');
                    break;
            }
        });

        $("[id*='advExtend']").each(function( index, value ) {
            var state = $(this).data('adv-scode')
            switch(state)
            {
                case 'OK':
                case 'FI':
                case 'DE':
                    break;
                default:
                    $(this).css('visibility', 'hidden');
                    break;
            }
        });
    }

    $('#dialog').dialog({ 
        autoOpen: false,
        width: 350
    });
    $('#dialog').dialog( "option", "position", { my: "left top", at: "left+40 top+40", of: "#dvMessages" } );

    $('#dialogVA').dialog({ 
        autoOpen: false,
        width: 350
    });

    $('#dialogSG').dialog({ 
        autoOpen: false,
        width: 350
    });

    $('#dialogCM').dialog({
        autoOpen: false,
        width: 450
    });

    function loadGrid(stateId, studentId, ord, ordBy, _token, urlAdv, urlAdvPagig)
    {
        $.ajax({
            url: urlAdv,
            method: "GET",
            data: { 
                stateId: stateId,
                student: studentId,
                ord: ord,
                ordBy: ordBy,  
                _token: _token
            },
            success:function(result)
            {
                //$('li').remove('#li' + result);
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
                loadDatePickersGrid();
                SetGridIcons();
            }
        });

        $('.pagination').remove();
        $.ajax({
            url: urlAdvPagig,
            method: "GET",
            data: { 
                stateId: stateId,
                student: studentId,
                ord: ord,
                ordBy: ordBy,                  
                _token: _token
            },
            success:function(result)
            {
                $('#tbAdvisories').after( result );
            }
        });
    }

    $(document).on('change', '#statesFl,#studentFl', function()
    {
        var ord = $('#order').val();
        var ordBy = $('#orderBy').val();
        if (ordBy == 'asc')
            ordBy = 'desc';
        else 
            ordBy = 'asc';

        var stateId = $('select#statesFl option:checked').val();
        var studentId = $('#studentFl').val();
        var _token = $('input[name="_token"]').val();

        var urlAdv = "{{ route('combo.advisories') }}";
        var urlAdvPagig = "{{ route('combo.advisoriesPagination') }}";

        loadGrid(stateId, studentId, ord, ordBy, _token, urlAdv, urlAdvPagig);
    });

    function initializeOrderingBy(ord)
    {
        if (ord != $('#order').val())
        {
            $('#orderBy').val('asc');

            // Set Icon order by
            switch (ord)
            {
                case 'Stud':
                    $('#ordIconStud').addClass('fa fa-sort-asc');
                    $('#ordIconTrack').attr('class', '');
                    break;
                case 'Track':
                    $('#ordIconStud').attr('class', '');
                    $('#ordIconTrack').addClass('fa fa-sort-asc');
                    break;
            }
        } else {
            // Set Icon order by
            switch (ord)
            {
                case 'Stud':
                    $('#ordIconStud').toggleClass('fa fa-sort-asc');
                    $('#ordIconStud').toggleClass('fa fa-sort-desc');
                    break;
                case 'Track':
                    $('#ordIconTrack').toggleClass('fa fa-sort-asc');
                    $('#ordIconTrack').toggleClass('fa fa-sort-desc');
                    break;
            }   
        }
        $('#order').val(ord);
    }

    $(document).on("click", "a[id*='advDelete']", function() {
        if (confirm('Desea realmente ELIMINAR la asesoria y la informacion relacionada?'))
        {
            var advisoryId = $(this).data('adv-id');
            var _token = $('input[name="_token"]').val();

            var ord = $('#order').val();
                    var ordBy = $('#orderBy').val();
                    if (ordBy == 'asc')
                        ordBy = 'desc';
                    else 
                        ordBy = 'asc';

                    var stateId = $('select#statesFl option:checked').val();
                    var studentId = $('#studentFl').val();

            var url = "{{ route('advisory.remove', ":id") }}";
            url = url.replace(':id', advisoryId);
            //alert(url);
            $.ajax({
                url: url,
                method: "POST",
                data: { 
                    id: advisoryId,
                    stateId: stateId,
                    student: studentId,
                    ord: ord,
                    ordBy: ordBy,           
                    _token: _token
                },
                success:function(result)
                {
                    $('#tbbody').empty();
                    $( result ).appendTo('#tbbody');
                    loadDatePickersGrid();
                    SetGridIcons();
                }
            });
        }
    });

    $(document).on("click", "a[id*='advExtend']", function() {
        if (confirm('Desea realmente FINALIZAR la actual asesoria y crear una EXTENSION asociada?'))
        {
            var advisoryId = $(this).data('adv-id');
            var _token = $('input[name="_token"]').val();

            var ord = $('#order').val();
            var ordBy = $('#orderBy').val();
            if (ordBy == 'asc')
                ordBy = 'desc';
            else 
                ordBy = 'asc';

            var stateId = $('select#statesFl option:checked').val();
            var studentId = $('#studentFl').val();

            var url = "{{ route('advisory.extend', ":id") }}";
            url = url.replace(':id', advisoryId);
            //alert(url);
            $.ajax({
                url: url,
                method: "POST",
                data: { 
                    id: advisoryId,
                    stateId: stateId,
                    student: studentId,
                    ord: ord,
                    ordBy: ordBy,
                    _token: _token
                },
                success:function(result)
                {
                    $('#tbbody').empty();
                    $( result ).appendTo('#tbbody');
                    loadDatePickersGrid();
                    SetGridIcons();
                }
            });
        }
    });

    $(document).on("click", "#ordStud,#ordTrack", function()
    {
        var ord = $(this).data('ord-id');
        initializeOrderingBy(ord);

        // Set Next ordering by
        var ordBy = $('#orderBy').val();
        if (ordBy == 'asc')
        {
            $('#orderBy').val('desc');
        }
        else 
        {
            $('#orderBy').val('asc');
        }
        
        var stateId = $('select#statesFl option:checked').val();
        var studentId = $('#studentFl').val();
        var _token = $('input[name="_token"]').val();

        var urlAdv = "{{ route('combo.advisories') }}";
        var urlAdvPagig = "{{ route('combo.advisoriesPagination') }}";

        loadGrid(stateId, studentId, ord, ordBy, _token, urlAdv, urlAdvPagig);
    });

    $(document).on("click", "a[class='page-link']", function()
    {
        var ord = $('#order').val();
        var ordBy = $('#orderBy').val();
        if (ordBy == 'asc')
            ordBy = 'desc';
        else 
            ordBy = 'asc';

        var stateId = $('select#statesFl option:checked').val();
        var studentId = $('#studentFl').val();
        var page = $(this).data('pg-id');
        var _token = $('input[name="_token"]').val();

        var urlAdv = "{{ route('combo.advisories') }}" + "?page=" + page;
        var urlAdvPagig = "{{ route('combo.advisoriesPagination') }}" + "?page=" + page;

        loadGrid(stateId, studentId, ord, ordBy, _token, urlAdv, urlAdvPagig);
    });

    // Get Comments
    $(document).on("click", "a[id*='advComments']", function()
    {
        $('#dialogCM').dialog('close');
        var advisoryId = $(this).data('adv-id');
        var _token = $('input[name="_token"]').val();
        $('#advisoryId').val(advisoryId);

        $('#dialogCM').dialog('option', 'title',  'Comentarios asesoria: ' + $(this).data('cli-name'));

        $.ajax({
            url: "{{ route('studentAdvComment.get') }}",
            method: "GET",
            data: { 
                advId: advisoryId,
                _token: _token
            },
            success:function(result)
            {
                $('#txaComments').val(result);
                $('#dialogCM').dialog('open');
            }
        });

    });

    /*****/
    $(document).on('click', '.btn-warning', function()
    {
        $('#dialog').dialog('close');
        var advisoryId = $(this).data('adv-id');
        var _token = $('input[name="_token"]').val();
        $('#advisoryId').val(advisoryId);
        $('#studentId').val($(this).data('cli-id'))
        $('#insuranceId').val($(this).data('ins-id'));
        $('#visaId').val($(this).data('visa-id'));

        $('#dialog').dialog('option', 'title',  'Proceso: ' + $(this).data('cli-name'));

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

    // Process popup panel date selector to set the step of the advisory
    $(document).on("change", "[id*='procStep']", function()
    {
        var ord = $('#order').val();
        var ordBy = $('#orderBy').val();
        if (ordBy == 'asc')
            ordBy = 'desc';
        else 
            ordBy = 'asc';

        var advProcessId = $(this).data('proc-id');
        var date = $(this).val();
        var advisoryId = $('#advisoryId').val();
        var cod = $(this).data('co-id');
        var stateId = $('select#statesFl option:checked').val();
        var student = $('#studentFl').val();
        var _token = $('input[name="_token"]').val();
        //alert(cod);
        registerDateProcess(advProcessId, date, advisoryId, cod, stateId, student, ord, ordBy, _token);        
    });

    // Grid date selector for track advisory
    $(document).on("change", "[id*='proxTrack']", function()
    {
        var ord = $('#order').val();
        var ordBy = $('#orderBy').val();
        if (ordBy == 'asc')
            ordBy = 'desc';
        else 
            ordBy = 'asc';

        var advProcessId = $(this).data('adv-advproc'); 
        var date = $(this).val();
        var advisoryId = $(this).data('adv-id');
        var cod = $(this).data('co-id'); 
        var stateId = $('select#statesFl option:checked').val();
        var student = $('#studentFl').val();
        var _token = $('input[name="_token"]').val();

        registerDateProcess(advProcessId, date, advisoryId, cod, stateId, student, ord, ordBy, _token);        
    });

    function registerDateProcess(advProcessId, date, advisoryId, cod, stateId, student, ord, ordBy, _token)
    {
        $.ajax({
            url: "{{ route('advisoryProcess.registerDate') }}",
            method: "POST",
            data: { 
                advProcessId: advProcessId,
                date: date,
                advisoryId: advisoryId,
                cod: cod,
                stateId: stateId,
                student: student,
                ord: ord,
                ordBy: ordBy,
                _token: _token
            },
            success:function(result)
            {
                //alert(result);
                $("#statesFl option:selected").prop("selected", false);
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
                loadDatePickersGrid();
                SetGridIcons();
            },
            error:function(jqXHR, exception)
            {
                alert('El proceso no pudo ser actualizado correctamente. Intentelo de nuevo o comuniquese con el administrador del sistema.');
            }
        });
    }
    
    function loadDatePickersGrid() {
        $("[id*='date'],[id*='proxTrack']").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "img/calendar.gif",
            buttonImageOnly: true,
            buttonText: "Select date"
        });
    }

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

    $(document).on('click', '#btnUpdateComment', function()
    {
        var advId = $('#advisoryId').val();
        var comments = $('#txaComments').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('studentAdvComment.update') }}",
            method: "POST",
            data: { 
                advId: advId,
                comm: comments,
                _token: _token
            },
            success:function(result)
            {
                //alert('Actualizado');
                $('#dialogCM').dialog('close');
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