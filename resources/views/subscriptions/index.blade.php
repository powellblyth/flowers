<x-app-layout>

    <x-slot name="header">
        <x-headers.h1>
            {{ __('Your Subscriptions') }}
        </x-headers.h1>
    </x-slot>
    <x-navigation.subscription-tabs active="subscriptions">
    </x-navigation.subscription-tabs>
    <x-layout.tabbed-intro-para>
        <p>
            This EXPERIMENTAL page shows the membership subscriptions you have with us, and the
            cards that are registered with Stripe
        </p>
    </x-layout.tabbed-intro-para>

    <x-layout.intro-para>
        <livewire:list-subscriptions-held/>
    </x-layout.intro-para>

    <x-layout.intro-para>
        <livewire:list-memberships/>
    </x-layout.intro-para>

</x-app-layout>
