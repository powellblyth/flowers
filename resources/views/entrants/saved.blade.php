@extends('layouts/main')
@section('pagetitle', 'Entrant ' . $thing->firstname. ' ' .  $thing->familyname)
@section('content')
{{$thing->firstname}} {{$thing->lastname}} was saved!

<a href="{{$thing->getUrl()}}">View {{$thing->firstname}}</a>
@stop