@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Material Dashboard')])

@section('content')
    <div class="container" style="height: auto;">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="card card-login card-hidden mb-3">
                        <div class="card-header card-header-primary text-center">
                            <h4 class="card-title"><strong>{{ __('Register') }}</strong></h4>
                            {{--            <div class="social-line">--}}
                            {{--              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">--}}
                            {{--                <i class="fa fa-facebook-square"></i>--}}
                            {{--              </a>--}}
                            {{--              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">--}}
                            {{--                <i class="fa fa-twitter"></i>--}}
                            {{--              </a>--}}
                            {{--              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">--}}
                            {{--                <i class="fa fa-google-plus"></i>--}}
                            {{--              </a>--}}
                            {{--            </div>--}}
                        </div>
                        <div class="card-body ">
                            {{--            <p class="card-description text-center">{{ __('Or Be Classical') }}</p>--}}
                            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">face</i>
                                        </span>
                                    </div>
                                    <input type="text" name="firstname" class="form-control"
                                           placeholder="{{ __('First Name...') }}" value="{{ old('firstname') }}"
                                           required>
                                    <input type="text" name="lastname" class="form-control"
                                           placeholder="{{ __('Last Name...') }}" value="{{ old('lastname') }}"
                                           required>
                                </div>
                                @if ($errors->has('name'))
                                    <div id="name-error" class="error text-danger pl-3" for="name"
                                         style="display: block;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" class="form-control"
                                           placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <div id="email-error" class="error text-danger pl-3" for="email"
                                         style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('address') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">home</i>
                                        </span>
                                    </div>
                                    <input type="text" name="address" class="form-control"
                                           placeholder="{{ __('Address line 1...') }}" value="{{ old('address') }}">
                                </div>
                                @if ($errors->has('address'))
                                    <div id="email-error" class="error text-danger pl-3" for="address"
                                         style="display: block;">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('address2') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">home</i>
                                        </span>
                                    </div>
                                    <input type="text" name="address2" class="form-control"
                                           placeholder="{{ __('Address line 2...') }}" value="{{ old('address2') }}">
                                </div>
                                @if ($errors->has('address2'))
                                    <div id="email-error" class="error text-danger pl-3" for="address2"
                                         style="display: block;">
                                        <strong>{{ $errors->first('address2') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('addresstown') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">home</i>
                                        </span>
                                    </div>
                                    <input type="text" name="addresstown" class="form-control"
                                           placeholder="{{ __('Town / City...') }}" value="{{ old('addresstown') }}"
                                           required>
                                </div>
                                @if ($errors->has('addresstown'))
                                    <div id="email-error" class="error text-danger pl-3" for="address"
                                         style="display: block;">
                                        <strong>{{ $errors->first('addresstown') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('postcode') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">home</i>
                                        </span>
                                    </div>
                                    <input type="text" name="postcode" class="form-control"
                                           placeholder="{{ __('Postcode') }}" value="{{ old('postcode') }}"
                                           required>
                                </div>
                                @if ($errors->has('postcode'))
                                    <div id="email-error" class="error text-danger pl-3" for="address"
                                         style="display: block;">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="{{ __('Password...') }}" required>
                                </div>
                                @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger pl-3" for="password"
                                         style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control" placeholder="{{ __('Confirm Password...') }}" required>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <div id="password_confirmation-error" class="error text-danger pl-3"
                                         for="password_confirmation" style="display: block;">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="policy"
                                           name="policy" {{ old('policy', 1) ? 'checked' : '' }} >
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    {{ __('I agree with the ') }} <a href="#">{{ __('Privacy Policy') }}</a>
                                </label>
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="policy"
                                           name="can_retain_data" {{ old('can_retain_data', 0) ? 'checked' : '' }} >
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    {{ __('You may retain my data for up to 3 years after I last enter the show or am a member') }}
                                </label>
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="policy"
                                           name="email_opt_in" {{ old('policy', 0) ? 'checked' : '' }} >
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    {{ __('You may send me emails (no more than a few times per year') }}
                                </label>
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="policy"
                                           name="can_sms" {{ old('can_sms', 0) ? 'checked' : '' }} >
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                    {{ __('You may send me SMS (infrequently)') }}
                                </label>
                            </div>
                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit"
                                    class="btn btn-primary btn-link btn-lg">{{ __('Create account') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
