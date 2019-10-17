<div title="Informacion del estudiante">

    <div class="form-group">
        <label for="name" class="col-form-label col-form-label-sm" >Nombre</label>
        <input type="text" class="form-control form-control-sm" id="name" >
    </div>
    <div class="form-group">
        <label for="lastname" class="col-form-label col-form-label-sm" >Apellido</label>
        <input type="text" class="form-control form-control-sm" id="lastname" >
    </div>
    <div class="form-group">
        <label for="email" class="col-form-label col-form-label-sm" >Email</label>
        <input type="email" class="form-control form-control-sm" id="email" >
    </div>
    <div class="form-group">
        <label for="phone" class="col-form-label col-form-label-sm" >Telefono/Whatsapp</label>
        <input type="number" class="form-control form-control-sm" id="phone" >
    </div>
    <div class="form-group">
        <label for="trackDate" class="col-form-label col-form-label-sm" >Fecha seguimiento</label>
        <input type="date" class="form-control form-control-sm" id="trackDate" >
    </div>
    <div class="form-group">
        <label for="observ" class="col-form-label col-form-label-sm" >Observaciones</label>
        <textarea class="form-control" rows="5" cols="25" name="observ" id="observ"></textarea>
    </div>

    <button id="btnAddStudent" type="submit" class="btn btn-primary">Agregar Estudiante</button>

</div>

<div id="dialogCM" class="container m-1" title="Observaciones del estudiante" >

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

@section('postJquery')
@parent

    $('#dialogCM').dialog({
        autoOpen: false,
        width: 450
    });

    $('#btnAddStudent').click(function() {
        var name = $('#name').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var trackdate = $('#trackDate').val();
        var observ = $('#observ').val();
        var _token = $('input[name="_token"]').val();

        if (name == '' || lastname == '' || email == '' || phone == '' || trackDate == '' || observ == '')
        {
            alert('Debe ingresar todos los campos del formulario');
        } else 
        {
            $.ajax({
                url: "{{ route('student.registerPotential') }}",
                method: "POST",
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

                    pagination();
    
                    $('#name').val('');
                    $('#lastname').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#trackDate').val('');
                    $('#observ').val('');
                }
            });
        }
    });

    function pagination()
    {
        var name = $('#name').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var trackdate = $('#trackDate').val();
        var observ = $('#observ').val();
        var _token = $('input[name="_token"]').val();

        $('.pagination').remove();
        $.ajax({
            url: "{{ route('combo.studentPagination') }}",
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