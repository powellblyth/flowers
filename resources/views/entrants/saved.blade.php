@extends('layouts/main')
@section('pagetitle', 'Entrant ' . $thing->first_name. ' ' .  $thing->family_name)
@section('content')
    {{$thing->full_name}} was saved!

    <a href="{{route('entrants.show',['entrant'=>$thing])}}">View {{$thing->first_name}}</a>
@stop
