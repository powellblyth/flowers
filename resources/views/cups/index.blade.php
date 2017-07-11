
@extends('layouts/main')
@section('pagetitle', 'All Cups ')

@section('content')
@php
$showLinks = false;
@endphp
<div class="form-group" style="text-align:left;padding-left:10%">
@foreach ($cups as $cup)
@php
if ($cup->id == 13)
{
    $maxResults = 4;
}
elseif ($cup->id == 5)
{
    $maxResults = 4;
}
else
{
    $maxResults = (($cup->id==13) ? 4: 2);
}
//var_dump($results);die();
@endphp

<p> 
    @if ($showLinks)
        <a href="{{$cup->getUrl()}}">
    @endif
        <b>{{ $cup->name }}</b>
    @if ($showLinks)
    </a>
    @endif

    <br />
@for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
<i>@if(0 == $x)
    Winner:
    @else
    Proxime Accessit:
    @endif
</i>@php 
$winningEntrantId = $results[$cup->id]['results'][$x]['entrant'];
@endphp
    <b>
        @if ($showLinks)
            <a href="{{$winners[$winningEntrantId]['entrant']->getUrl()}}">
        @endif
            {{$winners[$winningEntrantId]['entrant']->getName()}}
        @if ($showLinks)
            </a>
        @endif
        </b>
    ({{$results[$cup->id]['results'][$x]['totalpoints'] }} points)
        @if ($showLinks)
    (#{{$winningEntrantId}})
    @endif
    <br />
@endfor
</p>
@if ((int)$results[$cup->id]['direct_winner'] > 0)
<i>Winner:</i> <b>
    @php 
$directWinnerId = $results[$cup->id]['direct_winner'];
@endphp
    @if ($showLinks)
    <a href="{{$winners[$directWinnerId]['entrant']->getUrl()}}">
    @endif
        {{$winners[$directWinnerId]['entrant']->getName()}}
    @if ($showLinks)
    </a>
    @endif
</b> for category {{$results[$cup->id]['winning_category']}}
@endif

@endforeach
</div>
@stop