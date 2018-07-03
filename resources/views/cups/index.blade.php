
@extends('layouts/main')
@section('pagetitle', 'All Cups ')

@section('content')
@php
$publishMode = false;
$showaddress = true;
@endphp
<div class="form-group" style="text-align:left;padding-left:10%">
@foreach ($cups as $cup)
    @php
        if ($cup->id == 13)
        {
            $maxResults = 4;
        }
        else
        {
            $maxResults = 2;
        }
        
        $lastResult = -1;
    @endphp

    <p> 
        @if ( ! $publishMode)
            <a href="{{$cup->getUrl()}}"><b>{{ $cup->name }}</b></a>
        @else
            <b>{{ $cup->name }}</b>
            <br />{{$cup->winning_criteria}}
        @endif

        <br />
        @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
        @php
            $totalPoints = $results[$cup->id]['results'][$x]['totalpoints'];
        @endphp
            <i>
                @if(0 == $x || $lastResult == $totalPoints)
                    Winner:
                @else
                    Proxime Accessit:
                @endif
            </i>
            @php 
            $winningEntrantId = $results[$cup->id]['results'][$x]['entrant'];
            @endphp
            <b>
                @if ( ! $publishMode)
                    <a href="{{$winners[$winningEntrantId]['entrant']->getUrl()}}">
                    {{$winners[$winningEntrantId]['entrant']->getName()}}
                    </a>
                    @if ($showaddress && (0 == $x || $lastResult == $totalPoints))
                        {{$winners[$winningEntrantId]['entrant']->getAddress()}}<br />
                        {{$winners[$winningEntrantId]['entrant']->telephone}}, {{$winners[$winningEntrantId]['entrant']->email}}
                    @endif
                @else
                    {{substr($winners[$winningEntrantId]['entrant']->getPrintableName(),0,1)}}
                @endif
                </b>
                ({{$results[$cup->id]['results'][$x]['totalpoints'] }} points)

                @if ( ! $publishMode)
                    (#{{$winningEntrantId}})
                @endif

            <br />
            @php
            // If we have a matchin point then add one to the iterator
            if ($lastResult == $totalPoints)
            {
                $maxResults++;
            }
            //reset the last result counter
            $lastResult = $totalPoints;
            
            @endphp
        @endfor

        @if ((int)$results[$cup->id]['direct_winner'] > 0)
        <i>Winner:</i>
            @php 
        $directWinnerId = $results[$cup->id]['direct_winner'];
        @endphp
        @if ( ! $publishMode)
            <b>
                <a href="{{$winners[$directWinnerId]['entrant']->getUrl()}}">
                    {{$winners[$directWinnerId]['entrant']->getName()}}
                </a>
                    @if ($showaddress && (0 == $x || $lastResult == $totalPoints))
                        {{$winners[$directWinnerId]['entrant']->getAddress()}}<br />
                        {{$winners[$directWinnerId]['entrant']->telephone}}, {{$winners[$directWinnerId]['entrant']->email}}
                    @endif
            </b>
            @else
                <b>{{$winners[$directWinnerId]['entrant']->getPrintableName()}}</b>
            @endif
            for category {{$results[$cup->id]['winning_category']}}
        @endif        
    </p>
@endforeach
</div>
@stop