@extends('layouts/main')
@section('pagetitle', 'Results section for ' . $section->name)
@section('content')
<a href="/categories">&laquo; Categories</a>
<br />

<div style="text-align:left;vertical-align:middle">
{{ Form::open([
    'route' => 'categories.storeresults'
]) }}
@foreach ($categories as $category)
    {{$category->getNumberedLabel()}}<br />  
    <b>Entrants:</b>
    @foreach ($entries[$category->id] as $entryId => $entrantAry)
        <div style="display:inline-block;background-color:#d9edf7; margin:2px; padding:2px;">
        {{ Form::label('first_place', $entrantAry['entrant_name'], ['class' => 'control-label']) }}<br />  
        {{Form::select('positions['.$category->id.']['.$entryId.']', 
                array(0=>'Choose...', 
                    1=>'First Place', 
                    2=>'Second Place', 
                    3=>'Third Place', 
                    'commended'=>'Commended'), 

                (array_key_exists($entrantAry['entrant_id'], $winners[$category->id])
                    ? $winners[$category->id][$entrantAry['entrant_id']]
                     :null), 
                ['disabled' => array_key_exists($entrantAry['entrant_id'],
                        $winners[$category->id]),
                'class' => 'form-control',
                'style'=>'width:200px'])}}
        </div>
    @endforeach
    <hr />
@endforeach


{{ Form::submit('Store Results', ['class' => 'button btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}
</div>


@stop