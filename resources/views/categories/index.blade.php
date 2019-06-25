@extends('layouts.app', ['activePage' => 'categories', 'titlePage' => __('Show Categories'), 'title' => __('')])
@section('pagetitle', 'All categories ')

@section('content')
    @php
        $lastSection = 'no';
        $publishMode = false;
        $printableNames = !$isAdmin;


    @endphp
    <div class="content">
        <div class="container-fluid">
            @if($isAdmin)
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{{ route('category.print') }}" target="_blank" class="btn btn-sm btn-primary">{{ __('Print show entry cards') }}</a>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">All categories</div>
                        <div class="card-body">
                            <p>You can see the categories for this show, along with all winners from the {{config('app.year')}} show, if available, here.</p>
                        </div>
                    </div>
                </div>
            </div>


            @foreach ($categoryList as $section => $categories)
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-success">
                                Section {{$sectionList[$section]}}
                            </div>

                            <div class="card-body">
                                @if (!$publishMode && $isAdmin)
                                    <p><a class="button btn btn-success"
                                          href="/categories/resultsentry?section={{urlencode($section)}}">Enter
                                            Results</a></p>
                                @endif
                                @foreach ($categories as $category)
                                    <div class="row">
                                        <div class="col-lg-5 col-md-12">
                                            <p>{{$category->number}}. {{ $category->name }}
                                                (<b>
                                                    @if (array_key_exists($category->id, $results) && $results[$category->id]['total_entries'] > 0)
                                                        {{ $results[$category->id]['total_entries']}}
                                                    @else
                                                        {{'0'}}
                                                    @endif
                                                </b> entries)
                                            </p>
                                        </div>
                                        @if(array_key_exists($category->id, $results) && count($results[$category->id]['placements']) > 0)

                                            <div class="col-lg-7">
                                                <b><u>Results:</u></b>
                                                @foreach ($results[$category->id]['placements'] as $result)
                                                    <b>
                                                        @if($result->winningplace == 1)
                                                            <span class="badge-success">First Place</span>
                                                        @elseif ($result->winningplace == 2)
                                                            <span class="badge-warning">Second Place</span>
                                                        @elseif ($result->winningplace == 3)
                                                            <span class="badge-danger">Third Place</span>
                                                        @else
                                                            {{ucfirst($result->winningplace)}}
                                                        @endif
                                                    </b>
                                                    <nobr>{{$winners[$result->entrant_id]->getName($printableNames)}}</nobr>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>


                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    @if($isAdmin)<a href="/categories/create" class="button">+ Add a new category</a><br/>@endif
@stop