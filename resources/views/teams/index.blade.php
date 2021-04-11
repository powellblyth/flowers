@extends('layouts.app', ['activePage' => 'teams', 'titlePage' => __('All Teams')])
@section('pagetitle', 'All Teams ')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">Teams</div>
                    <div class="card-body">
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
                                        <b><big>{{ $team->name }} ({{$team->min_age}}-  {{$team->max_age}} yrs)</big></b>
                                </div>
                                <div class="col-md-3 ">
                                    {{$team->entrants()->where('show_id',$show_id)->count()}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

















