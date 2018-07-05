@extends('layouts/main')
@section('pagetitle', 'Memberships Purchased'))
@section('content')
<a href="{{route('reports.index')}}">&laquo; Reports</a>
<br />
<table>
    <thead>    <tr>
        <th>Date</th><th>Name</th><th>Type</th><th>Paid</th><th>Address</th><th>Phone</th><th>Email</th><th>email opt in</th>
</tr>
    </thead>
    <Ttody>
    @foreach ($purchases as $purchase)
    <td>{{$purchase['created']}}</td><td><a href="/entrants/{{$purchase['entrant_id']}}">{{$purchase['entrant_name']}}</a></td><td>{{$purchase['type']}}</td>
        <td>{{$purchase['amount']}}p</td><td>{{$purchase['entrant_address']}}</td><td>{{$purchase['entrant_telephone']}}</td><td>{{$purchase['entrant_email']}}</td><td>{{$purchase['entrant_can_email']}}</td>
</tr>
@endforeach
</tbody>
</table><Table>
    <tr><th>Totals</th><th>&nbsp;</th>
    </tr>
    <tr><th>Family Purchases</th><td>{{$totals['count_family']}} (&pound;{{number_format($totals['amount_family']/100, 2)}})</td></tr>
    <tr><th>Single Purchases</th><td>{{$totals['count_single']}} (&pound;{{number_format($totals['amount_single']/100, 2)}})</td></tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr><th>ALL Purchases</th><td>{{$totals['count']}} (&pound;{{number_format($totals['amount']/100, 2)}})</td></tr>
    <tr><td colspan="2"><hr /></td></tr>
</tfoot>
</table>


@stop
