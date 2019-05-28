@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => 404])




@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading ">404 - Error</h2>
            <hr class="light">
            <p class="text-faded">404 means that we are sorry, but the thing you are trying to find can't be found. Please either retype your address, or contact us if you think it's our fault</p>
            
            @if (Auth::guest())
            <a class="btn btn-default btn-xl js-scroll-trigger" href="/">Back to homepage</a>
            @else
            <a class="btn btn-default btn-xl js-scroll-trigger" href="/home">Back to dashboard</a>
            @endif
            <br />
          </div>
        </div>
      </div>
    </div></div>
      
@endsection
