<div>
    <x-headers.h2>@lang('Your Current Subscriptions')</x-headers.h2>
    @if($subscriptions && count($subscriptions) > 0)
        @foreach ($subscriptions as $subscription)
            <div class="title text-xl font-medium">{{$subscription->name}}</div>
        @endforeach
    @else
        <div>@lang('You have no current subscriptions')</div>
    @endif
</div>

