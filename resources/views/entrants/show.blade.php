@extends('layouts/main')
@section('pagetitle', 'Entrant ' . $thing->getName())
@section('content')
<a href="/entrants">&laquo; Entrants</a>
<br />
<table>
    <tr>
        <td><b>ID: {{ $thing->id }}</b></td>
        <td><b>Member Number:</b> {{ $thing->membernumber }}</td>
    </r>
    <tr>
        <td><b>Name:</b> {{ $thing->getName() }}</td>
        <td><b>Age:</b> {{ $thing->age }}</td>
        </td>
    </tr>
    <tr>
        <td colspan="2"><a href="/entrants/{{$thing->id}}/print" target="_blank" class="button">Print all cards</a> <a href="/entrants/{{$thing->id}}/edit" class="button">Edit Entrant</a></td>
    </tr>
</table>

<table style="width:100%;border:1px solid #ddd">
    <tr>
        <td><h2>Payments (&pound;{{number_format($paid,2)}})</h2></td>
        <td><h2>Memberships (&pound;{{number_format($membership_fee/100,2)}})</h2></td>
        <td><h2>Entries ({{count($entries)}}, &pound;{{number_format($entry_fee/100,2)}})</h2></td>
        <td><h2>Totals</h2></td>
    </tr>
    <tr>
        <td style="text-align:left;vertical-align:top">
@if (count($payments) <= 0)
{{$thing->firstname}} has not made any payments yet
@else
@foreach ($payments as $payment)
<p><b>&pound;{{number_format($payment->amount,2)}}</b> {{date_format($payment->created_at,'jS M Y')}}</p>
@endforeach
@endif

        </td>
        <td style="text-align:left;vertical-align:top">

@foreach ($membership_purchases as $purchase)
<p>{{ucfirst($purchase['type'])}} &pound;{{number_format($purchase['amount']/100,2)}}</p>
@endforeach
        </td>
        <td style="text-align:left;vertical-align:top">

@if (count($entry_data ) <= 0)
{{$thing->firstname}} has not entered any categories yet
@else
@foreach ($entry_data as $entry)

<p> {{$entry['name']}} ({{$entry['price']}}p) 
    @if ($entry['is_late'])
    (late)
    
   @endif
    @if ($entry['has_won'])
    <b><u>{{$entry['placement_name']}}</u></b>
    (&pound;{{number_format($category_data[$entry['category_id']]->getWinningAmount($entry['winning_place'])/100,2)}})
    @endif
</p>
@endforeach
@endif
        </td>
        <td style="text-align:left;vertical-align:top">
            <p><nobr><b>Balance due: &pound;{{number_format((($entry_fee + $membership_fee)/100) - $paid,2)}}</b></nobr></p>
<p><nobr><b>Prizes</b>
    <b>£{{number_format($total_prizes/100,2)}}</b></nobr></p>
        </td>
    </tr>
</table>
<h2>Opt-in</h2>
{{  Form::model($thing, array('route' => array('entrants.optins', $thing->id))) }}
<table border="0">
<tr>
            <td colspan="3"><b>We would like permission to retain your personal data within our data entry system for a period of 3 years after
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
            <td>{{ Form::label('can_retain_data', 'Can we retain your data?:', ['class' => 'control-label']) }}
                {{ Form::checkbox('can_retain_data', 1) }}</td>
            <td>{{ Form::label('can_email', 'Can we contact you by email?:', ['class' => 'control-label']) }}
                {{ Form::checkbox('can_email', 1) }}</td>
            <td>{{ Form::label('can_sms', 'Can we contact you by SMS?:', ['class' => 'control-label']) }}
                {{ Form::checkbox('can_sms', 1) }}</td>
        </tr>
</table>
{{ Form::submit('Store Preferences', ['class' => 'button btn btn-primary']) }}
{{ Form::close()}}


<h2>New Entry</h2>

{{ Form::open([
    'route' => 'entry.creates'
]) }}

{{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}

@for ($i = 0; $i < 40; $i++)
{{ Form::select('categories[]', $categories, null, ['class' => 'form-control','style'=>'width:100px']) }}
@endfor
<br />
{{ Form::submit('Create Entry', ['class' => 'button btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}
<h2>New Payment Record</h2>

{{ Form::open([
    'route' => 'payments.store'
]) }}

{{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}
{{ Form::label('amount', 'Amount: &pound;', ['class' => 'control-label']) }}
{{ Form::text('amount', null, ['class' => 'form-control']) }}
            {{Form::select('source', $payment_types, null, ['class' => 'form-control','style'=>'width:100px'])}}
<br />
{{ Form::submit('Store Payment', ['class' => 'button btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}
<h2>New Membership Purchase</h2>

{{ Form::open([
    'route' => 'membershippurchases.store'
]) }}

{{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}
{{ Form::label('type', 'Type:', ['class' => 'control-label']) }}
            {{Form::select('type', $membership_types, null, ['class' => 'form-control','style'=>'width:100px'])}}
<br />
{{ Form::submit('Purchase Membership', ['class' => 'button btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}

@stop