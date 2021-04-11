@extends('layouts.app', ['activePage' => 'reports', 'titlePage' => __('Memberships Purchased Report')])
@section('pagetitle', 'Reports')
@section('content')
    <br/>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($memberships as $membershipNavigator)
                    <div class="col-1">
                        <a href="{{route('reports.members')}}?membership_id={{$membershipNavigator->id}}">{{$membershipNavigator->label}}</a>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                {{$membership->label}}

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Paid</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Email opt in</th>
                                        </tr>
                                        </thead>
                                        <Tbody>
                                        @foreach ($purchases as $purchase)
                                            <td>{{$purchase->created_at->format('d M Y')}}</td>
                                            <td>
                                                @if($membership->isEntrant() )
                                                    <a href="{{route('entrants.show', ['entrant'=>$purchase->entrant])}}">{{$purchase->entrant->getName()}}</a>
                                                @else
                                                    <a href="{{route('users.show', ['user'=>$purchase->user])}}">{{$purchase->user->getname()}}</a>
                                                @endif
                                            </td>

                                            <td>{{$purchase->number}}</td>
                                            <td>£{{$purchase->amount / 100}}</td>
                                            <td>{{$purchase->user->getAddress()}}</td>
                                            <td>{{$purchase->user->telephone}}</td>
                                            <td>{{$purchase->user->email}}</td>
                                            <td>{{$purchase->user->can_email}}</td>
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
                                            <th>Purchases
                                            </th>
                                            <td>{{$totals['count']}}
                                                (&pound;{{number_format($totals['amount']/100, 2)}})
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


@stop
