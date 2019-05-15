@extends('layouts.app', ['activePage' => 'entrants', 'titlePage' => __('My Entrants')])

@if(true === $all)
    @section('pagetitle', 'All Entrants ')
@else
    @section('pagetitle', 'My Entrants ')
@endif
@section('content')



    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">Enter the Entrant's details</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"><p>Use this page to see yourself and your family. Click 'Add an
                                        Entrant' on the menu to add yourselves.</p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    @if(true === $all)
                                        {{ Form::open([
                                            'route' => 'entrants.searchall',
                                            'method' => 'GET'
                                        ]) }}
                                    @else
                                        {{ Form::open([
                                            'route' => 'entrants.search',
                                            'method' => 'GET'
                                        ]) }}     @endif                           @if(true === $all)
                                        {{ Form::label('section', 'Search All:', ['class' => 'control-label']) }}
                                    @else
                                        {{ Form::label('section', 'Search:', ['class' => 'control-label']) }}
                                    @endif
                                    {{ Form::text('searchterm', null, ['class' => 'form-control']) }}
                                    {{ Form::submit('Search', ['class' => 'button btn btn-primary']) }}


                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    @foreach ($things as $thing)
                                        <p>{{$thing->id}}: <a
                                                    href="{{$thing->getUrl()}}">{{ $thing->firstname }} {{ $thing->familyname }}</a>
                                        </p>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop