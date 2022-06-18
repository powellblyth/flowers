@extends('layouts.main')
@section('pagetitle', 'Results entry for ' . $section->name)
@section('content')
    <a href="{{config('nova.path')}}/resources/sections">&laquo; Sections</a>
    <br/>

    <div style="text-align:left;vertical-align:middle">

        {{Form::open(['route'=>array('sections.storeresults',$show)])}}
        @foreach ($section->categories()->with(['entries.entrant'])->forShow($show)->orderBy('sortorder')->get() as $category)
            {{$category->numbered_name}}<br/>
            <b>Entrants:</b>
            @foreach ($category->entries->sortBy('winningplace') as $entry)
                <div style="display:inline-block;background-color:{{$entry->winning_colour ?? '#d9edf7'}}; margin:2px; padding:2px;">
                    <span style="{{$entry->winning_colour ? 'color:'.$entry->winning_colour .'; -webkit-filter: invert(100%);filter: invert(100%);;font-weight:bold':''}}">
                    {{ Form::label('first_place', $entry->entrant->entrant_number . ' ' .$entry->entrant->full_name, ['class' => 'control-label']) }}
                    <br/>
                    {{Form::select('entries['.$entry->id.']',
                            $winning_places,

                            $entry->winningplace,
                            ['disabled' => !empty($entry->winningplace),
                            'class' => 'form-control',
                            'style'=>'width:200px; font-weight:bold'])}}
                    </span>
                </div>
            @endforeach
            <hr/>
        @endforeach


        {{ Form::submit('Store Results', ['class' => 'button btn btn-primary']) }}
        <br/><br/><br/>
        {{ Form::close() }}
    </div>


@stop
