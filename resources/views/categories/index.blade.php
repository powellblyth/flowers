@extends('layouts.app', ['activePage' => 'categories', 'titlePage' => __('Show Categories'), 'title' => __('')])
@section('pagetitle', 'All categories ')

@section('content')
    @php
        $lastSection = 'no';
        $publishMode = false;
    @endphp
        <div class="container-fluid">
            <div class="row">
                @foreach ($shows as $showNav)
                    <div class="col-1">
                        <a href="{{route('reports.entries')}}?show_id={{$showNav->id}}">{{$showNav->name}}</a>
                    </div>
                @endforeach
            </div>
            @can('printCards', \App\Models\Entry::class)
                @if($show->isCurrent())
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('category.tabletopprint') }}" target="_blank"
                               class="btn btn-sm btn-primary">{{ __('Print table-top cards') }}</a>
                            <a href="{{ route('category.lookupprint') }}" target="_blank"
                               class="btn btn-sm btn-primary">{{ __('Print category lookup sheet') }}</a>
                        </div>
                    </div>
                @endif
            @endcan


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">All categories</div>
                        <div class="card-body">
                            <p>You can see the categories for this show, along with all winners from the {{$show->name}} show,
                                if available, here.</p>
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
                                @if (!$publishMode && $show->isCurrent() && !$isLocked)
                                    @can('enterResults', \App\Models\Entry::class)
                                    <p><a class="button btn btn-success"
                                          href="/categories/resultsentry?section={{urlencode($section)}}">Enter Results</a></p>
                                    @endcan
                                @endif
                                @foreach ($categories as $category)
                                    <div class="row">
                                        <div class="col-lg-5 col-md-12">
                                            <p>{{$category->number}}. {{ $category->name }}
                                                (<b>
                                                    @if (array_key_exists($category->id, $results))
                                                        {{ (int) $results[$category->id]['total_entries']}}
                                                        {{\Illuminate\Support\Str::plural('entry',  (int) $results[$category->id]['total_entries'])}})
                                                    @else
                                                        0 entries
                                                    @endif
                                                </b>
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
                                                    <nobr>
                                                        @can('seeDetailedInfo',$winners[$result->entrant_id])
                                                            {{$winners[$result->entrant_id]->getName(false)}}
                                                        @else
                                                            {{$winners[$result->entrant_id]->getPrintableName()}}
                                                        @endcan
                                                    </nobr>
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

@stop