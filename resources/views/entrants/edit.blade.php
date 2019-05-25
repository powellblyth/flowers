@extends('layouts/main')
@section('pagetitle', 'Edit Entrant ')

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
            <td>{{ Form::label('age', 'Age (Children):', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('age', null, ['class' => 'form-control']) }}</td>
        </tr>
{{--        <tr>--}}
{{--            <td>{{ Form::label('address', 'Address:', ['class' => 'control-label']) }}</td>--}}
{{--            <td>{{ Form::text('address', null, ['class' => 'form-control']) }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>{{ Form::label('address2', 'Address line 2:', ['class' => 'control-label']) }}</td>--}}
{{--            <td>{{ Form::text('address2', null, ['class' => 'form-control']) }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>{{ Form::label('addresstown', 'Town / City:', ['class' => 'control-label']) }}</td>--}}
{{--            <td>{{ Form::text('addresstown', null, ['class' => 'form-control']) }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>{{ Form::label('postcode', 'Postcode:', ['class' => 'control-label']) }}</td>--}}
{{--            <td>{{ Form::text('postcode', null, ['class' => 'form-control']) }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>{{ Form::label('email', 'Email:', ['class' => 'control-label']) }}</td>--}}
{{--            <td>{{ Form::text('email', null, ['class' => 'form-control']) }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>{{ Form::label('telephone', 'Telephone:', ['class' => 'control-label']) }}</td>--}}
{{--            <td>{{ Form::text('telephone', null, ['class' => 'form-control']) }}</td>--}}
{{--        </tr>--}}
        <tr>
            <td colspan="2"><b>We would like permission to retain your personal data within our data entry system for a period of 3 years after
            your last entry to the show. This includes your name, telephone number, email address, and age (children only).<br />
            The reason to retain this is for the purposes of <br />
            <ol>
                <li>Making it faster for you to enter next year, as you would not need to provide your data again (unless it changed)</li>
                <li>Sending you reminders up to three times per year to remind you about the show, and invite you to our events.</li>
                <li> we will <i> NOT </i> share this data with any third parties, beyond communication systems under our control used to send the messages (e.g. email sending software).</li>
                <li>You can opt out of this at any time by emailing enquiries@petershamhorticulturalsociety.org.uk</li>
            </ol></b></td>
        </tr>
        <tr>
            <td>{{ Form::label('can_retain_data', 'Can we retain your data?:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::checkbox('can_retain_data', 1) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('can_email', 'Can we contact you by email?:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::checkbox('can_email', 1) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('can_sms', 'Can we contact you by Text Message (SMS)?:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::checkbox('can_sms', 1) }}</td>
        </tr>
        <tr>
            <td>{{ Form::label('can_post', 'Can we contact you by Text Message (SMS)?:', ['class' => 'control-label']) }}</td>
            <td>{{ Form::checkbox('can_post', 1) }}</td>
        </tr>
    </table>
</div>

{{ Form::submit('Save Entrant', ['class' => 'button btn btn-primary']) }}

{{ Form::close() }}

@stop