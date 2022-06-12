
<x-app-layout>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('Subscribe for PHS Membership') }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <p>
            Enter your card details here, and our payment processor, Stripe, will keep hold of them securely.
        </p>
    </x-layout.intro-para>
    <div class="ml-40">
        <x-subscriptions.tabs active="paymentcards">
        </x-subscriptions.tabs>
    </div>

        <x-layout.intro-para>
            <livewire:card-details/>
        </x-layout.intro-para>

    <x-layout.intro-para>
        If you are interested, <x-a target="_blank" href="https://stripe.com/gb/privacy">This is Stripe's privacy policy </x-a>
        The Horti don't store or have access to your card details.
    </x-layout.intro-para>

</x-app-layout>


