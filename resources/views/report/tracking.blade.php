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

    <div class="table-responsive">
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
                    <td></td>
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

@endsection
@section('postJquery')
    @parent

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

        $.ajax({
            url: "{{ route('combo.advisoriesTracking') }}",
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
        {{--$.ajax({
            url: "{{ route('combo.advisoriesTrackingPagination') }}",
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
        }); --}}
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
            url: "{{ route('combo.advisoriesTracking') }}" + "?page=" + page,
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

@endsection