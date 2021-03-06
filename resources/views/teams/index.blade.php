@extends('layouts.app', ['activePage' => 'teams', 'titlePage' => __('All Teams')])
@section('pagetitle', 'All Teams ')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">Teams</div>
                    <div class="card-body">
                        @can('create', \App\Models\Team::class)
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
                                        <b><big>{{ $team->name }} ({{$team->min_age}}-  {{$team->max_age}} yrs)</big></b>
                                </div>
                                <div class="col-md-3 ">
                                    {{$team->team_memberships()->where('show_id',$show_id)->count()}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

















