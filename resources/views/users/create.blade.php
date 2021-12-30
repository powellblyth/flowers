@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Family Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
        @if (session('status'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            </div>
        @endif
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('users.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add a Family') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <p>PLEASE ensure you add an email address _or_ a postal address</p>
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('First Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" id="input-first_name" type="text" placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}" required="true" aria-required="true"/>
                      @if ($errors->has('first_name'))
                        <span id="first_name-error" class="error text-danger" for="input-first_name">{{ $errors->first('first_name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Last Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" id="input-last_name" type="text" placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required="true" aria-required="true"/>
                      @if ($errors->has('last_name'))
                        <span id="last_name-error" class="error text-danger" for="input-last_name">{{ $errors->first('last_name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-email">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}"  />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-address">{{ __('Address') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('address_1') ? ' has-danger' : '' }}">
                      <input autocomplete="new-user-address" class="form-control{{ $errors->has('address_1') ? ' is-invalid' : '' }}" name="address" id="input-address" type="text" placeholder="{{ __('address_1') }}" value="{{ old('address_1') }}"  />
                      @if ($errors->has('address_1'))
                        <span id="address-error" class="error text-danger" for="input-address">{{ $errors->first('address_1') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-address_2">{{ __('Address Line 2') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('address_2') ? ' has-danger' : '' }}">
                      <input autocomplete="new-user-details" class="form-control{{ $errors->has('address_2') ? ' is-invalid' : '' }}" name="address_2" id="input-address_2" type="text" placeholder="{{ __('Address Line 2') }}" value="{{ old('address_2') }}"  />
                      @if ($errors->has('address_2'))
                        <span id="address_2-error" class="error text-danger" for="input-address_2">{{ $errors->first('address_2') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="address_town">{{ __('Town / City') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('address_town') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('address_town') ? ' is-invalid' : '' }}" name="address_town" id="input-address_town" type="text" placeholder="{{ __('Town / City') }}" value="{{ old('address_town') }}"  />
                      @if ($errors->has('address_town'))
                        <span id="town-error" class="error text-danger" for="input-town">{{ $errors->first('address_town') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="postcode">{{ __('Post Code') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('postcode') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" name="postcode" id="input-postcode" type="text" placeholder="{{ __('Post Code') }}" value="{{ old('postcode') }}"  />
                      @if ($errors->has('postcode'))
                        <span id="postcode-error" class="error text-danger" for="input-postcode">{{ $errors->first('postcode') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="telephone">{{ __('Telephone') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('telephone') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" id="input-telephone" type="text" placeholder="{{ __('Telephone') }}" value="{{ old('telephone') }}"  />
                      @if ($errors->has('telephone'))
                        <span id="telephone-error" class="error text-danger" for="input-telephone">{{ $errors->first('telephone') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('GDPR') }}</label>
                  <div class="col-sm-8">
                    {!! $privacyContent !!}
                    <p>{{ Form::checkbox('can_retain_data', 1, old('can_retain_data')) }} {{ Form::label('can_retain_data', 'Check here to allow retain your information for future shows?:', ['class' => 'control-label']) }}</p>
                    <p>{{ Form::checkbox('can_email', 1, old('can_email')) }} {{ Form::label('can_email', 'Check here to allow us to contact you by email (occasionally)?:', ['class' => 'control-label']) }}</p>
                    <p>{{ Form::checkbox('can_sms', 1, old('can_sms')) }} {{ Form::label('can_sms', 'Check here to allow us contact you by SMS (very infrequent)?:', ['class' => 'control-label']) }}</p>
                    <p>{{ Form::checkbox('can_post', 1, old('can_post')) }} {{ Form::label('can_post', 'Check here to allow us contact you by mail (occasionally)?:', ['class' => 'control-label']) }}</p>

                  </div>
                </div>

              <div class="card-footer p-2">
                  <div>
                <button type="submit" name="save" class="btn btn-primary">{{ __('Add Family and view') }}</button>
                <button type="submit" name="another" class="btn btn-primary">{{ __('Save then add another') }}</button>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
