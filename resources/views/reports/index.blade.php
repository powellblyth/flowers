@extends('layouts/main')
@section('pagetitle', 'Reports')
@section('content')
<br />
<a href="{{route('reports.members')}}">&raquo; Members report</a><br />
<a href="{{route('reports.entries')}}">&raquo; Entries report</a>
<a href="{{route('reports.categories')}}">&raquo; Unplaced categories report</a>


@stop

