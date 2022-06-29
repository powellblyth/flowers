@extends('layouts/main')
@section('pagetitle', 'Cup ' . $cup->name . ' ' . $show->name)
@section('content')
    <a href="{{route('cups.index')}}">&laquo; Cups</a>
    <br/>
    <ul>
        <li>@lang('Name'): {{ $cup->name }}</li>
        <li>@lang('Show'): {{ $show->name }}</li>
        <li>@lang('Criteria'): {{ $cup->winning_criteria }}</li>
    </ul>

    @if (count($categories) > 0)
        <b>@lang('Linked to'): </b><br/>
        <table border>
            <tr>
                <th>@lang('Category')</th>
                <th>@lang('First')</th>
                <th>@lang('Second')</th>
                <th>@lang('Third')</th>
                <th>@lang('Commended')</th>
            </tr>


            @foreach '($categories as $categoryId=> $category)
                <tr>
                    <td>{{$category}}</td>
                    @if (array_key_exists($categoryId, $winners_by_category) && count($winners_by_category[$categoryId]) > 0)
                        <td>
                            @if (array_key_exists('1', $winners_by_category[$categoryId]))
                                {{$winners[$winners_by_category[$categoryId]['1']['entrant']]->printable_name}}
                                ({{$winners_by_category[$categoryId]['1']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (array_key_exists('2', $winners_by_category[$categoryId]))
                                {{$winners[$winners_by_category[$categoryId]['2']['entrant']]->printable_name}}
                                ({{$winners_by_category[$categoryId]['2']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (array_key_exists('3', $winners_by_category[$categoryId]))
                                {{$winners[$winners_by_category[$categoryId]['3']['entrant']]->printable_name}}
                                ({{$winners_by_category[$categoryId]['3']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (array_key_exists('commended', $winners_by_category[$categoryId]))
                                {{$winners[$winners_by_category[$categoryId]['commended']['entrant']]->printable_name}}
                                ({{$winners_by_category[$categoryId]['commended']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                    @else
                        <td colspan="4">@lang('Unavailable')</td>
                    @endif

                </tr>

            @endforeach

        </table>
    @else
        @can('storeResults', $show)
{{--            <h2>Pick a winner from an entry</h2>--}}
{{--            {{ Form::open([--}}
{{--                'route' => ['cup.directResultPick','cup'=>$cup]--}}
{{--            ]) }}--}}
{{--                        {{dd($categories)}}--}}
{{--            {{ Form::select('category', $categories)}}--}}
{{--            {{ Form::submit('Find Entrants', ['class' => 'button btn btn-primary']) }}--}}
{{--            {{Form::close()}}--}}
{{--            <h2>Pick a winner from a list of entrants</h2>--}}
{{--            {{ Form::open([--}}
{{--                'route' => ['cup.directResultSetWinnerPerson','id'=>$cup->id]--}}
{{--            ]) }}--}}
{{--            {{ Form::select('person', $people)}}--}}
{{--            {{ Form::submit('Set Winner', ['class' => 'button btn btn-primary']) }}--}}
{{--            {{Form::close()}}--}}
        @endif
    @endif
@stop
