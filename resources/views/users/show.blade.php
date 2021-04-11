@php
    $activePage = 'entrants';
@endphp
@extends('layouts.app', ['activePage' => $activePage, 'titlePage' => $user['name'] ])

@section('pagetitle', 'Entrant ' . $user['name'])
@section('content')
    <script src="https://js.stripe.com/v3/" type="text/javascript"></script>
    {{--@dump($user)--}}
    <div class="content">
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
                                {{--                                <i class="material-icons text-danger">warning</i>--}}
                                {{--                                <a href="{{route('entrants.create')}}">Add another</a>--}}
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
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                Your PHS Account details
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <b>Family Member Number:</b> {{ $user['membernumber'] }}
                                    </div>
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <b>Address:</b> {{ $user['address'] }}
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <b>Telephone:</b> {{$user['telephone'] }}
                                    </div>
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <b>Email:</b> {{$user['email']}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-12"><b>Name:</b> {{ $user['name'] }}</div>
                                    <div class="col-lg-6 col-md-6  col-sm-12">
                                        <a class="btn btn-primary" href="{{ route('profile.edit') }}">
                                            Edit my account
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header-success">Payment Details</div>
                        <div class="card-body">
                            @if (!$needs_payment_method)
                                <div class="row">
                                    <div class="col-lg-4">
                                        @foreach ($payment_methods as $paymentMethod)
                                            {{$paymentMethod->id}}
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        We don't have card details stored for you at the moment. If you wish to pay for
                                        your purchases online (you don't have to), please enter a credit or debit card
                                        here.<br/>
                                        <small>Note that we don't store these details ourselves, but they are stored
                                            with
                                            our payment provider VERY securely</small>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:20px">
                                    <div class="col-lg-4">

                                    {{--                                            <a class="btn btn-primary" href="{{ route('profile.edit') }}">--}}

                                    <!-- Stripe Elements Placeholder -->
                                        <div id="card-element" style="padding:4px; background-color:#eee"></div>

                                        <div style="padding:4px; background-color:#eee">Card Holder Name
                                            <input id="card-holder-name" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <button class="btn btn-primary" id="card-button"
                                                data-secret="{{ $payment_intent->client_secret }}">
                                            Update Payment Method
                                        </button>
                                        {{--                                                Securely store your payment method{{$user->createSetupIntent()}}--}}
                                        {{--                                            </a>--}}

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Entrants</div>
                    <div class="card-body">
                        @forelse ($user['entrants'] as $entrant)
                            <h4>{{$entrant['name']}}
                                @if ($entrant['age'])
                                    (Age {{$entrant['age']}} years)
                                @endif
                                <a href="{{route('entrants.show', $entrant['id'])}}"
                                   class=" btn-primary btn btn-sm"><i
                                        class="material-icons">toc</i> Manage Entries</a>
                                    <a href="{{route('entrants.edit', $entrant['id'])}}" class="btn btn-sm"><i
                                            class="material-icons">edit</i> edit</a>
                            </h4>

                            @php
                                $entry_data = $entrant['entries'];
                                $totalFee = 0;
                            @endphp
                            @if (count($entry_data ) <= 0)
                                <p>{{$entrant->firstname}} has not entered any categories yet</p>
                            @else
                                @foreach ($entry_data as $entry)
                                    @php $totalFee += $entry->getActualPrice() @endphp
                                @endforeach
                                <p>{{count($entry_data)}}
                                    {{\Illuminate\Support\Str::plural('entry', count($entry_data))}}
                                    TOTAL:£{{number_format($totalFee/100, 2)}}</p>
                                @forelse ($entry_data as $entry)
                                    <p>
                                        {{$entry->category->getNumberedLabel()}} ({{$entry->getActualPrice()}}p)
                                    </p>
                                @empty
                                    <p>{{$entrant->firstname}} has not entered any categories yet</p>

                                @endforelse
                            @endif
                            <p>
                                @if($entrant['team'])
                                    A member of team {{$entrant['team']}}
                                @else
                                    @if($entrant['age'])
                                        Not yet a member of any team
                                    @endif
                                @endif
                            </p>

                            <hr/>
                        @empty
                            <p>There are no family members configured yet. You must have configured at least one
                                family member before you can add any show entries</p>

                        @endforelse

                            <a href="{{route('users.createentrant', ['user'=>$user['id']])}}"
                               class="btn btn-primary">Add
                                someone else</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Payments</div>
                    <div class="card-body">
                        <p>
                            @forelse ($payments as $payment)
                                <b>&pound;{{number_format($payment->amount,2)}}</b> {{$payment->created_at->format('jS M Y')}}
                            @empty
                                {{$user['firstname']}} has not made any payments yet
                            @endforelse
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header-success">Membership Purchases</div>
                    <div class="card-body">
                        <p>
                            @forelse ($user['membershipPurchases'] as $purchase)
                            {{ucfirst($purchase->membership->label)}} &pound;{{number_format($purchase['amount']/100,2)}}
                            @empty
                                {{$user['firstname']}} has not made any membership purchases yet
                            @endforelse
                        </p>

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

        {{--<h2>Opt-in</h2>--}}
        {{--{{  Form::model($user, array('route' => array('entrants.optins', $user['id']))) }}--}}
        {{--<table border="0">--}}
        {{--<tr>--}}
        {{--            <td colspan="3"><b>We would like permission to retain your personal data within our data entry system for a period of 3 years after--}}
        {{--            your last entry to the show. This includes your name, telephone number, email address, and age (children only).<br />--}}
        {{--            The reason to retain this is for the purposes of <br />--}}
        {{--            <ol>--}}
        {{--                <li>Making it faster for you to enter next year, as you would not need to provide your data again (unless it changed)</li>--}}
        {{--                <li>Sending you reminders up to three times per year to remind you about the show, and invite you to our events.</li>--}}
        {{--                <li> we will <i> NOT </i> share this data with any third parties, beyond communication systems under our control used to send the messages (e.g. email sending software).</li>--}}
        {{--                <li>You can opt out of this at any time by emailing enquiries@petershamhorticulturalsociety.org.uk</li>--}}
        {{--            </ol></b></td>--}}
        {{--        </tr>--}}
        {{--        <tr>--}}
        {{--            <td>{{ Form::label('can_retain_data', 'Can we retain your data?:', ['class' => 'control-label']) }}--}}
        {{--                {{ Form::checkbox('can_retain_data', 1, $can_retain_data) }}</td>--}}
        {{--            <td>{{ Form::label('can_email', 'Can we contact you by email?:', ['class' => 'control-label']) }}--}}
        {{--                {{ Form::checkbox('can_email', 1,$can_email) }}</td>--}}
        {{--            <td>{{ Form::label('can_sms', 'Can we contact you by SMS?:', ['class' => 'control-label']) }}--}}
        {{--                {{ Form::checkbox('can_sms', 1, $can_sms) }}</td>--}}
        {{--        </tr>--}}
        {{--</table>--}}
        {{--{{ Form::submit('Store Preferences', ['class' => 'button btn btn-primary']) }}--}}
        {{--{{ Form::close()}}--}}


        {{ Form::close() }}
        <div class="row">
            @if($isAdmin )

                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header-success">New Payment Record</div>
                        <div class="card-body">


                            {{ Form::open([
                                'route' => 'payments.store'
                            ]) }}

                            {{ Form::hidden('user', $user['id'], ['class' => 'form-control']) }}
                            {{ Form::label('amount', 'Amount: &pound;', ['class' => 'control-label']) }}
                            {{ Form::text('amount', null, ['class' => 'form-control']) }}
                            {{Form::select('source', $payment_types, null, ['class' => 'form-control','style'=>'width:100px'])}}
                            <br/>
                            {{ Form::submit('Store Payment', ['class' => 'button btn btn-primary']) }}

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

            @endif
            @if($isAdmin )
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header-success">New Membership Purchase</div>
                        <div class="card-body">
                            <p>Note that your membership will not be processed until the money has been received</p>
                            {{ Form::open([ 'route' => 'membershippurchases.store' ]) }}

                            {{ Form::hidden('user', $user['id']) }}

                            {{ Form::label('number', 'Number:', ['class' => 'control-label']) }}
                            {{ Form::text('number', null,['class' => 'form-control','style'=>'width:150px'])}}
                            <br/>
                            {{ Form::label('type', 'Type:', ['class' => 'control-label']) }}
                            {{ Form::select('type', $membership_types, null, ['class' => 'form-control','style'=>'width:150px'])}}
                            <br/>
                            {{ Form::submit('Purchase Membership', ['class' => 'button btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
    @if ($needs_payment_method)
        <script defer="defer">
            const stripe = Stripe('{{config('cashier.key')}}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            // alert(clientSecret);
            cardButton.addEventListener('click', async (e) => {
                const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                );

                if (error) {
                    alert(error.message)
                } else {
                    alert('succeeded')
                }
            });
        </script>
    @endif

@stop
