@extends('layouts.marketing_2023')
@section('content')
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
                    <x-headers.h3 class="my-4  "><h2><x-a href="{{route('login')}}">Log in</x-a> or <x-a href="{{route('register')}}">register</x-a> to get started</x-headers.h3>
                @endguest
            </div>
        </div>
        <div class="flex-none h-80  sm:w-full md:w-1/2 rounded-md    "
             style="background-image: url('/images/hero/homepage-2023.jpg'); ">
            &nbsp;
        </div>
    </div>
@endsection
