
<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('Subscribe for PHS Membership') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Subscribe for PHS Membership') }}
        </x-headers.h1>
    </x-slot>

    <x-navigation.subscription-tabs active="paymentcards">
    </x-navigation.subscription-tabs>

    <x-layout.tabbed-intro-para>
        <p>
            Enter your card details here, and our payment processor, Stripe, will keep hold of them securely.
        </p>
    </x-layout.tabbed-intro-para>

        <x-layout.intro-para>
            <livewire:card-details/>
        </x-layout.intro-para>

    <x-layout.intro-para>
        If you are interested, <x-a target="_blank" href="https://stripe.com/gb/privacy">This is Stripe's privacy policy </x-a>
        The Horti don't store or have access to your card details.
    </x-layout.intro-para>

</x-app-layout>


