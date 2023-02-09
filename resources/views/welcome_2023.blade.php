<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('PHS Entries') }}</title>
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
    <div class="md:flex p-4 h-full">
        <div class="flex-none sm:w-full md:w-1/2 ">
            <div class="p-4">
                <x-headers.h1
                    class=" text-gray-700 text-center">{{ __('Welcome to the PHS Summer Show entry system.') }}</x-headers.h1>
                <p class="my-4">This system allows you to manage your entries to the Petersham Flower Show and you can
                    manage your membership for you and your family.</p>
                <p>Petersham Horticultural Society was founded at the turn of the 20th Century. It is a not-for-profit
                    organisation which aims to encourage families living in Petersham to enjoy their gardens.</p>
                <p class="my-2"> The Annual Flower Show is our biggest event of the year, drawing crowds from far and
                    wide. We have a wide range of entrants from young to old, experienced to absolute novice.</p>
                @auth
                    <x-headers.h2 class="my-8">Go to <a class="underline" href="{{route('dashboard')}}">Your
                            Dashboard</a> to get started
                    </x-headers.h2>
                @endauth
                @guest
                    <x-headers.h3 class="my-4  ">@lang('Log in or register above to get started')</x-headers.h3>
                @endguest
            </div>
        </div>
        <div class="flex-none h-80  sm:w-full md:w-1/2 rounded-md    "
             style="background-image: url('/images/hero/homepage-2023.jpg'); ">
            &nbsp;
        </div>
    </div>
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
                    <small>Image copyright David Parker-Woolway
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
