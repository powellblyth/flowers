@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('PHS Entries')])

@section('content')
  <div class="row align-items-center">
    <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
      <h3>{{ __('Sign in to create your entries and buy membership for the PHS Summer show') }} </h3>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Sign in') }}</strong></h4>
            <div class="social-line"><!-- https://www.flickr.com/photos/cobaltfish/7712882294/in/photolist-cKyxcd-7ZqZmB-hdwiKp-23FSRti-c6eZJ1-dFgLkM-pFLie6-nHnDoY-nwWvJS-JhPcAe-cT1Jrw-BRizqo-den1HT-bVAnDB-22QR8oU-dmXnmJ-6RVth3-cT1oPd-hu21Qc-c2cT75-nsZ4At-nsUGXJ-Y3122v-25VhmNn-hdwmL5-EcQc8B-c35YJE-nt4Fic-Ywdk6o-bVAgn6-dFnbmE-aQ5PA2-bVAunB-c38FHJ-bXgtKY-fvRB5a-nK9yz9-demXMz-c35Vy3-demcrP-ccXCXq-2ayLTap-c9uPTw-nwVjFH-nRcrz6-hdvXHQ-ayL4Kd-demcLS-c76DXE-bVAmMa -->
{{--              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">--}}
{{--                <i class="fa fa-facebook-square"></i>--}}
{{--              </a>--}}
{{--              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">--}}
{{--                <i class="fa fa-twitter"></i>--}}
{{--              </a>--}}
            </div>
          </div>
          <div class="card-body">
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
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
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" value="{{ !$errors->has('password') ? "secret" : "" }}" required>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="form-check mr-auto ml-3 mt-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
              </label>
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Lets Go') }}</button>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-light">
                    <small>{{ __('Forgot password?') }}</small>
                </a>
            @endif
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('register') }}" class="text-light">
                <small>{{ __('Create new account') }}</small>
            </a>
        </div>
      </div>
    </div>
  </div>
@endsection
