@extends('layouts/main')
@section('pagetitle', 'Cup ' . $thing->name)
@section('content')
<a href="/cups">Cups</a>
<br />
<ul>
      <li>Name: {{ $thing->name }}</li>
    </ul>

<b>Linked to: </b><br/>
<table border>
    <tr><th>Category</th><th>First</th><th>Second</th><th>Third</th><th>Commended</th></tr>
    @php
    @endphp
@foreach ($cup_links as $cup_link)
<tr>
    <td>{{$category_data[$cup_link->category]->number}} {{$category_data[$cup_link->category]->name}}</td>
    @foreach ($winners_by_category[$cup_link->category] as $place=>$winner)
    <td>{{$place}} - {{$winners[$winner]['entrant']->getName()}} ({{$winners[$winner]['points']}} points)</td>
    @endforeach
</tr>
@endforeach
</table>
@stop