@extends('layouts/main')
@section('pagetitle', 'Add a Category ')

@section('content')

{{ Form::open([
    'route' => 'categories.store'
]) }}

<div class="form-group">
    <table>
        <tr>
            <td>{{ Form::label('name', 'Category:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::label('name', 'Num:', ['class' => 'control-label']) }}{{ Form::text('number', null, ['class' => 'form-control']) }} 
                {{ Form::label('name', 'Name:', ['class' => 'control-label']) }} {{ Form::text('name', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('section', 'Section:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::select('section', $sections, null, ['class' => 'form-control']) }}</td>
        </tr>
    </table>
</div>

{{ Form::submit('Create New Category', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}

@stop