@extends('layouts/main')
@section('pagetitle', 'Entrant ' . $thing->firstname. ' ' .  $thing->familyname)
@section('content')
    {{$thing->full_name}} was saved!

    <a href="{{route('entrants.show',['entrant'=>$thing])}}">View {{$thing->firstname}}</a>
@stop
