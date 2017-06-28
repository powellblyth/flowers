
@extends('layouts/main')
@section('pagetitle', 'All Cups ')

@section('content')

<div class="form-group" style="text-align:left;padding-left:10%">
@foreach ($cups as $cup)
@php
$maxResults = (($cup->id==13) ? 4: 2);
@endphp

<p>{{ $cup->name }} <a href="{{$cup->getUrl()}}">View</a>

    <br />Winner:<br />
@for ($x=0; $x < min($maxResults,count($results[$cup->id])); $x++)
    @if(1 == $x)
    Proxime Accessit:
    @else
    First place:
    @endif
    <b><a href="{{$winners[$results[$cup->id][$x]->entrant]['entrant']->getUrl()}}">{{$winners[$results[$cup->id][$x]->entrant]['entrant']->getName()}}</a></b>
    ({{$winners[$results[$cup->id][$x]->entrant]['points'] }} points)<br />
@endfor
</p>

@endforeach

</div>
@stop