<div class="ml-20 mt-4 mb-0">
    @php
        $paymentCardClass = '';
        $subscriptionsClass = '';
            if ($active === 'subscriptions')
            {
                $subscriptionsClass='bg-gray-400';
            }
    @endphp
    <x-tab class=" {{$subscriptionsClass}}" href="{{route('subscriptions.index')}}">
        @lang('Memberships')
    </x-tab>
    @php
        if ($active === 'paymentcards')
        {
            $paymentCardClass='bg-gray-400';
        }
    @endphp
    <x-tab class="{{$paymentCardClass}}" href="{{route('paymentcards.index')}}">
        @lang('Cards')
    </x-tab>

</div>
