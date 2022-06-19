<x-app-layout>

    <x-slot name="header">
        <x-headers.h1>
            {{ __('Your PHS Membership') }}
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
    @if(!empty($error))
        <x-layout.error>
                Error: {{$error}}
        </x-layout.error>
    @endif
    @if(!empty($message))
        <x-layout.message>
                {{$message}}
        </x-layout.message>
    @endif
        <livewire:list-subscriptions-held/>

</x-app-layout>
