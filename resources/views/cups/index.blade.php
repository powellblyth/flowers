@extends('layouts.app', ['activePage' => 'cups', 'titlePage' => __('All Cups')])
@section('pagetitle', 'All Cups ')

@section('content')
    @php
        $publishMode = false;
        $showaddress = $isAdmin;
        $printableNames = !$isAdmin;
        $shortName = false;
    @endphp

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">PHS Summer Flower Show cups</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"><p>These are the cups we award during the annual Flower Show and
                                        the winners (where available).</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-heade card-header-success">{{ $cup->name }}
                            @if ( ! $publishMode)
                                <i class="material-icons">eye</i>
                            @else
                                <b><big>{{ $cup->name }}</big></b>
                            @endif
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    {{$cup->winning_criteria}}
                                </div>
                            </div>
                            @if ((int)$results[$cup->id]['direct_winner'] == 0)

                                @for ($x=0; $x < min($maxResults,count($results[$cup->id]['results'])); $x++)
                                    <div class="row">

                                        @php
                                            $totalPoints = $results[$cup->id]['results'][$x]['totalpoints'];
                                        @endphp
                                        <div class="col-lg-3">
                                            <i>
                                                @if(0 == $x || $lastResult == $totalPoints)
                                                    Winner:
                                                @else
                                                    Proxime Accessit:
                                                @endif
                                            </i>
                                        </div>
                                        <div class="col-lg-3">
                                            ({{$results[$cup->id]['results'][$x]['totalpoints'] }} points)
                                            @php
                                                $winningEntrantId = $results[$cup->id]['results'][$x]['entrant'];
                                            @endphp

                                            @if ( (! $publishMode) && $isAdmin)
                                                <a href="{{$winners[$winningEntrantId]['entrant']->getUrl()}}">{{$winners[$winningEntrantId]['entrant']->getName($printableNames)}}</a>
                                            @else
                                                <big>{{$winners[$winningEntrantId]['entrant']->getName($printableNames)}}</big>
                                            @endif


                                            @if ( ! $publishMode)
                                                (#{{$winningEntrantId}})
                                            @endif

                                            <br/>
                                        </div>
                                        @if ($showaddress && (0 == $x || $lastResult == $totalPoints))
                                            <div class="col-lg-6">
                                                {{$winners[$winningEntrantId]['entrant']->getAddress()}}<br/>
                                                {{$winners[$winningEntrantId]['entrant']->telephone}}
                                                , {{$winners[$winningEntrantId]['entrant']->email}}
                                                {{--                    @else--}}
                                            </div>
                                        @endif
                                    </div>
                                    @php
                                        // If we have a matching point then add one to the iterator
                                        if ($lastResult == $totalPoints)
                                        {
                                            $maxResults++;
                                        }
                                        //reset the last result counter
                                        $lastResult = $totalPoints;

                                    @endphp
                                @endfor
                            @else
                                <i>Winner:</i>
                                @php
                                    $directWinnerId = $results[$cup->id]['direct_winner'];
                                @endphp
                                @if ( ! $publishMode && $isAdmin)
                                    <b>
                                        <a href="{{$winners[$directWinnerId]['entrant']->getUrl()}}">{{$winners[$directWinnerId]['entrant']->getName($printableNames)}}</a>
                                        @if ($showaddress && (0 == $x || $lastResult == $totalPoints))
                                            {{$winners[$directWinnerId]['entrant']->getAddress()}}<br/>
                                            {{$winners[$directWinnerId]['entrant']->telephone}}
                                            , {{$winners[$directWinnerId]['entrant']->email}}
                                        @endif
                                    </b>
                                @else
                                    <big><b>{{$winners[$directWinnerId]['entrant']->getName($printableNames)}}</b></big>
                                @endif
                                @if (is_object($results[$cup->id]['winning_category']))
                                    for category
                                    <i><b>{{$results[$cup->id]['winning_category']->getNumberedLabel()}}</b></i>
                                    @endif
                                 @endif
                                    </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
@stop