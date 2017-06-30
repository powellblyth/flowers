
@extends('layouts/main')
@section('pagetitle', 'All Entrants ')

@section('content')

{{ Form::open([
    'route' => 'entrants.search',
    'method' => 'GET'
]) }}
<table>
        <tr>
            <td>{{ Form::label('section', 'Search:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('searchterm', null, ['class' => 'form-control']) }}</td>
            <td>{{ Form::submit('Search', ['class' => 'button btn btn-primary']) }}</td>   
        </tr>
    </table>

{{ Form::close() }}

@foreach ($things as $thing)
<p>{{$thing->id}}: <a href="{{$thing->getUrl()}}">Entrant {{ $thing->firstname }} {{ $thing->familyname }}</a></p>
@endforeach
@stop