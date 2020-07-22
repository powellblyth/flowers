@extends('layouts.app', ['activePage' => 'add-Show', 'titlePage' => __('Add a Show')])
@section('pagetitle', 'Duplicate a Show')

@section('content')
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script defer="defer">

        $(function() {
            $( "#start_date" ).datetimepicker({
                // dateFormat: 'dd/mm/yyyy',
                dateFormat: 'd/m/Y',
                changeMonth: true,
                changeYear: true});
        });
    </script>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">Duplicate the show '{{ $show->name }}'</div>
                        <div class="card-body">
                            {{ Form::open([
                            'route' => 'shows.store'
                        ]) }}

                            <div class="row">
                                <div class="col-2"{{ Form::label('name', 'Name:', ['class' => 'control-label']) }}
                            </div>
                            <div class="col-4">
                                {{ Form::text('name', null, ['class' => 'form-control']) }}
                                @error('name')
                                <p class="error text-danger">{{ $errors->first('name') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-2">{{ Form::label('start_date', 'Start Date:', ['class' => 'control-label']) }}</div>
                            <div class="col-2">
                                {{ Form::datetime('start_date', $show->start_date, ['class' => 'form-control']) }}
                                @error('start_date')
                                <p class="error text-danger">{{ $errors->first('start_date') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-2">{{ Form::label('end_date', 'Ends Date:', ['class' => 'control-label']) }}</div>
                            <div class="col-2">
                                {{ Form::datetime('ends_date', $show->ends_date, ['class' => 'form-control']) }}
                                @error('ends_date')
                                <p class="error text-danger">{{ $errors->first('ends_date') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-2">{{ Form::label('end_date', 'Late Entry Deadline:', ['class' => 'control-label']) }}</div>
                            <div class="col-2">
                                {{ Form::datetime('late_entry_deadline', $show->late_entry_deadline, ['class' => 'form-control']) }}
                                @error('late_entry_deadline')
                                <p class="error text-danger">{{ $errors->first('late_entry_deadline') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-2">{{ Form::label('end_date', 'Entries Closed Deadline:', ['class' => 'control-label']) }}</div>
                            <div class="col-2">
                                {{ Form::datetime('entries_closed_deadline', $show->late_entry_deadline, ['class' => 'form-control']) }}
                                @error('entries_closed_deadline')
                                <p class="error text-danger">{{ $errors->first('entries_closed_deadline') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-2">{{ Form::label('max_age', 'Max Age:', ['class' => 'control-label']) }}</div>
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
                            {{ Form::submit('Create New Show', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection