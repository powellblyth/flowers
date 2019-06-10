@extends('layouts.app', ['activePage' => 'entrants', 'titlePage' =>  $thing->getName() ])

@section('pagetitle', 'Entrant ' . $thing->getName())
@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
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
                                <i class="material-icons">local_offer</i> {{count($entries)}} entries
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-12 text-right">
                            @if (Auth::User()->isAdmin())
                                <a href="{{route('entrant.print', $thing)}}" target="_blank"
                                   class="btn btn-primary">Print Cards</a>
                            @endif
                            <a href="{{route('entrants.edit', $thing)}}"
                               class="btn btn-primary">Edit {{ucfirst($thing->firstname)}}</a>
                            @if ($thing->user)
                                <a href="{{route('user.show', $thing->user)}}"
                                   class="btn btn-primary">Show Family Manager</a>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        @if(Auth::check())
                            <div class="card-header card-header-success">
                                {{$thing->getName()}}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <b>Entrant Number: {{ $thing->getEntrantNumber() }}</b>
                                    </div>
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <b>Member Number:</b> {{ $member_number }}
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-12">Name:</b> {{ $thing->getName() }}</div>
                                    @if(!is_null($thing->age))
                                        <div class="col-lg-6 col-md-6  col-sm-12">Age:</b> {{ $thing->age }}</div>
                                    @endif

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-12">Family Manager:</b>
                                        @if(!is_null($thing->user))
                                            <a href="{{$thing->user->getUrl()}}">{{ $thing->user->getName() }}</a>
                                        @else
                                            None Set
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header-success">Entries</div>
                        <div class="card-body">
                            @if (count($entry_data ) <= 0)
                                {{$thing->firstname}} has not entered any categories yet
                            @else
                                @foreach ($entry_data as $entry)

                                    {{$entry['name']}} ({{$entry['price']}}p)
                                    @if ($entry['is_late'])
                                        (late)

                                    @endif
                                    @if ($entry['has_won'])
                                        <b class="badge-success"><u>{{$entry['placement_name']}}</u></b>
                                        (&pound;{{number_format($entry['winning_amount']/100,2)}})
                                    @endif
                                    <br/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                {{--<h2>Opt-in</h2>--}}
                {{--{{  Form::model($thing, array('route' => array('entrants.optins', $thing->id))) }}--}}
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

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header-success">Create New Entries</div>
                            <div class="card-body">
                                <p>Choose the categories you wish to add entries for below</p>

                                {{ Form::open([
                                    'route' => 'entry.creates'
                                ]) }}
                                <div class="row">

                                    {{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}

                                    @for ($i = 0; $i < 40; $i++)
                                        <div class="col-sm-3 col-md-2 col-lg-1">{{ Form::select('categories[]', $categories, null, ['class' => 'form-control','style'=>'width:100px']) }}</div>
                                    @endfor
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br/>
                                        {{ Form::submit('Create Entry', ['class' => 'button btn btn-primary']) }}
                                    </div>
                                </div>
                                {{ Form::close() }}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($isAdmin)

                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header-success">New Payment Record</div>
                                <div class="card-body">


                                    {{ Form::open([
                                        'route' => 'payments.store'
                                    ]) }}

                                    {{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}
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
                                    <p>Note that your membership will not be processed until the money has been
                                        received</p>
                                    {{ Form::open([
                                        'route' => 'membershippurchases.store'
                                    ]) }}

                                    {{ Form::hidden('entrant', $thing->id, ['class' => 'form-control']) }}
                                    {{ Form::hidden('user', $thing->user_id, ['class' => 'form-control']) }}
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
        </div>
    </div>
@stop