<div>
    <x-headers.h2>Your Membership Options</x-headers.h2>
    @if(count($membershipOptions) > 0)
        <div>
            @if(!empty($error))
                <div class="rounded-lg pl-2 bg-red-400 bg-black text-white">
                    <span class="font-bold">Error</span>
                    - Cannot connect to Stripe to retrieve your stored cards.<br/> Please try again later
                </div>
                <div>
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                        [{{$error}}]
                    @endif
                </div>
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
                    </x-button>
                </form>
            @else
                    <p>Before you subscribe for membership, you must register a payment card at Stripe</p>
                <x-button>
                    <a href="{{route('paymentcards.create')}}">Register a new <card></card></a>
                </x-button>
            @endif
        </div>
    @else
        <div>@lang('There are currently no memberships available to subscribe to')</div>
    @endif

</div>

