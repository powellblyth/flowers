<div>
    <x-tab class="@if($active==='subscriptions')bg-gray-400@endif"  href="{{route('subscriptions.index')}}">My Subscriptions</x-tab>
    <x-tab class="@if($active==='paymentcards')bg-gray-400@endif" href="{{route('paymentcards.index')}}">My Cards</x-tab>
</div>
