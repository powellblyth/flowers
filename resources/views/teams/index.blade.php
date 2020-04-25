@extends('layouts.app', ['activePage' => 'cups', 'titlePage' => __('All Teams')])
@section('pagetitle', 'All Teams ')

@section('content')
    @php
        $publishMode = false;
        $shortName = false;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">Teams</div>
                    <div class="card-body">
                        @can('create', \App\Team::class)
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('teams.create') }}"
                                       class="btn btn-sm btn-primary">{{ __('Add Team') }}</a>
                                </div>
                            </div>
                        @endcan

                        <div class="row">
                            <div class="col-md-12"><p>These are the teams you can be a member of for the show.</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-9">Name</div>
                            <div class="col-md-3">Members</div>
                        </div>
                        @foreach ($teams as $team)

                            <div class="row">
                                <div class="col-md-9">
                                    {{ $team->name }}
                                    @if ( ! $publishMode)
                                        <i class="material-icons">eye</i>
                                    @else
                                        <b><big>{{ $team->name }} ({{$team->min_age}}-  {{$team->max_age}} yrs)</big></b>
                                    @endif
                                </div>
                                <div class="col-md-3 ">
                                    {{$team->entrants()->count()}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

















