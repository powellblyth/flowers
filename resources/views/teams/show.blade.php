@extends('layouts/main')
@section('pagetitle', 'Team ' . $team->name)
@section('content')
    @can('viewAny', \App\Team::class)
        <a href="{{route('teams.index')}}">Teams</a>
        <br/>
    @endcan
    <ul>
        <li>Number: {{ $team->name }}</li>
        @if(!is_null($team->min_age))
            <li>Minimum Age: {{ $team->min_age }}</li>
        @endif

        @if(!is_null($team->max_age))
            <li>Maximum Age: {{ $team->max_age }}</li>
        @endif
    </ul>
@stop