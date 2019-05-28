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

@if (count($categories) > 0)
<b>Linked to: </b><br/>
<table border>
    <tr><th>Category</th><th>First</th><th>Second</th><th>Third</th><th>Commended</th></tr>


@foreach ($categories as $category)
<tr>
    <td>{{$category->getNumberedLabel()}}</td>
    @if (array_key_exists($category->id, $winners_by_category) && count($winners_by_category[$category->id]) > 0)
        <td>
            @if (array_key_exists('1', $winners_by_category[$category->id]))
                {{$winners[$winners_by_category[$category->id]['1']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$category->id]['1']['points']}} points)
            @else
             - 
            @endif
        </td>
        <td>
            @if (array_key_exists('2', $winners_by_category[$category->id]))
                {{$winners[$winners_by_category[$category->id]['2']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$category->id]['2']['points']}} points)
            @else
             - 
            @endif
        </td>
        <td>
            @if (array_key_exists('3', $winners_by_category[$category->id]))
                {{$winners[$winners_by_category[$category->id]['3']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$category->id]['3']['points']}} points)
            @else
             - 
            @endif
        </td>
        <td>
            @if (array_key_exists('commended', $winners_by_category[$category->id]))
                {{$winners[$winners_by_category[$category->id]['commended']['entrant']]->getName($printableNames)}} ({{$winners_by_category[$category->id]['commended']['points']}} points)
            @else
             - 
            @endif
        </td>
    @else
    <td colspan="4">Unavailable</td>
    @endif
    
</tr>

@endforeach

</table>
@else
    @if ($isAdmin)
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
@endif
@stop