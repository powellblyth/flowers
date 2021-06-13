@extends('layouts.oldapp', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('PHS SUMMER SHOW ENTRY MANAGEMENT')])

@section('content')
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                    <h1 class="text-white text-center">{{ __('Welcome to the PHS Summer Show entry system.') }}</h1>
                @auth()<h2>Go to <a style="color:white;text-decoration:underline" href="{{route('dashboard')}}">Your Dashboard</a> to get started</a></h2>@endguest
                @guest()<h2> Log in or register above to get started</h2>@endguest


            </div>
        </div>
@endsection
@section('extraFooter')
    <p>
        <small>Image copyright Andy Rogers https://www.flickr.com/photos/cobaltfish/7712882294</small>
    </p>
@endsection
