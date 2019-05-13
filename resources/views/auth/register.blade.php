@extends('layouts/main')
@section('pagetitle', 'Register a new account')
@section('registerNavHighlight', 'active')
@section('content')
    <!-- resources/views/auth/register.blade.php -->
    @if ($errors->any())
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 mx-auto text-center">
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 mx-auto text-center">
                    @foreach (['danger', 'warning', 'success', 'info'] as $key)
                        @if(Session::has($key))
                            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Register your details</h4>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'register']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('firstname', 'First Name *', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::text('firstname', old('firstname'), ['class' => 'form-control']) }}

                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('lastname', 'Last Name *', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::text('lastname', old('lastname'), ['class' => 'form-control']) }}

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::label('email', 'Email Address *', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::email('email', old('email'), ['class' => 'form-control']) }}

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('password', 'Password *', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::password('password', ['class' => 'form-control']) }}

                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('password_confirmation', 'Password Confirmation *', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                                {{ Form::text('address', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('address2', 'Address line 2:', ['class' => 'control-label']) }}
                                {{ Form::text('address2', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('addresstown', 'Town / City:', ['class' => 'control-label']) }}
                                {{ Form::text('addresstown', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('postcode', 'Postcode:', ['class' => 'control-label']) }}
                                {{ Form::text('postcode', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('telephone', 'Telephone:', ['class' => 'control-label']) }}
                                {{ Form::text('telephone', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <b>We would like permission to retain your personal data within our data entry system for a period of 3 years after
                                        your last entry to the show. This includes your name, telephone number, email address, and age (children only).<br />
                                        The reason to retain this is for the purposes of <br />
                                        <ol>
                                            <li>Making it faster for you to enter next year, as you would not need to provide your data again (unless it changed)</li>
                                            <li>Sending you reminders up to three times per year to remind you about the show, and invite you to our events.</li>
                                            <li>We will <i> NOT </i> share this data with any third parties, beyond communication systems under our control used to send the messages (e.g. email sending software).</li>
                                            <li>You can opt out of this at any time by emailing enquiries@petershamhorticulturalsociety.org.uk</li>
                                        </ol></b>                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('can_retain_data', 'Can we retain your data?:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-md-6">{{ Form::checkbox('can_retain_data', 1) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('can_email', 'Can we contact you by email?:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-md-6">{{ Form::checkbox('can_email', 1) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">{{ Form::label('can_sms', 'Can we contact you by SMS?:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-md-6">{{ Form::checkbox('can_sms', 1) }}
                                </div>
                            </div>

                            </div>
                            {{ Form::Submit('Register', ['class'=>'button btn btn-primary'])}}
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
