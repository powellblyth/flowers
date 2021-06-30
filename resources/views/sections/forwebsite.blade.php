{{--@extends('layouts.app', ['activePage' => 'categories', 'titlePage' => __('Show Categories'), 'title' => __('')])--}}
{{--@section('pagetitle', 'All categories ')--}}

@php
    $lastSection = 'no';



@endphp
<table class="entryclasses">
    <tbody>

    @foreach ($things as $section)
        <tr>
            <td>
                <h4> Section {{$section->display_name}}<br /> Judges: {{$section->judges}}
                    <p>{!! $section->image !!}</p>
                </h4><br/>

            </td>
            <td><h5><em>{{$section->notes}}</em></h5>
                <ul>
                    @foreach ($categoryList[$section->id] as $category)
                        <li>{{$category->number}}. {{ $category->name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
