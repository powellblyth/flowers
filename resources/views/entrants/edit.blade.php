@extends('layouts/main')
@section('pagetitle', 'All Entrants ')

@section('content')

{{  Form::model($thing, array('route' => array('entrants.update', $thing->id))) }}


<div class="form-group">
    <table>
        <tr>
            <td>{{ Form::label('firstname', 'First Name:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('firstname', null, ['class' => 'form-control']) }}</td>
       </tr>
        <tr>
            <td>{{ Form::label('familyname', 'Family Name:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('familyname', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('membernumber', 'Member Number:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('membernumber', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('email', 'Email:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('email', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('address', 'Address:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('address', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('address', 'Address line 2:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('address2', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('addresstown', 'Town / City:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('address', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('postcode', 'Postcode:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('postcode', null, ['class' => 'form-control']) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('age', 'Age (Children):', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('age', null, ['class' => 'form-control']) }}</td>
        </tr>
    </table>
</div>

{{ Form::submit('Save Entrant', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}

@stop