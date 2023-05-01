<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pagetitle', 'Petersham Horticultural Society Entries system')</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/images/favicon.ico">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->

    <link rel="stylesheet" href="{{ url('/css/app.css') }}"/>
    @livewireStyles
</head>
<body class="min-h-screen">
<div class="min-h-full">
    <div class="py-4 bg-white">
        @include('layouts.navigation')
    </div>

    @yield('content')

    <footer class="footer p-8 w-full">
        <nav class="container-fluid flex ">
            <ul class="flex flex-none">
                <li class="flex-none px-4">
                    <a href="https://horti.org.uk">
                        {{ __('PHS Home') }}
                    </a>
                </li>
                <li class="flex-none px-4">
                    <a href="https://horti.org.uk/about">
                        {{ __('About Us') }}
                    </a>
                </li>
            </ul>
            <div class="flex-auto  text-right px-4">
                <p>
                    <small>@lang('Image copyright David Parker-Woolway')
                        https://www.flickr.com/photos/oxfordweddingphotographer/</small>
                </p>
            </div>
            <div class="flex-none text-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>
            </div>
        </nav>
    </footer>
</div>

<!--   Core JS Files   -->
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
@livewireScripts
</body>
</html>
