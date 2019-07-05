<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('pagetitle') @ PHS</title>
        <link rel="icon" href="/images/favicon.ico" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
         <link rel="stylesheet" href="{{ url('/css/main.css') }}" />
        @yield('extra_head')


    </head>
    <body>
        <div class="flex-top position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                    <a href="{{route('logout')}}"
                       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();return false">
                        Sign out
                    </a>
{{--                        <a href="{{ url('/') }}">Home</a>--}}
{{--                    @else--}}
{{--                        <a href="{{ url('/login') }}">Login</a>--}}
{{--                        <a href="{{ url('/register') }}">Register</a>--}}
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    @yield('pagetitle')

                </div>
                <div class="subtitle m-b-md">
                    @yield('pagesubtitle')

                </div>

                <div class="links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
    @if(Auth::User()->isAdmin())
                    <a href="{{route('entrants.searchall')}}">All Entrants</a>
    @endif
                        <a href="{{route('entrants.index')}}">Entrants</a>
                        <a href="{{route('entrants.create')}}">Add an entrant</a>
                    @else
                        <a href="{{ url('/login') }}">Sign in</a>
                        @if(config('app.state') !== 'locked')
                        <a href="{{ url('/register') }}">Register</a>
                            @endif
                    @endif
                    <a href="{{route('categories.index')}}">Categories / Results</a>
                    <a href="{{ url('/cups') }}">Cups</a>
                        @if(Auth::check() && Auth::User()->isAdmin())
                        <a href="{{ route('reports.index') }}">Reports</a>
                            @endif
                </div>
                <div id="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</html>
