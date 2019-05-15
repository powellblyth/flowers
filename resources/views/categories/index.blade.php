@extends('layouts.app', ['activePage' => 'addentrant', 'titlePage' => __('Show Categories')])
@section('pagetitle', 'All categories ')

@section('content')
    @php
        $lastSection = 'no';
        $publishMode = false;
        $printableNames = !$isAdmin;


    @endphp
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">Enter the Entrant's details</div>
                        <div class="card-body">
                            <p>Use this page to see yourself and your family. Click 'Add an
                                        Entrant' on the menu to add yourselves.</p>
                        </div>

            @foreach ($things as $thing)
                @php
                    $currentSection = $thing->section
                @endphp
                @if ($lastSection != $currentSection)
                        </div>
                </div>
                </div>
            </div>
            <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-success">
                                    Section {{$thing->section}}
                                </div>

                                <div class="card-body">
                                    @if (!$publishMode && $isAdmin)
                                        <a class="button btn btn-success"
                                             href="/categories/resultsentry?section={{urlencode($thing->section)}}">Enter
                                            Results</a>
                                    @endif

                @endif
                                <div class="row"><div class="col-lg-6">
                <p>{{$thing->number}}. {{ $thing->name }}
                (<b>
                    @if (array_key_exists($thing->id, $results) && $results[$thing->id]['total_entries'] > 0)
                        {{ $results[$thing->id]['total_entries']}}
                    @else
                        {{'0'}}
                    @endif
                </b> entries)
                </p>
                                    </div>
                                    <div class="col-lg-6">
                @if(array_key_exists($thing->id, $results) && count($results[$thing->id]['placements']) > 0)
                    <b><u>Results</u></b>
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
                        {{$winners[$result->entrant_id]->getName($printableNames)}}

                     @endforeach
                @endif
                                    </div>
                                </div>

                @php
                    $lastSection = $thing->section
                @endphp

            @endforeach

                            </div>
                        </div>
                    </div>
            </div></div>
    </div>
    </div>
    </div>
        </div>
    </div>
    @if($isAdmin)<a href="/categories/create" class="button">+ Add a new category</a><br/>@endif
@stop