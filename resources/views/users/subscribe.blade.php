@php
    $activePage = 'entrants';
    if ($thing->id <> Auth::User()->id){
    $activePage = 'families';
    }
@endphp
@extends('layouts.app', ['activePage' => $activePage, 'titlePage' =>  $thing->full_name ])

@section('pagetitle', 'Entrant ' . $thing->full_name)
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <p class="card-category">Membership Purchases</p>
                        <h3 class="card-title">&pound;{{number_format($membership_fee/100,2)}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            {{--                                <i class="material-icons">date_range</i> Last 24 Hours--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">list_alt</i>
                        </div>
                        <p class="card-category">Entries</p>
                        <h3 class="card-title"> &pound;{{number_format($entry_fee/100,2)}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            {{--                                <i class="material-icons">date_range</i> Last 24 Hours--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">euro_symbol</i>
                        </div>
                        <p class="card-category">Payments</p>
                        <h3 class="card-title">&pound;{{number_format($paid,2)}}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div
                        class="card-header @if((($entry_fee + $membership_fee)/100) - $paid > 0.01)card-header-danger @else  card-header-success @endif card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">info_outline</i>
                        </div>
                        <p class="card-category">Balance Due</p>
                        <h3 class="card-title">
                            &pound;{{number_format((($entry_fee + $membership_fee)/100) - $paid,2)}}</h3>
                    </div>
                    <div class="card-footer">
                        {{--                            <div class="stats">--}}
                        {{--                                <i class="material-icons">update</i> Just Updated--}}
                        {{--                            </div>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 text-right">
                        @can('edit', $thing)
                            <a href="{{route('user.edit', $thing)}}"
                               class="btn btn-primary">Edit {{ucfirst($thing->first_name)}}</a>
                        @endcan
                    </div>
                </div>
                <div class="card">
                    @if(Auth::check())
                        <div class="card-header card-header-success">
                            {{$thing->full_name}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <b>Member Number:</b> {{ $thing->getMemberNumber() }}
                                </div>
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <b>Address:</b> {{ $thing->address }}
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <b>Telephone:</b> {{ $thing->telephone }}
                                </div>
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <b>Email:</b> {{ $thing->email }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6  col-sm-12">Name:</b> {{ $thing->full_name }}</div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Family</div>
                    <div class="card-body">
                        @if (0 == count($thing->entrants))
                            <p>There are no family members configured yet. You must have configured at least one
                                family member before you can add any show entries</p>
                        @else
                            @foreach ($thing->entrants as $entrant)
                                <h4>{{$entrant->full_name}} <a href="{{route('entrants.show', $entrant->id)}}"><i
                                            class="material-icons">person</i> show</a> <a
                                        href="{{route('entrants.edit', $entrant->id)}}"><i
                                            class="material-icons">edit</i>
                                        edit</a></h4>
                                @php
                                    $entry_data = $entrant->entries()->where('year', env('CURRENT_YEAR'))->get();
                                    $totalFee = 0;
                                @endphp
                                @if (count($entry_data ) <= 0)
                                    <p>{{$entrant->first_name}} has not entered any categories yet</p>
                                @else
                                    @foreach ($entry_data as $entry)
                                        @php $totalFee += $entry->getActualPrice() @endphp
                                    @endforeach
                                    <p>{{count($entry_data)}}
                                        {{\Illuminate\Support\Str::plural('entry', count($entry_data))}}
                                        TOTAL:£{{number_format($totalFee/100, 2)}}</p>
                                    @foreach ($entry_data as $entry)

                                        {{--                                @foreach ($entry_data as $entry)--}}

                                        {{$entry->category->name}} ({{$entry['price']}}p)
                                        {{--                                        @if ($entry['is_late'])--}}
                                        {{--                                            (late)--}}

                                        {{--                                        @endif--}}
                                        {{--                                        @if ($entry['has_won'])--}}
                                        {{--                                            <b class="badge-success"><u>{{$entry['placement_name']}}</u></b>--}}
                                        {{--                                            (&pound;{{number_format($entry['winning_amount']/100,2)}})--}}
                                        {{--                                        @endif--}}
                                        <br/>
                                    @endforeach
                                    {{--                            @endif--}}
                                    {{--                                @endforeach--}}
                                @endif
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Payments</div>
                    <div class="card-body">
                        @if (count($payments) <= 0)
                            {{$thing->first_name}} has not made any payments yet
                        @else
                            @foreach ($payments as $payment)
                                <p>
                                    <b>&pound;{{number_format($payment->amount,2)}}</b> {{date_format($payment->created_at,'jS M Y')}}
                                </p>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Membership Purchases</div>
                    <div class="card-body">
                        @if (count($membership_purchases) <= 0)
                            {{$thing->first_name}} has not made any membership purchases yet
                        @else
                            @foreach ($membership_purchases as $purchase)
                                <p>
                                    {{ucfirst($purchase['type'])}} &pound;{{number_format($purchase['amount']/100,2)}}</p>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Your membership subscription</div>
                    <div class="card-body">
                        If you wish to subscribe, you must enter your card details, and our partner Stripe will
                        manage the annual renewal for us.

                    </div>
                </div>
            </div>
        </div>

        {{ Form::close() }}
        <div class="row">
            @if($isAdmin)

                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header-success">New Payment Record</div>
                        <div class="card-body">



                            {{ Form::hidden('user', $thing->id, ['class' => 'form-control']) }}
                            {{ Form::label('amount', 'Amount: &pound;', ['class' => 'control-label']) }}
                            {{ Form::text('amount', null, ['class' => 'form-control']) }}
                            {{Form::select('source', $payment_types, null, ['class' => 'form-control','style'=>'width:100px'])}}
                            <br/>
                            {{ Form::submit('Store Payment', ['class' => 'button btn btn-primary']) }}
                            <br/><br/><br/>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

            @endif
            @if($isAdmin)
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header-success">New Membership Purchase</div>
                        <div class="card-body">
                            <p>Note that your membership will not be processed until the money has been received</p>
                            {{ Form::open([ 'route' => 'membershippurchases.store' ]) }}

                            {{ Form::hidden('user', $thing->id, ['class' => 'form-control']) }}
                            {{ Form::label('type', 'Type:', ['class' => 'control-label']) }}
                            {{Form::select('type', $membership_types, null, ['class' => 'form-control','style'=>'width:100px'])}}
                            <br/>
                            {{ Form::submit('Purchase Membership', ['class' => 'button btn btn-primary']) }}
                            <br/><br/><br/>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
