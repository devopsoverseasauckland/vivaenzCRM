@extends('layouts.app')
@section('content')
    <h1>{{ $title }}</h1>
    @if(count($steps) > 0)
        <ul>
            @foreach($steps as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ul>
    @endif
@endsection