@extends('layouts/main')
@section('pagetitle', 'Cup ' . $thing->name)
@section('content')
<a href="/cups">&laquo; Cups</a>
<br />
<ul>
      <li>Name: {{ $thing->name }}</li>
    </ul>
<h1>Choose a winning entry</h1>

{{ Form::open([
    'route' => ['cup.directResultSetWinner','id'=>$thing->id]
]) }}
{{ Form::select('entry', $entries->pluck('entrant.numbered_name','id')->toArray())}}
{{ Form::submit('Choose', ['class' => 'button btn btn-primary']) }}
{{Form::close()}}


@stop
