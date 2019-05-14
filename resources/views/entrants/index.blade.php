
@extends('layouts/main')

@if(true === $all)
    @section('pagetitle', 'All Entrants ')
@else
    @section('pagetitle', 'My Entrants ')
@endif
@section('content')

    @if(true === $all)
        {{ Form::open([
            'route' => 'entrants.searchall',
            'method' => 'GET'
        ]) }}
    @else
{{ Form::open([
    'route' => 'entrants.search',
    'method' => 'GET'
]) }}
@endif
    <p>Use this page to see yourself and your family. Click 'Add an Entrant' above to add yourselves</p>
<table>
        <tr>
            @if(true === $all)
            <td>{{ Form::label('section', 'Search All:', ['class' => 'control-label']) }}</td>
            @else
                <td>{{ Form::label('section', 'Search:', ['class' => 'control-label']) }}</td>
            @endif
            <td>{{ Form::text('searchterm', null, ['class' => 'form-control']) }}</td>
            <td>{{ Form::submit('Search', ['class' => 'button btn btn-primary']) }}</td>   
        </tr>
    </table>

{{ Form::close() }}

@foreach ($things as $thing)
<p>{{$thing->id}}: <a href="{{$thing->getUrl()}}">{{ $thing->firstname }} {{ $thing->familyname }}</a></p>
@endforeach
@stop