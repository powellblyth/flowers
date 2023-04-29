<x-app-layout>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Membership Benefits') }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <p>
        @lang('Membership of the Horti costs only £5 per year per family, or £3 per year for individuals, and comes with many benefits including:')
        </p>
        <ul class="list-disc pl-4 py-4">
            <li>Free entry to our annual show</li>
            <li>Free admission to our talks throughout the year</li>
            <li>Subsidised and free trips to places such as Gardens, Breweries</li>
            <li>A chance to have your say in how the society is run through our AGM</li>
            <li>A 10% discount at <a href="https://palmcentre.co.uk/">The Palm Centre</a> </li>
            <li>A 10% discount at <a href="https://petershamnurseries.com/">Petersham Nurseries</a> </li>
        </ul>
        <p>Simply <x-a href="{{route('register')}}">@lang('register an new account')</x-a> or <x-a href="{{route('login')}}">@lang('log in to our entry system')</x-a> to become a member online</p>
    </x-layout.intro-para>

</x-app-layout>
