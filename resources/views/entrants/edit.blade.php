@extends('layouts.app', ['activePage' =>'entrants', 'titlePage' => 'Edit ' . $thing->getName()])

@section('pagetitle', 'Edit ' . $thing->getName())
@section('content')



    <div class="content">
        {{  Form::model($thing, array('route' => array('entrants.update', $thing->id))) }}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-header card-header-success">{{__('Family Members')}}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    {{ Form::label('firstname', 'First Name:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-7">
                                    {{ Form::text('firstname', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    {{ Form::label('familyname', 'Family Name:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-7">
                                    {{ Form::text('familyname', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    {{ Form::label('membernumber', 'Member Number:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-7">
                                    {{ Form::text('membernumber', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    {{ Form::label('age', 'Age (Children):', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-7">
                                    {{ Form::text('age', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    {{ Form::label('firstname', 'First Name:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-7">
                                    {{ Form::text('firstname', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {!!  $privacyContent  !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{ Form::checkbox('can_retain_data', 1) }} {{ Form::label('can_retain_data', 'Can we retain your data?:', ['class' => 'control-label']) }}
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{ Form::checkbox('can_email', 1) }} {{ Form::label('can_email', 'Can we contact you by email?:', ['class' => 'control-label']) }}
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{ Form::checkbox('can_sms', 1) }} {{ Form::label('can_sms', 'Can we contact you by Text Message (SMS)?:', ['class' => 'control-label']) }}
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{ Form::checkbox('can_post', 1) }} {{ Form::label('can_post', 'Can we contact you by Post?:', ['class' => 'control-label']) }}
                                </div>

                            </div>
                            {{ Form::submit('Save Family Member', ['class' => 'button btn btn-primary']) }}

                        </div>
                    </div>
                </div>
            </div>
        </div>{{ Form::close() }}
    </div>




@stop