<div>
    @if(!empty($error))

        <div class="rounded-lg pl-2 bg-red-400 bg-black text-white mb-2">
            <span class="font-bold">Error</span>
            - Cannot connect to Stripe to retrieve your stored cards.<br/>Please try again later
        </div>

        <div class=" mb-2">
            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                [{{$error}}]
            @endif

        </div>
    @endif
    <div>
        <x-headers.h2>Your Registered Cards</x-headers.h2>
        <div class="md:flex">
            @forelse($payment_cards as $card)
                <div class="my-8 mx-4  mx-auto">
                    <div class=" max-w-md bg-blue-400 rounded-lg overflow-hidden md:max-w-xs">
                        <div class="md:flex">
                            <div class="w-full p-4">
                                <div class="flex justify-between items-center text-white">
                                    <span class="text-3xl font-bold">{{strToUpper($card->card->brand)}}</span>
                                </div>
                                <div class="flex justify-between items-center mt-6">
                                    @for ($i = 0; $i < 3; $i++)
                                        <div class="flex w-1/4 flex-row text-white text-3xl px-6">
                                            ****
                                        </div>
                                    @endfor
                                    <div class="flex w-1/4 flex-row text-white text-xl px-6">
                                        {{$card->card->last4}}
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-between items-center text-white">
                                    <span class="font-bold">{{$card->billing_details->name}}</span>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-300 text-sm">Expires</span>
                                        <span
                                            class="font-bold">{{$card->card->exp_month}}/{{$card->card->exp_year}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-buttons.default class="bg-red-600" wire:click="$emit('deleteCard', '{{$card->id}}')">
                        REMOVE</x-buttons.default>
                </div>
            @empty
                <div>You currently have no cards registered</div>
            @endforelse
        </div>
    </div>

    <div>
        <x-buttons.default><a href="{{route('paymentcards.create')}}">Add a new card</a></x-buttons.default>
    </div>


</div>

