@if(true === $all)
    @php
        $activePage = 'allentrants';
        $pageTitle = __('All Entrants');
    @endphp
@else
    @php
        $activePage = 'entrants';
        $pageTitle = __('My Family');
    @endphp
@endif
@extends('layouts.app', ['activePage' =>$activePage, 'titlePage' => $pageTitle])

@section('pagetitle', $pageTitle)
@section('content')



    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">{{__('Family Members')}}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(true == $all)
                                        These are all the entrants currently registered, including anonymised entrants
                                    @elseif ($owner->id == Auth::User()->id)
                                        <p>Use this page to see yourself and your family. Click 'Add a
                                            Family Member' on the menu to add yourselves.</p>
                                    @else
                                        <p>These are the family members belonging to {{$owner->getName()}}.</p>
                                    @endif
                                </div>

                            </div>
                            @if(true === $all)
                                {{ Form::open([
                                    'route' => 'entrants.searchall',
                                    'method' => 'GET'
                                ]) }}
                                {{ Form::label('section', __('Search All').':', ['class' => 'control-label']) }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-10 col-sm-10">
                                        {{ Form::text('searchterm', null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        {{ Form::submit('Search', ['class' => 'button btn btn-primary']) }}
                                    </div>
                                </div>
                                {{ Form::close() }}
                            @endif
                            <div class="row">
                                @if(count($things )> 0)
                                    <div class="table-responsive col-lg-6 col-md-12 col-sm-12">
                                        <table class="table ">
                                            <thead>
                                            <th>Name</th>
                                            @if($all)
                                                <th>Owner User</th>
                                            @endif
                                            </thead>
                                            @foreach ($things as $thing)
                                                <tr>
                                                    <td>
                                                        <a href="{{$thing->getUrl()}}">{{ $thing->firstname }} {{ $thing->familyname }}</a>
                                                    </td>
                                                    @if($all)
                                                        <td>
                                                            @if (!is_null($thing->user ))
                                                                {{$thing->user->getName()}}
                                                                <a rel="tooltip" class="btn btn-primary btn-link"
                                                                   href="{{route('user.edit', $thing->user)}}"
                                                                   data-original-title=""
                                                                   title="">
                                                                    <i class="material-icons">visibility</i>
                                                                    <div class="ripple-container"></div>
                                                                </a>
                                                            @endif</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        There are no family members here
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@stop