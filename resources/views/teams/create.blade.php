@extends('layouts.app', ['activePage' => 'add-team', 'titlePage' => __('Add a Team')])
@section('pagetitle', 'New Team')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">Create the Team</div>
                        <div class="card-body">
                            {{ Form::open([
                            'route' => 'teams.store'
                        ]) }}

                            <div class="row">
                                <div class="col-6"{{ Form::label('name', 'Name:', ['class' => 'control-label']) }}
                                </div>
                                <div class="col-6">
                                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    @error('name')
                                    <p class="error text-danger">{{ $errors->first('name') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="col-6">{{ Form::label('minm_age', 'Min Age:', ['class' => 'control-label']) }}</div>
                                <div class="col-6">
                                    {{ Form::text('min_age', null, ['class' => 'form-control']) }}
                                    @error('min_age')
                                    <p class="error text-danger">{{ $errors->first('min_age') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="col-6">{{ Form::label('max_age', 'Max Age:', ['class' => 'control-label']) }}</div>
                                <div class="col-6">
                                    {{ Form::text('max_age', null, ['class' => 'form-control']) }}
                                    @error('max_age')
                                    <p class="error text-danger">{{ $errors->first('max_age') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ Form::submit('Create New Team', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection