@extends('layouts/main')
@section('pagetitle', 'Cup ' . $thing->name)
@section('content')
    @php
        $printableNames = !$isAdmin
    @endphp
<a href="/cups">&laquo; Cups</a>
<br />
<ul>
      <li>Name: {{ $thing->name }}</li>
      <li>Criteria: {{ $thing->winning_criteria }}</li>
    </ul>

@if (count($cup_links) > 0)
<b>Linked to: </b><br/>
<table border>
    <tr><th>Category</th><th>First</th><th>Second</th><th>Third</th><th>Commended</th></tr>


@foreach ($cup_links as $cup_link)
@if (array_key_exists($cup_link->category, $category_data) && !is_null($category_data[$cup_link->category]))
<tr>
    <td>{{$category_data[$cup_link->category]->number}}. {{$category_data[$cup_link->category]->name}}</td>
    @if (array_key_exists($cup_link->category, $winners_by_category) && count($winners_by_category[$cup_link->category]) > 0)
        <td>
            @if (array_key_exists('1', $winners_by_category[$cup_link->category]))
                {{$winners[$winners_by_category[$cup_link->category]['1']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$cup_link->category]['1']['points']}} points)
            @else
             - 
            @endif
        </td>
        <td>
            @if (array_key_exists('2', $winners_by_category[$cup_link->category]))
                {{$winners[$winners_by_category[$cup_link->category]['2']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$cup_link->category]['2']['points']}} points)
            @else
             - 
            @endif
        </td>
        <td>
            @if (array_key_exists('3', $winners_by_category[$cup_link->category]))
                {{$winners[$winners_by_category[$cup_link->category]['3']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$cup_link->category]['3']['points']}} points)
            @else
             - 
            @endif
        </td>
        <td>
            @if (array_key_exists('commended', $winners_by_category[$cup_link->category]))
                {{$winners[$winners_by_category[$cup_link->category]['commended']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$cup_link->category]['commended']['points']}} points)
            @else
             - 
            @endif
        </td>
    @else
    <td colspan="4">Unavailable</td>
    @endif
    
</tr>
@else
<tr><td>Misssing data for {{$cup_link->category}}</td></tr>
@endif
@endforeach

</table>
@else
<h2>Pick a winner from an entry</h2>
{{ Form::open([
    'route' => ['cup.directResultPick','id'=>$thing->id]
]) }}
{{ Form::select('category', $categories)}}
{{ Form::submit('Find Entrants', ['class' => 'button btn btn-primary']) }}
{{Form::close()}}
<h2>Pick a winner from a list of entrants</h2>
{{ Form::open([
    'route' => ['cup.directResultSetWinnerPerson','id'=>$thing->id]
]) }}
{{ Form::select('person', $people)}}
{{ Form::submit('Set Winner', ['class' => 'button btn btn-primary']) }}
{{Form::close()}}
@endif

@stop