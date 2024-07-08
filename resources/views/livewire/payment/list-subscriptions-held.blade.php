<div>
    <x-layout.intro-para>

        <x-headers.h2>@lang('Your Current Membership Subscriptions')</x-headers.h2>

        @if(count($subscriptions) > 0 || count($manualMemberships) > 0)
            @if(count($subscriptions) > 0)
                @foreach ($subscriptions as $subscription)
                    <div>
                        <div class="title text-xl font-medium">
                            {{\App\Models\Membership::where('stripe_id', $subscription->name)
         ->where('stripe_price', $subscription->stripe_price)->first()?->label ?? $subscription->name
         }}
                        </div>
                        <div>
                            <x-buttons.default><a wire:click="cancelsubscription($subscription->name)">Cancel Membership</a></x-buttons.default>
                        </div>
                    </div>
                @endforeach
            @else
                <div>@lang('You have no current membership subscriptions')</div>
            @endif

            @if(count($manualMemberships) > 0)
                @foreach ($manualMemberships as $manualMembership)
                    <div class="title text-xl font-medium">
                        @lang('Manual') - {{$manualMembership->membership->label}}
                        until {{$manualMembership->end_date}}</div>
                @endforeach
            @endif
        @else
            <div>@lang('You have no current membership subscriptions')</div>
        @endif


    </x-layout.intro-para>

    @if(count($subscriptions) == 0 && count($manualMemberships) == 0)
        <x-layout.intro-para>
            <x-headers.h2>@lang('Your Membership Options')</x-headers.h2>
            @if(count($membershipOptions) > 0 )
                <div>
                    @if(!empty($error))
                        <div class="rounded-lg pl-2 bg-red-400 bg-black text-white">
                            <span class="font-bold">@lang('Error')</span>
                            - @lang('Cannot connect to Stripe to retrieve your stored cards.')
                            <br/> @lang('Please try again later')
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                            <div>
                                [{{$error}}]
                            </div>
                        @endif
                    @endif
                    @if(count($payment_cards) > 0)
                        <form method="POST" action="{{route('subscriptions.store')}}">
                            @csrf
                            <select name="membership_id">
                                @foreach($membershipOptions as $membership)
                                    <option value="{{$membership->id}}">{{$membership->label}}
                                        (&pound;{{$membership->formatted_price}})
                                    </option>
                                @endforeach
                            </select>
                            <select name="payment_method">
                                @foreach($payment_cards as $paymentCard)
                                    <option value="{{$paymentCard->stripe_id}}"
                                            @if ($paymentCard->is_default)
                                                selected="selected"
                                        @endif
                                    >
                                        {{strToUpper($paymentCard->card_name)}}'s
                                        {{strToUpper($paymentCard->brand)}}
                                        (ending {{$paymentCard->last4}})
                                    </option>
                                @endforeach
                            </select>
                            <x-button type="submit" class="ml-4">
                                {{ __('Subscribe') }}
                            </x-buttons.default>
                        </form>
                    @else
                        <p>@lang('Before you subscribe for membership, you must register a payment card at Stripe')</p>
                        <x-buttons.default>
                            <a href="{{route('paymentcards.create')}}">@lang('Register a new card')</a>
                        </x-buttons.default>
                    @endif
                </div>
            @else
                <div>@lang('There are currently no memberships available to subscribe to')</div>
            @endif
        </x-layout.intro-para>
    @endif

</div>

