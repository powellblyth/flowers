@extends('layouts/main')
@section('pagetitle', 'Cup ' . $cup->name . ' ' . $show->name)
@section('content')
    <a href="{{config('nova.path')}}/resources/cups">&laquo; Cups</a>
    <br/>
    <ul>
        <li>@lang('Name'): {{ $cup->name }}</li>
        <li>@lang('Show'): {{ $show->name }}</li>
        <li>@lang('Criteria'): {{ $cup->winning_criteria }}</li>
    </ul>

    @if ($cup->winning_basis === \App\Models\Cup::WINNING_BASIS_TOTAL_POINTS)
        <b>@lang('Linked to'): </b><br/>
        <table border>
            <tr>
                <th>@lang('Category')</th>
                <th>@lang('First')</th>
                <th>@lang('Second')</th>
                <th>@lang('Third')</th>
                <th>@lang('Commended')</th>
            </tr>


            @foreach ($categories as $category)
                <tr>
                    <td>{{$category->numbered_name}} <small>{{$category->notes}}</small></td>
                    @if (array_key_exists($category->id, $winners_by_category) && count($winners_by_category[$category->id]) > 0)
                        <td>
                            @if (array_key_exists('1', $winners_by_category[$category->id]))
                                {{$winners[$winners_by_category[$category->id]['1']['entrant']]->printable_name}}
                                ({{$winners_by_category[$category->id]['1']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (array_key_exists('2', $winners_by_category[$category->id]))
                                {{$winners[$winners_by_category[$category->id]['2']['entrant']]->printable_name}}
                                ({{$winners_by_category[$category->id]['2']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (array_key_exists('3', $winners_by_category[$category->id]))
                                {{$winners[$winners_by_category[$category->id]['3']['entrant']]->printable_name}}
                                ({{$winners_by_category[$category->id]['3']['points']}} points)
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (array_key_exists('commended', $winners_by_category[$category->id]))
                                {{$winners[$winners_by_category[$category->id]['commended']['entrant']]->printable_name}}
                                ({{$winners_by_category[$category->id]['commended']['points']}} points)
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
            <h2>Pick a winner from an entry</h2>
            {{ Form::open([
                'route' => ['cup.directResultPick','id'=>$cup]
            ]) }}
{{--                        {{dd($categories)}}--}}
            {{ Form::select('category', $categories->pluck('numbered_name', 'id'))}}
            {{ Form::submit('Find Entrants', ['class' => 'button btn btn-primary']) }}
            {{Form::close()}}
            <h2>Pick a winner from a list of entrants</h2>
            {{ Form::open([
                'route' => ['cup.directResultSetWinner','id'=>$cup->id]
            ]) }}
            {{ Form::select('person', $people)}}
            {{ Form::submit('Set Winner', ['class' => 'button btn btn-primary']) }}
            {{Form::close()}}
        @endcan
    @endif
@stop
