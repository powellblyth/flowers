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
                    @auth()
                        <a href="{{ url(route('dashboard')) }}">Dashboard</a>
                    @endauth()
                    @guest()
                        <a href="{{ url('/login') }}">Log in</a>
                    @endif
                </div>
                <div id="content" class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</html>
