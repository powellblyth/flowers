@extends('layouts.main')
@section('pagetitle', 'Results entry for ' . $section->name)
@section('content')
    <a href="{{config('nova.path')}}/resources/sections">&laquo; Sections</a>
    <br/>

    <div style="text-align:left;vertical-align:middle">

        <form method="post" action="{{route('sections.storeresults',['show'=> $show, 'section' => $section])}}">
            @csrf
        @foreach ($section->categories()->with(['entries.entrant'])->forShow($show)->inOrder()->get() as $category)
            {{$category->numbered_name}}<br/>
            <b>@lang('Entrants:')</b>
            @foreach ($category->entries->sortBy('winningplace') as $entry)
                <div style="display:inline-block;background-color:{{$entry->winning_colour ?? '#d9edf7'}}; margin:2px; padding:2px;">
                    <span style="{{$entry->winning_colour ? 'color:'.$entry->winning_colour .'; -webkit-filter: invert(100%);filter: invert(100%);;font-weight:bold':''}}">
                        <label for="first_place" class="control-label">{{$entry->entrant->entrant_number . ' ' .$entry->entrant->full_name}}</label>
                    <br/>
                        <select name="entries[{{$entry->id}}]"
                                {{!empty($entry->winningplace) ? 'disabled="disabled"' : '' }}
                                class="form-control"
                                style="width:200px; font-weight:bold">
                            @foreach ($winning_places as $winningPlaceId => $winningPlace)
                                <option value="{{$winningPlaceId}}"
                                @if($winningPlaceId == $entry->winningplace)
                                    selected="selected"
                                    @endif
                                >{{ucwords($winningPlace)}}</option>
                            @endforeach
                        </select>
{{--                    {{Form::select('entries['.$entry->id.']',--}}
{{--                            $winning_places,--}}

{{--                            $entry->winningplace,--}}
{{--                            ['disabled' => ,--}}
{{--                            'class' => 'form-control',--}}
{{--                            'style'=>'width:200px; font-weight:bold'])}}--}}
{{--                    </span>--}}
                </div>
            @endforeach
            <hr/>
        @endforeach


            <input type="submit" class="button btn btn-primary">@lang('Store Results')</input>
        <br/><br/><br/>
        </form>
    </div>


@stop
