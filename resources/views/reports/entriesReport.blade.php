@extends('layouts.app', ['activePage' => 'reports', 'titlePage' => __('Entries Purchased')])
@section('content')
    <br/>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                {{__('Reports')}}
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                            <tr>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Paid</th>
                                                <th>Late?</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($purchases as $purchase)
                                                <td>{{$purchase['created']}}</td>
                                                <td>
                                                    <a href="/entrants/{{$purchase['entrant_id']}}">{{$purchase['entrant_name']}}</a>
                                                </td>
                                                <td>{{$purchase['type']}}</td>
                                                <td>{{$purchase['amount']}}p</td>
                                                <td>{{(($purchase['is_late'])? 'Yes':'No')}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <Table>
                                            <tr>
                                                <th>Totals</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            <tr>
                                                <th>Adult Entries</th>
                                                <td>{{$totals['count_adult']}}
                                                    (&pound;{{number_format($totals['amount_adult']/100, 2)}})
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Child Entries</th>
                                                <td>{{$totals['count_child']}}
                                                    (&pound;{{number_format($totals['amount_child']/100, 2)}})
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <hr/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ALL Entries</th>
                                                <td>{{$totals['count']}}
                                                    (&pound;{{number_format($totals['amount']/100, 2)}})
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Entrants</th>
                                                <td>{{$totals['count_entrants']}}

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <hr/>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
