
@extends('layouts/main')
@section('pagetitle', 'All Cups ')

@section('content')

<div class="form-group" style="text-align:left;padding-left:10%">
@foreach ($cups as $cup)
@php
$maxResults = (($cup->id==13) ? 4: 2);
@endphp

<p> <a href="{{$cup->getUrl()}}"><b>{{ $cup->name }}</b></a>

    <br />
@for ($x=0; $x < min($maxResults,count($results[$cup->id])); $x++)
<i>@if(0 == $x)
    First place:
    @else
    Proxime Accessit:
    @endif
</i>
    <b><a href="{{$winners[$results[$cup->id][$x]->entrant]['entrant']->getUrl()}}">{{$winners[$results[$cup->id][$x]->entrant]['entrant']->getName()}}</a></b>
    ({{$winners[$results[$cup->id][$x]->entrant]['points'] }} points)<br />
@endfor
</p>

@endforeach

</div>
@stop