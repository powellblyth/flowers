@extends('layouts/main')
@section('pagetitle', 'Category ' . $thing->number)
@section('content')
<a href="/categories">Categories</a>
<br />
<ul>
      <li>Number: {{ $thing->number }}</li>
      <li>Name: {{ $thing->name }}</li>
      <li>Section: {{ $thing->section->name }}</li>
    </ul>
@stop