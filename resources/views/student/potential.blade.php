@extends('layouts.appRight')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Estudiantes potenciales
    </h3>

    @if(count($students) > 0)

    <div id="tbStudents" class="table-responsive">
        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th>
                    Estudiante
                    {{-- <a id="ordStud" href="#" data-ord-id="Stud" >Estudiante</a>
                    <i id="ordIconStud" class="" aria-hidden="true"></i> --}}
                </th>
                <th>
                    Prox Seguimiento
                    {{-- <a id="ordTrack" href="#" data-ord-id="Track" >Prox Seguimiento</a>
                    <i id="ordIconTrack" class="fa fa-sort-asc" aria-hidden="true"></i> --}}
                </th>
                <th>Notas</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="tbbody" >
        @foreach($students as $student)
                <tr>
                    <td>
                        <a href="/student/{{$student->estudiante_id}}" data-adv-id="{{ $student->asesoria_id }}" 
                            data-cli-id="{{ $student->estudiante_id }}">
                            {{ $student->cliente }}
                        </a>
                        <input type="hidden" value="{{ $student->asesoria_id }}" />
                        <input type="hidden" value="{{ $student->estudiante_id }}" />
                    </td>
                    <td class="form-inline text-left" >
                        <small>
                            <input type="text" id="proxTrack{{ $student->estudiante_id }}" 
                                value="{{ $student->poten_seguimiento_fecha }}" data-stud-id="{{ $student->estudiante_id }}"
                                class="form-control form-control-sm p-0 w-50 text-center" readonly>
                        </small>
                    </td>
                    <td>
                        <a id="stdpComments{{ $student->estudiante_id }}" href="#" class="btn btn-warning btn-sm" 
                            data-cli-name="{{ $student->cliente }}" data-stud-id="{{ $student->estudiante_id }}" >
                            <i class="fa fa-comment" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a id="stdpDelete{{ $student->estudiante_id }}" href="#" class="btn btn-warning btn-sm" title="Eliminar"
                            data-stud-id="{{ $student->estudiante_id }}" >
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                        <a id="advCreate{{ $student->estudiante_id }}" href="#" class="btn btn-warning btn-sm" title="Crear Asesoria" 
                            data-stud-id="{{ $student->estudiante_id }}" data-cli-name="{{ $student->cliente }}" >
                            <i class="fa fa-external-link-square" aria-hidden="true"></i>
                        </a> 
                    </td>
                </tr>
        @endforeach
            </tbody>
        </table>
    </div>
    @if (count($students) > 0)
    {{ $students->links() }}
    @endif
    <input id="page" name="page" type="hidden" value="1">
    @else
    <p>No existen estudiantes</p>
    @endif

    <input id="studId" name="studId" type="hidden" value="" />

@endsection
@section('postJquery')
    @parent

    $( document ).ready(function() {
        loadDatePickersGrid();
    });

    // Get Comments
    $(document).on("click", "a[id*='stdpComments']", function()
    {
        $('#dialogCM').dialog('close');
        var stdpId = $(this).data('stud-id');
        var _token = $('input[name="_token"]').val();
        $('#studId').val(stdpId);

        $('#dialogCM').dialog('option', 'title',  'Comentarios asesoria: ' + $(this).data('cli-name'));

        $.ajax({
            url: "{{ route('student.getComment') }}",
            method: "GET",
            data: { 
                stdpId: stdpId,
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
        var stdpId = $('#studId').val();
        var comments = $('#txaComments').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('student.updateComment') }}",
            method: "POST",
            data: { 
                stdpId: stdpId,
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

    $(document).on("click", "a[id*='stdpDelete']", function() {
        if (confirm('Desea realmente ELIMINAR el estudiante?'))
        {
            var studId = $(this).data('stud-id');
            var _token = $('input[name="_token"]').val();

            var url = "{{ route('student.deletePotential', ":id") }}";
            url = url.replace(':id', studId);
            //alert(url);
            $.ajax({
                url: url,
                method: "POST",
                data: { 
                    id: studId,   
                    _token: _token
                },
                success:function(result)
                {
                    $('#tbbody').empty();
                    $( result ).appendTo('#tbbody');
                    loadDatePickersGrid();
                    pagination();
                }
            });
        }
    });

    
    $(document).on("click", "a[id*='advCreate']", function() {
        var estudName = $(this).data('cli-name');
        if (confirm('Esta a punto de crear una asesoria para el estudiante: ' + estudName))
        {
            var studId = $(this).data('stud-id');
            var _token = $('input[name="_token"]').val();

            var url = "{{ route('student.createAdvisory') }}";
            
            $.ajax({
                url: url,
                method: "POST",
                data: { 
                    stdpId: studId,
                    _token: _token
                },
                success:function(result)
                {
                    $('#tbbody').empty();
                    $( result ).appendTo('#tbbody');
                    loadDatePickersGrid();
                }
            });
        }
    });

    function loadDatePickersGrid() {
        $("[id*='date'],[id*='proxTrack']").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "../img/calendar.gif",
            buttonImageOnly: true,
            buttonText: "Select date"
        });
    }

    // Grid date selector for track advisory
    $(document).on("change", "[id*='proxTrack']", function()
    {
        var studId = $(this).data('stud-id'); 
        var date = $(this).val();
        var _token = $('input[name="_token"]').val();

        registerDateProcess(studId, date, _token);   
    });

    function registerDateProcess(studId, date, _token)
    {
        $.ajax({
            url: "{{ route('student.registerDateTrack') }}",
            method: "POST",
            data: { 
                studId: studId,
                date: date,
                _token: _token
            },
            success:function(result)
            {
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
                loadDatePickersGrid();
            },
            error:function(jqXHR, exception)
            {
                alert('El estudiante no pudo ser actualizado correctamente. Intentelo de nuevo o comuniquese con el administrador del sistema.');
            }
        });
    }

    $(document).on("click", "a[class='page-link']", function()
    {
        var stateId = $('select#statesFl option:checked').val();
        var studentId = $('#studentFl').val();
        var page = $(this).data('pg-id');
        var _token = $('input[name="_token"]').val();

        var urlAdv = "{{ route('combo.students') }}" + "?page=" + page;
        var urlAdvPagig = "{{ route('combo.studentPagination') }}" + "?page=" + page;

        loadGrid(urlAdv, urlAdvPagig);
    });

    function loadGrid(urlAdv, urlAdvPagig)
    {
        var name = $('#name').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var trackdate = $('#trackDate').val();
        var observ = $('#observ').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: urlAdv,
            method: "GET",
            data: { 
                name: name,
                lastname: lastname,
                email: email,
                phone: phone,
                trackdate: trackdate,
                observ: observ,              
                _token: _token
            },
            success:function(result)
            {
                $('#tbbody').empty();
                $( result ).appendTo('#tbbody');
                loadDatePickersGrid();
            }
        });

        $('.pagination').remove();
        $.ajax({
            url: urlAdvPagig,
            method: "GET",
            data: { 
                name: name,
                lastname: lastname,
                email: email,
                phone: phone,
                trackdate: trackdate,
                observ: observ,              
                _token: _token
            },
            success:function(result)
            {
                $('#tbStudents').after( result );
            }
        });
    } 

@endsection