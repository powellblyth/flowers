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
@php
@endphp
@section('pagetitle', $pageTitle)
@section('content')

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    @can ('printcards',Entries::class)
                        <a href="{{route('entries.printall')}}" target="_blank"
                           class="btn btn-primary">Print ALL Cards</a>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">{{__('Family Members')}}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    These are all the entrants currently registered, including anonymised entrants
                                </div>

                            </div>
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
                            <div class="row">
                                @if(count($entrants )> 0)
                                    <div class="table-responsive col-lg-8 col-md-12 col-sm-12">
                                        <table class="table ">
                                            <thead>
                                            <th>Name</th>
                                            <th></th>
                                            <th>Family Manager</th>
                                            <th class="text-right">Actions</th>
                                            </thead>
                                            @foreach ($entrants as $entrant)
                                                <tr>
                                                    <td>{{ $entrant->getName() }}
                                                    @if ($entrant->age)
                                                        ({{$entrant->age}} yrs)
                                                        @endif
                                                    </td>
                                                    <td class="td-actions">
                                                        @if(!$isLocked)
                                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                               href="{{ route('entrants.edit', $entrant) }}"
                                                               data-original-title=""
                                                               title="edit {{$entrant->firstname}}">
                                                                <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                        @endif

                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                           href="{{ $entrant->getUrl() }}"
                                                           data-original-title=""
                                                           title="manage {{$entrant->firstname}}'s entries">
                                                            <i class="material-icons">build</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if (!is_null($entrant->user ))
                                                            <a rel="tooltip" class="default "
                                                               href="{{route('user.edit', $entrant->user)}}"
                                                               data-original-title=""
                                                               title="Edit {{$entrant->user->getName()}} (Family Manager)">
                                                                {{$entrant->user->getName()}}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="text-right td-actions">
                                                        {{--                                                                <a href="{{ route('user.edit', $owner) }}" class="btn btn-sm btn-primary">Edit {{$owner->firstname}}</a>--}}

                                                        {{--                                                                <a href="{{ route('entrants.index') }}?user_id={{$owner->id}}" class="btn btn-sm btn-primary">{{ __('See all Family Members') }}</a>--}}
                                                        @if (!is_null($entrant->user ))

                                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                               href="{{route('users.show', $entrant->user)}}"
                                                               data-original-title=""
                                                               title="Show {{$entrant->user->getName()}}'s Family">
                                                                <i class="material-icons">people</i>
                                                                <div class="ripple-container"></div>

                                                            </a>
                                                        @endif

                                                    </td>

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

@stop