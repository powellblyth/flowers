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
                            @if(false == $all && $owner->id !== Auth::User()->id)
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('user.edit', $owner) }}" class="btn btn-sm btn-primary">Edit {{$owner->firstname}}</a>
{{--                                    <a href="{{ route('entrants.index') }}?user_id={{$owner->id}}" class="btn btn-sm btn-primary">{{ __('See all Family Members') }}</a>--}}
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    @if(true == $all)
                                        These are all the entrants currently registered, including anonymised entrants
                                    @elseif ($owner->id == Auth::User()->id)
                                        <p>Use this page to see yourself and your family. Click 'Add a
                                            Family Member' on the menu to add yourselves.</p>
                                    @else
                                        <p>These are the family members managed by <b><a href="{{route('user.edit', $owner)}}">{{ucwords($owner->getName())}}</a></b>.</p>
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
                                    <div class="table-responsive col-lg-8 col-md-12 col-sm-12">
                                        <table class="table ">
                                            <thead>
                                            <th>Name</th>
                                            @if($all)
                                                <th>Family Manager</th>
                                                <th class="text-right">Actions</th>
                                            @endif
                                            </thead>
                                            @foreach ($things as $thing)
                                                <tr>
                                                    <td>
                                                        <a href="{{$thing->getUrl()}}">{{ ucwords($thing->firstname) }} {{ ucwords($thing->familyname) }}</a>
                                                    </td>
                                                    @if($all)
                                                            @if (!is_null($thing->user ))
                                                            <td>
                                                                <a rel="tooltip" class="default "
                                                                href="{{route('user.edit', $thing->user)}}"
                                                                data-original-title=""
                                                                title="Edit {{$thing->user->getName()}} (Family Manager)">
                                                                {{$thing->user->getName()}}
                                                                </a>

                                                        </td>
                                                        <td class="text-right">
{{--                                                                <a href="{{ route('user.edit', $owner) }}" class="btn btn-sm btn-primary">Edit {{$owner->firstname}}</a>--}}
{{--                                                                <a href="{{ route('entrants.index') }}?user_id={{$owner->id}}" class="btn btn-sm btn-primary">{{ __('See all Family Members') }}</a>--}}

                                                                <a rel="tooltip" class="btn btn-success"
                                                                   href="{{route('entrants.index')}}?user_id={{$thing->user->id}}"
                                                                   data-original-title=""
                                                                   title="Show {{$thing->user->getName()}}'s Family">
                                                                    Show Family
                                                                </a></td>
                                                            @endif
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