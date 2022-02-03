@extends('layouts.main')
@section('pagetitle', 'Results section for ' . $section->name)
@section('content')
    <a href="{{route('categories.index')}}">&laquo; Categories</a>
    <br/>

    <div style="text-align:left;vertical-align:middle">

        {{Form::open(['route'=>array('sections.storeresults',$show)])}}
        @foreach ($section->categories->where('show_id', $show->id)->sortBy('sortorder') as $category)
            {{$category->numbered_name}}<br/>
            <b>Entrants:</b>
            @foreach ($category->entries->sortBy('winningplace') as $entry)
                <div style="display:inline-block;background-color:#d9edf7; margin:2px; padding:2px;">
                    {{ Form::label('first_place', $entry->entrant->entrant_number . ' ' .$entry->entrant->full_name, ['class' => 'control-label']) }}
                    <br/>
                    {{Form::select('entries['.$entry->id.']',
                            $winning_places,

                            in_array($entry->winningplace, $winning_places ) ? $entry->winningPlace:null,
                            ['disabled' => !empty($entry->winningplace),
                            'class' => 'form-control',
                            'style'=>'width:200px'])}}
                </div>
            @endforeach
            <hr/>
        @endforeach


        {{ Form::submit('Store Results', ['class' => 'button btn btn-primary']) }}
        <br/><br/><br/>
        {{ Form::close() }}
    </div>


@stop
