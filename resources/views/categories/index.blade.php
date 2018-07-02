
@extends('layouts/main')
@section('pagetitle', 'All categories ')

@section('content')
@php
$lastSection = 'no';
$publishMode = false;

@endphp
<div class="form-group" style="text-align:left;padding-left:10%">
@foreach ($things as $thing)
@php
$currentSection = $thing->section
@endphp

@if ($lastSection != $currentSection)
    <b>Section {{$thing->section}}</b> 
    @if (!$publishMode)
        - <a class="button" href="/categories/resultsentry?section={{urlencode($thing->section)}}">Enter Results</a>
    @endif
    <br />
@endif
<p>
    {{$thing->number}} {{ $thing->name }} 
    (<b>
        @if (array_key_exists($thing->id, $results) && $results[$thing->id]['total_entries'] > 0)
        {{ $results[$thing->id]['total_entries']}}
        @else
        {{'0'}}
        @endif
        </b> entries)
    @if(array_key_exists($thing->id, $results) && count($results[$thing->id]['placements']) > 0)
        <br /><b><u>Results</u></b>
        @foreach ($results[$thing->id]['placements'] as $result)
            <b>
                @if($result->winningplace == 1)
                    First place
                @elseif ($result->winningplace == 2)
                    Second Place
                @elseif ($result->winningplace == 3)
                    Third Place
                @else
                    {{ucfirst($result->winningplace)}}
                @endif
            </b>
            - 
            @if (!$publishMode)
                {{$winners[$result->entrant]->getName()}}
            @else
                {{substr($winners[$result->entrant]->firstname,0,1)}} {{$winners[$result->entrant]->familyname}}
            @endif

        @endforeach
    @endif
</p>

@php
    $lastSection = $thing->section
@endphp

@endforeach

</div>
<a href="/categories/create" class="button">+ Add a new category</a><br />
@stop