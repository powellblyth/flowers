@extends('layouts.app', ['activePage' => 'shows  ', 'titlePage' => __('All Shows')])
@section('pagetitle', $show->name . ' - show')
@section('content')

    <a href="{{route('shows.index')}}">&laquo; Shows</a>
    <br/>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 card">
                <div class="card-header card-header-success"> {{ $show->name }}</div>
                <div class="card-body">
    <ul>

        <li>Name: {{ $show->name }}</li>
        <li>Date: {{ $show->start_date->format('Y-m-d H:i') }} = {{ $show->ends_date->format('Y-m-d H:i') }}</li>
        <li>Entries late after: {{ $show->late_entry_deadline->format('Y-m-d H:i') }}</li>
        <li>Entries close: {{ $show->entries_closed_deadline->format('Y-m-d H:i') }}</li>
        <a href="{{route('categories.index', ['show'=>$show])}}" class="btn btn-sm btn-default">Categories</a>
    </ul>
                </div>
            </div>
        </div>
    </div>

@stop