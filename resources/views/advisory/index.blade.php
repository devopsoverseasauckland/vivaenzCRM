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
                            data-pc-id="{{ $advisory->asesoria_id }}" data-cli-id="{{ $advisory->cliente }}" >
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

@endsection
@section('postJquery')
    @parent
    $('#dialog').dialog({ 
        autoOpen: false,
        width: 350
    });
    $( "#dialog" ).dialog( "option", "position", { my: "left top", at: "left+40 top+40", of: "#dvMessages" } );

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
        var advisoryId = $(this).data('pc-id');
        var _token = $('input[name="_token"]').val();
        $('#advisoryId').val(advisoryId);

        $('#dialog').dialog('option', 'title', 'Detalle proceso ' + $(this).data('cli-id'));

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

@endsection