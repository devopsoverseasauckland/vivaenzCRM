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
        <table class="table table-striped table-sm">
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
                        <input type="checkbox" />
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
    @else
    <p>No existen asesorias</p>
    @endif
@endsection
@section('postJquery')
    @parent
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
@endsection