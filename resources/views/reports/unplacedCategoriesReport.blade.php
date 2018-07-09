@extends('layouts/main')
@section('pagetitle', 'Entries Purchased'))
@section('content')
<a href="{{route('reports.index')}}">&laquo; Reports</a>
<br />
<table>
    <thead>    <tr>
        <th>Date</th><th>Name</th><th>Type</th><th>Paid</th><th>Late?</th>
</tr>
    </thead>
    @foreach ($unplaced_categories as $categoryID=>$categoryName)
    <tr> <td><a href="/categories/{{$categoryID}}">{{$categoryName}}</a></td></tr>
@endforeach
</table>

@stop
