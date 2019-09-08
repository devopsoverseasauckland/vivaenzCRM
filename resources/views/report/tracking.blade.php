@extends('layouts.appWide')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Reporte de seguimiento
    </h3>

    <div class="form-row m-2">
                
        <div class="col-sm-3 mt-3">
            <div class="form-inline">
                {{Form::label('statesFl', 'Estado',  ['class' => 'col-sm-4 col-form-label w-50'])}}
                <div class="col-sm-6">
                    {{Form::select('statesFl', $states, '', ['id' => 'statesFl', 'class' => 'form-control form-control-sm w-auto', 'placeholder' => '-- Todas activas --' ])}}
                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-3">
            <div class="form-inline">
                {{Form::label('studentFl', 'Estudiante',  ['class' => 'col-sm-4 col-form-label w-auto'])}}
                <div class="col-sm-7">
                    {{Form::text('studentFl', '', ['class' => 'form-control form-control-sm w-100', 'placeholder' => 'nombre, apellido... ' ])}}
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-inline">
                {{Form::label('noInvoic', 'No facturado', ['class' => 'col-sm-6 col-form-label w-auto'])}}
                <div class="col-sm-1">
                    {{Form::checkbox('noInvoic', '', '', ['id' => 'noInvoic', 'class' => 'form-check-input'])}}
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-inline">
                {{Form::label('proxTrav', 'Proximo a viajar', ['class' => 'col-sm-6 col-form-label w-auto'])}}
                <div class="col-sm-1">
                    {{Form::checkbox('proxTrav', '', '', ['id' => 'proxTrav', 'class' => 'form-check-input'])}}
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-inline">
                {{Form::label('proxSeg', 'Seguimiento cercano', ['class' => 'col-sm-8 col-form-label w-auto'])}}
                <div class="col-sm-1">
                    {{Form::checkbox('proxSeg', '', '', ['id' => 'proxSeg', 'class' => 'form-check-input'])}}
                </div>
            </div>
        </div>

</div>

@if(count($advisories) > 0)

    <div id="tbAdvisories" class="table-responsive">
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th>No.</th>
                <th>Estudiante</th>
                <th>Estado</th>
                <th>Fecha<br/> Asesoria</th>
                <th>Fecha Prox<br/> Seguimiento</th>
                <th>Fecha<br/> Facturacion</th>
                <th>Fecha<br/> Arrivo</th>
                <th>Fecha Venc<br/> Visa</th>
                <th>Fecha Venc<br/> Seguro</th>
                <th>Notas</th>
            </tr>
            </thead>
            <tbody id="tbbody" >
        @foreach($advisories as $advisory)
                <tr>
                    <td>
                        {{ $advisory->asesoria_id }}
                        <input type="hidden" value="{{ $advisory->asesoria_id }}" />
                        <input type="hidden" value="{{ $advisory->estudiante_id }}" />
                    </td>
                    <td><a href="/advisory/{{$advisory->asesoria_id}}">{{ $advisory->cliente }}</a></td>
                    <td>{{ $advisory->estado  }}</td>
                    <td>{{ $advisory->advisory_date }}</td>
                    <td>{{ $advisory->adv_next_tracking }}</td>
                    <td>{{ $advisory->adv_invoice_date }}</td>
                    <td>{{ $advisory->arrival_date }}</td>
                    <td>{{ $advisory->visa_exp_date }}</td>
                    <td>{{ $advisory->insur_exp_date }}</td>
                    <td>
                        <a id="advComments{{ $advisory->asesoria_id }}" href="#" class="btn btn-sm" 
                            data-adv-id="{{ $advisory->asesoria_id }}" data-cli-name="{{ $advisory->cliente }}"  >
                            <i class="fa fa-comment" aria-hidden="true"></i>
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

    $('#dialogCM').dialog({
        autoOpen: false,
        width: 450
    });

    function getValueCheck(obj)
    {
        val = $('#' + obj).prop('checked');
        if (val)
        {
            return '1';
        } else 
        {
            return '0';
        }
    }

    function loadGrid()
    {
        var stateId = $('select#statesFl option:checked').val();
        var student = $('#studentFl').val();
        var _token = $('input[name="_token"]').val();
        invoiced = getValueCheck('noInvoic');
        arrived = getValueCheck('proxTrav');
        upcomingTrack = getValueCheck('proxSeg');
        var page = 1;// $(this).data('pg-id');

        $.ajax({
            url: "{{ route('combo.advisoriesTrackingPaginate') }}",
            method: "GET",
            data: { 
                stateId: stateId,
                student: student,
                invoiced: invoiced, 
                arrived: arrived, 
                upcomingTrack: upcomingTrack,
                _token: _token
            },
            success:function(result)
            {
                //$('li').remove('#li' + result);
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
            }
        });

        $('.pagination').remove();

        $.ajax({
            url: "{{ route('combo.advisoriesTrackingPagination') }}" + "?page=" + page,
            method: "GET",
            data: { 
                stateId: stateId,
                student: student,
                invoiced: invoiced, 
                arrived: arrived, 
                upcomingTrack: upcomingTrack,
                _token: _token,
            },
            success:function(result)
            {
                $('#tbAdvisories').after( result );
                
            }
        });
    }

    $(document).on('change', '#statesFl,#studentFl', function()
    {
        loadGrid();
    });

    $(document).on('click', '.form-check-input', function()
    {
        loadGrid();
    });


    /*****/
    $(document).on("click", "a[class='page-link']", function()
    {
        var stateId = $('select#statesFl option:checked').val();
        var student = $('#studentFl').val();
        var _token = $('input[name="_token"]').val();
        invoiced = getValueCheck('noInvoic');
        arrived = getValueCheck('proxTrav');
        upcomingTrack = getValueCheck('proxSeg');
        var page = $(this).data('pg-id');

        $.ajax({
            url: "{{ route('combo.advisoriesTrackingPaginate') }}" + "?page=" + page,
            method: "GET",
            data: { 
                stateId: stateId,
                student: student,
                invoiced: invoiced, 
                arrived: arrived, 
                upcomingTrack: upcomingTrack,
                _token: _token
            },
            success:function(result)
            {
                //$('li').remove('#li' + result);
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
            }
        });

        $('.pagination').remove();
        $.ajax({
            url: "{{ route('combo.advisoriesTrackingPagination') }}" + "?page=" + page,
            method: "GET",
            data: { 
                stateId: stateId,
                student: student,
                invoiced: invoiced, 
                arrived: arrived, 
                upcomingTrack: upcomingTrack,
                _token: _token,
            },
            success:function(result)
            {
                $('#tbAdvisories').after( result );
                
            }
        });
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


@endsection