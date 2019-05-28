@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('user.update', $user) }}" autocomplete="false" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit User') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                    <a href="{{ route('entrants.index') }}?user_id={{$user->id}}" class="btn btn-sm btn-primary">{{ __('See all Family Members') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('First name') }}</label>
                  <div class="col-sm-8 col-md-3 col-lg-3">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input autocomplete="new-user-details" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="firstname" id="input-first-name" type="text" placeholder="{{ __('First name') }}" value="{{ old('firstname', $user->firstname) }}" required="true" aria-required="true"/>
                      @if ($errors->has('firstname'))
                        <span id="name-error" class="error text-danger" for="input-first-name">{{ $errors->first('firstname') }}</span>
                      @endif
                    </div>
                  </div>
                  <label class="col-sm-2 col-form-label text-right">{{ __('Family Name') }}</label>
                  <div class="col-sm-8 col-md-3 col-lg-3">
                    <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                      <input autocomplete="new-user-details" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" id="input-last-name" type="text" placeholder="{{ __('Last name') }}" value="{{ old('lastname', $user->lastname) }}" required="true" aria-required="true"/>
                      @if ($errors->has('lastname'))
                        <span id="name-error" class="error text-danger" for="input-last-name">{{ $errors->first('lastname') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                      <input autocomplete="new-user-address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address" type="text" placeholder="{{ __('Address') }}" value="{{ old('address', $user->address) }}"  />
                      @if ($errors->has('address'))
                        <span id="email-address2" class="error text-danger" for="input-address">{{ $errors->first('address') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Address Line 2') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('address2') ? ' has-danger' : '' }}">
                      <input autocomplete="new-user-details" class="form-control{{ $errors->has('address2') ? ' is-invalid' : '' }}" name="address2" id="input-address2" type="text" placeholder="{{ __('Address Line 2') }}" value="{{ old('address2', $user->address2) }}"  />
                      @if ($errors->has('address2'))
                        <span id="address2-error" class="error text-danger" for="input-address2">{{ $errors->first('address2') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Town / City') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('addresstown') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('addresstown') ? ' is-invalid' : '' }}" name="addresstown" id="input-addresstown" type="text" placeholder="{{ __('Town / City') }}" value="{{ old('addresstown', $user->addresstown) }}"  />
                      @if ($errors->has('addresstown'))
                        <span id="town-error" class="error text-danger" for="input-town">{{ $errors->first('addresstown') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Post Code') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('postcode') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" name="postcode" id="input-postcode" type="text" placeholder="{{ __('Post Code') }}" value="{{ old('postcode', $user->postcode) }}"  />
                      @if ($errors->has('postcode'))
                        <span id="postcode-error" class="error text-danger" for="input-postcode">{{ $errors->first('postcode') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', $user->email) }}"  />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Telephone') }}</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('telephone') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" id="input-telephone" type="text" placeholder="{{ __('Telephone') }}" value="{{ old('telephone', $user->telephone) }}"  />
                      @if ($errors->has('telephone'))
                        <span id="telephone-error" class="error text-danger" for="input-telephone">{{ $errors->first('telephone') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
{{--                NOTE That password is removed here because it triggers autocomplete--}}
{{--                <div class="row">--}}
{{--                  <label class="col-sm-2 col-form-label" for="input-password">{{ __(' Password') }}</label>--}}
{{--                  <div class="col-sm-8">--}}
{{--                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">--}}
{{--                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="password" name="password" id="input-password" placeholder="{{ __('Password') }}" />--}}
{{--                      @if ($errors->has('password'))--}}
{{--                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('password') }}</span>--}}
{{--                      @endif--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>--}}
{{--                  <div class="col-sm-8">--}}
{{--                    <div class="form-group">--}}
{{--                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm Password') }}" />--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('GDPR') }}</label>
                  <div class="col-sm-8">
                    {!! $privacyContent !!}
                    <p>{{ Form::checkbox('can_retain_data', 1, old('can_retain_data', $user->can_retain_data)) }} {{ Form::label('can_retain_data', 'Check here to allow retain your information for future shows?:', ['class' => 'control-label']) }}</p>
                    <p>{{ Form::checkbox('can_email', 1, old('can_email', $user->can_email)) }} {{ Form::label('can_email', 'Check here to allow us to contact you by email (occasionally)?:', ['class' => 'control-label']) }}</p>
                    <p>{{ Form::checkbox('can_sms', 1, old('can_sms', $user->can_sms)) }} {{ Form::label('can_sms', 'Check here to allow us contact you by SMS (very infrequent)?:', ['class' => 'control-label']) }}</p>
                    <p>{{ Form::checkbox('can_post', 1, old('can_post', $user->can_post)) }} {{ Form::label('can_post', 'Check here to allow us contact you by mail (occasionally)?:', ['class' => 'control-label']) }}</p>

                  </div>
                </div>

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection