@extends('layouts.app', ['activePage' => 'shows  ', 'titlePage' => __('All Shows')])
@section('pagetitle', 'All Shows ')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header card-header-success">Shows</div>
                    <div class="card-body">
                        @can('create', \App\Show::class)
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('shows.create') }}"
                                       class="btn btn-sm btn-primary">{{ __('Add Show') }}</a>
                                </div>
                            </div>
                        @endcan

                        <div class="row">
                            <div class="col-md-12"><p>These are all the shows on the system.</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">Name</div>
                            @can('vieAll',\App\Entry::class)
                            <div class="col-md-3">Entries</div>
                            @endcan
                            <div class="col-md-3">Categories</div>
                        </div>
                        @foreach ($shows as $show)

                                <div class="row">
                                    <div class="col-md-3">
                                        <b><big>{{ $show->name }}</big> : {{$show->start_date->format('d M Y H:i')}}</b>
                                    </div>
                                    @can('vieAll',\App\Entry::class)
                                    <div class="col-md-3 ">
                                        {{$show->entries()->count()}}
                                    </div>
                                    @endcan
                                    <div class="col-md-3 ">
                                        {{$show->categories()->count()}}
                                    </div>


                                    @can('create', \App\Show::class)
                                        <div class="col-md-2">

                                            <a href="{{ route('shows.duplicate', ['show'=>$show]) }}"
                                               class="btn btn-sm btn-primary">{{ __('Duplicate this Show') }}</a>
                                        </div>
                                    @endcan
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

















