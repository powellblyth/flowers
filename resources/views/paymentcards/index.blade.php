<x-app-layout>

    <x-slot name="header">
        <x-headers.h1>
            {{ __('Your Payment Cards') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.subscription-tabs active="paymentcards">
    </x-navigation.subscription-tabs>

    <x-layout.tabbed-intro-para>
        <p>This EXPERIMENTAL page shows the payment cards registered with Stripe</p>
    </x-layout.tabbed-intro-para>
    <x-layout.intro-para>
        <livewire:list-cards/>
    </x-layout.intro-para>
</x-app-layout>
