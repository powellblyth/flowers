@extends('layouts/main')
@section('pagetitle', 'Results section for ' . $section)
@section('content')
<a href="/categories">Categories</a>
<br />

<div style="text-align:left">
{{ Form::open([
    'route' => 'categories.storeresults'
]) }}
@foreach ($categories as $category)
{{$category->number}} {{$category->name}}<br />  
<b>Entrants:</b>
@foreach ($entries[$category->id] as $entrant => $entrantName)
<span style="background-color:#d9edf7; margin:2px; padding:2px;">
{{ Form::label('first_place', $entrantName, ['class' => 'control-label']) }}
{{Form::select('positions['.$category->id.']['.$entrant.']', array(0=>'Choose...', 1=>'First Place', 2=>'Second Place', 3=>'Third Place', 'commended'=>'Commended'), (array_key_exists($entrant, $winners[$category->id])?$winners[$category->id][$entrant]:null), ['disabled'=>array_key_exists($entrant, $winners[$category->id]),'class' => 'form-control','style'=>'width:200px'])}}
</span>
@endforeach
<hr />
@endforeach


{{ Form::submit('Store Results', ['class' => 'btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}
</div>


@stop