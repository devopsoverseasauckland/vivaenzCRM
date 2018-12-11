@extends('layouts.app')

@section('content')

    <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted" >
        Gestion Seguimiento
    </h3>
    @if(count($advisories) > 0)
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
            <tbody>
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