@extends('layouts.app', ['activePage' => 'addentrant', 'titlePage' => __('Add an entrant')])
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
                        <div class="card-header card-header-success">Enter the Entrant's details</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"><p>Use this page to add yourself and your family. No need to
                                        enter the address each time, if you set it when you registered, you can check
                                        the "Use the User Account's Address" button below and we will just use that.</p>
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
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::checkbox('use_parent_address', 1) }} {{ Form::label('use_parent_address', 'Use the user account\'s address:', ['class' => 'control-label']) }}
                                    <br/><i>({{Auth::User()->getAddress()}})</i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <i><b>OR</b></i>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                                    {{ Form::text('address', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::label('address2', 'Address line 2:', ['class' => 'control-label']) }}
                                    {{ Form::text('address2', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::label('addresstown', 'Town / City:', ['class' => 'control-label']) }}
                                    {{ Form::text('addresstown', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::label('postcode', 'Postcode:', ['class' => 'control-label']) }}
                                    {{ Form::text('postcode', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::label('email', 'Email: (optional)', ['class' => 'control-label']) }}
                                    {{ Form::email('email', null, ['class' => 'form-control']) }}</td>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::label('telephone', 'Telephone:', ['class' => 'control-label']) }}
                                    {{ Form::text('telephone', null, ['class' => 'form-control']) }}</td>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p></p><b>GDPR! We would like your permission to retain your personal data within
                                        our data
                                        entry
                                        system for a period of 3 years after
                                        your last entry to the show. This includes your name, telephone number, email
                                        address,
                                        and
                                        age
                                        (children only).
                                    </b>
                                    <p>The reason to retain this is for the purposes of </p>
                                    <ol>
                                        <li>Making it faster for you to enter next year, as you would not need to
                                            provide your
                                            data
                                            again (unless it changed)
                                        </li>
                                        <li>Sending you reminders up to three times per year to remind you about the
                                            show, and
                                            invite
                                            you to our events.
                                        </li>
                                        <li> we will <i> NOT </i> share this data with any third parties, beyond
                                            communication
                                            systems
                                            under our control used to send the messages (e.g. email sending software).
                                        </li>
                                        <li>You can opt out of this at any time by emailing
                                            enquiries@petershamhorticulturalsociety.org.uk
                                        </li>
                                        <li>Please note that if you choose not to allow us to retain this information
                                            (which is
                                            fine!),
                                            we will irreversibly and irrevocably anonymise the data before the next
                                            show, and if
                                            that
                                            individual chooses to re-enter, you would need to re-create it.
                                        </li>
                                    </ol>
                                    <p>{{ Form::checkbox('can_retain_data', 1) }} {{ Form::label('can_retain_data', 'Check here to allow retain your information for future shows?:', ['class' => 'control-label']) }}</p>
                                    <p>{{ Form::checkbox('can_email', 1) }} {{ Form::label('can_email', 'Check here to allow us to contact you by email (up ot a few times a year)?:', ['class' => 'control-label']) }}</p>
                                    <p>{{ Form::checkbox('can_sms', 1) }} {{ Form::label('can_sms', 'Check here to allow us contact you by SMS (very infrequent)?:', ['class' => 'control-label']) }}</p>
                                    {{ Form::submit('Create New Entrant', ['class' => 'button btn btn-primary']) }}

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