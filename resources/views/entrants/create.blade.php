@extends('layouts.app', ['activePage' => 'add-entrant', 'titlePage' => __('Add a Family Member')])
@section('pagetitle', 'New Entrant')

@section('content')

    <div class="content">
        {{ Form::open([
            'route' => 'entrants.store'
        ]) }}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">Enter the Family Member's details</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"><p>Use this page to add yourself and your family. No need to
                                        enter the address each time, as you set it when you registered</p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{ Form::label('firstname', 'First Name: * ', ['class' => 'control-label']) }}
                                    {{ Form::text('firstname', null, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{ Form::label('familyname', 'Family Name: *', ['class' => 'control-label']) }}
                                    {{ Form::text('familyname', Auth::User()->lastname, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{ Form::label('age', 'Age in years (Children only):', ['class' => 'control-label']) }}
                                    {{ Form::text('age', null, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{ Form::label('membernumber', 'Member Number (If you have one):', ['class' => 'control-label']) }}
                                    {{ Form::text('membernumber', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
{{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    {{ Form::checkbox('use_parent_address', 1) }} {{ Form::label('use_parent_address', 'Use the user account\'s address:', ['class' => 'control-label']) }}--}}
                            {{--                                    <br/><i>({{Auth::User()->getAddress()}})</i>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    <i><b>OR</b></i>--}}

                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}--}}
                            {{--                                    {{ Form::text('address', null, ['class' => 'form-control']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    {{ Form::label('address2', 'Address line 2:', ['class' => 'control-label']) }}--}}
                            {{--                                    {{ Form::text('address2', null, ['class' => 'form-control']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    {{ Form::label('addresstown', 'Town / City:', ['class' => 'control-label']) }}--}}
                            {{--                                    {{ Form::text('addresstown', null, ['class' => 'form-control']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    {{ Form::label('postcode', 'Postcode:', ['class' => 'control-label']) }}--}}
                            {{--                                    {{ Form::text('postcode', null, ['class' => 'form-control']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-12">--}}
                            {{--                                    {{ Form::label('email', 'Email: (optional)', ['class' => 'control-label']) }}--}}
                            {{--                                    {{ Form::email('email', null, ['class' => 'form-control']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            @if($isAdmin)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                {{ Form::label('user_id', 'Family Manager:', ['class' => 'control-label']) }}
                                                                {{ Form::select('user_id', $allUsers, old('user_id', (int)$indicatedAdmin), ['class' => 'form-control']) }}
                                                            </div>
                                                        </div>
                            @endif
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                {!! $privacyContent !!}
                                                                <p>{{ Form::checkbox('can_retain_data', 1) }} {{ Form::label('can_retain_data', 'Check here to allow retain your information for future shows?:', ['class' => 'control-label']) }}</p>
{{--                                                                <p>{{ Form::checkbox('can_email', 1) }} {{ Form::label('can_email', 'Check here to allow us to contact you by email (up ot a few times a year)?:', ['class' => 'control-label']) }}</p>--}}
{{--                                                                <p>{{ Form::checkbox('can_sms', 1) }} {{ Form::label('can_sms', 'Check here to allow us contact you by SMS (very infrequent)?:', ['class' => 'control-label']) }}</p>--}}
                                                                {{ Form::submit('Create New Member', ['class' => 'button btn btn-primary']) }}

                                                            </div>

                                                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>


@stop