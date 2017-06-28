
@extends('layouts/main')
@section('pagetitle', 'All categories ')

@section('content')
@php
$lastSection = 'no'
@endphp
<a href="/categories/create">+ Add a new one</a><br />
<div class="form-group" style="text-align:left;padding-left:10%">
@foreach ($things as $thing)
@php
$currentSection = $thing->section
@endphp

@if ($lastSection != $currentSection)
    <b>{{$thing->section}}</b> - <a href="/categories/resultsentry?section={{urlencode($thing->section)}}">Enter Results</a><Br />
@endif
<p>{{$thing->number}} {{ $thing->name }}
    @if(count($results[$thing->id]) > 0)
    <br /><b><u>Results</u></b>
@foreach ($results[$thing->id] as $result)
<b>@if($result->winningplace == 1)
First place
@elseif ($result->winningplace == 2)
Second Place
@elseif ($result->winningplace == 3)
Third Place
@else
{{$result->winningplace}}
@endif
</b>
- 
{{$winners[$result->entrant]->firstname}} {{$winners[$result->entrant]->familyname}}
@endforeach
@endif
</p>

@php
$lastSection = $thing->section
@endphp

@endforeach

</div>
@stop