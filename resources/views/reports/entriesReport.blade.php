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
    <Ttody>
    @foreach ($purchases as $purchase)
    <td>{{$purchase['created']}}</td><td><a href="/entrants/{{$purchase['entrant_id']}}">{{$purchase['entrant_name']}}</a></td><td>{{$purchase['type']}}</td>
        <td>{{$purchase['amount']}}p</td>
        <td>{{(($purchase['is_late'])? 'Yes':'No')}}</td>
</tr>
@endforeach
</tbody>
</table><Table>
    <tr><th>Totals</th><th>&nbsp;</th>
    </tr>
    <tr><th>Adult Entries</th><td>{{$totals['count_adult']}} (&pound;{{number_format($totals['amount_adult']/100, 2)}})</td></tr>
    <tr><th>Child Entries</th><td>{{$totals['count_child']}} (&pound;{{number_format($totals['amount_child']/100, 2)}})</td></tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr><th>ALL Entries</th><td>{{$totals['count']}} (&pound;{{number_format($totals['amount']/100, 2)}})</td></tr>
    <tr><td colspan="2"><hr /></td></tr>
</tfoot>
</table>


@stop
