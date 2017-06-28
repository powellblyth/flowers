@section('extra_head')
    <link rel="stylesheet" href="{{URL::asset('css/formPrint.css')}}" media="print"/>
@stop
@extends('layouts/main')
@section('pagetitle', 'Entrant ' . $thing->firstname. ' ' .  $thing->familyname)
@section('content')
<a href="/entrants">Entrants</a>
<br />
<table>
    <tr>
        <td><b>ID: {{ $thing->id }}</b></td>
        <td><b>Member Number:</b> {{ $thing->membernumber }}</td>
    </r>
    <tr>
        <td><b>Name:</b> {{ $thing->firstname }} {{ $thing->familyname }}</td>
        <td><b>Age:</b> {{ $thing->age }}</td>
        </td>
    </tr>
    <tr>
        <td colspan="2"><a href="/entrants/{{$thing->id}}/print">PRINT ALL CARDS</a> <a href="/entrants/{{$thing->id}}/edit">Edit Entrant</a></td>
    </tr>
</table>

<table style="width:100%;border:1px solid #ddd">
    <tr>
        <td><h2>Payments (&pound;{{number_format($paid,2)}})</h2></td>
        <td><h2>Entries ({{count($entries)}}, £{{number_format($entry_fee/100,2)}})</h2></td>
        <td><h2>Balance Due</h2></td>
    </tr>
    <tr>
        <td>
@if (count($payments) <= 0)
{{$thing->firstname}} has not made any payments yet
@else
@foreach ($payments as $payment)
<p><b>&pound;{{number_format($payment->amount,2)}}</b> {{date_format($payment->created_at,'dS M H:i')}}</p>
@endforeach
@endif

        </td>
        <td>

@if (count($entries) <= 0)
{{$thing->firstname}} has not entered any categories yet
@else
@foreach ($entries as $entry)

@php
                $created = new \DateTime($entry->created_at);
                $cutoffDate = new \DateTime('5 July 2017 23:59:59');

                if ($created < $cutoffDate )
                {
                    $thisPrice = $category_data[$entry->category]->price;
                }
                else
                {
                    $thisPrice = $category_data[$entry->category]->late_price;
                }

@endphp
<p>{{$category_data[$entry->category]->number}}) {{$category_data[$entry->category]->name}} ({{$thisPrice}}p) 
    @if ($entry->hasWon())
    <b><u>{{$entry->getPlacementName()}}</u></b>
    (£{{$category_data[$entry->category]->getWinningAmount($entry->winningplace)/100}})
    @endif
</p>
@endforeach
@endif
        </td>
        <td>
            <b>&pound;{{number_format(($entry_fee/100) - $paid,2)}}</b>
<p><b>Prizes</b>
    <b>£{{number_format($total_prizes/100,2)}}</b></p>
        </td>
    </tr>
</table>
<h2>New Entry</h2>

{{ Form::open([
    'route' => 'entry.creates'
]) }}

{{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}

@for ($i = 0; $i < 40; $i++)
{{ Form::select('categories[]', $categories, null, ['class' => 'form-control','style'=>'width:100px']) }}
@endfor
<br />
{{ Form::submit('Create Entry', ['class' => 'btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}
<h2>New Payment Record</h2>

{{ Form::open([
    'route' => 'payments.store'
]) }}

{{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}
{{ Form::label('amount', 'Amount: £', ['class' => 'control-label']) }}
{{ Form::text('amount', null, ['class' => 'form-control']) }}
            {{Form::select('source', $payment_types, null, ['class' => 'form-control','style'=>'width:100px'])}}
<br />
{{ Form::submit('Store Payment', ['class' => 'btn btn-primary']) }}
<br /><br /><br />
{{ Form::close() }}

@stop