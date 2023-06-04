<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Membership Benefits') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Membership Benefits') }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <p>
        @lang('Membership of the Horti costs only £:familyCost per year per family, or £:individualCost per year for individuals, and comes with many benefits including:',
[
    'familyCost'=> number_format(\App\Http\Controllers\MembershipPurchaseController::getAmount('family')/100, 2),
    'individualCost'=>number_format(\App\Http\Controllers\MembershipPurchaseController::getAmount('single')/100, 2),
    ]
    )
        </p>
        <ul class="list-disc pl-4 py-4">
            <li>@lang('Free entry to our annual show')</li>
            <li>@lang('Free admission to our talks throughout the year')</li>
            <li>@lang('Subsidised and free trips to places such as Gardens, Breweries')</li>
            <li>@lang('A chance to have your say in how the society is run through our AGM')</li>
            <li>@lang('A 10% discount at') <a href="https://palmcentre.co.uk/">The Palm Centre</a> </li>
            <li>@lang('A 10% discount at') <a href="https://petershamnurseries.com/">Petersham Nurseries</a> </li>
        </ul>
        <p>Simply <x-a href="{{route('register')}}">@lang('register an new account')</x-a> or <x-a href="{{route('login')}}">@lang('log in to our entry system')</x-a> to become a member online</p>
    </x-layout.intro-para>

</x-app-layout>
