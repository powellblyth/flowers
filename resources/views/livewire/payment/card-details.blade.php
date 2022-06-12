<div>

    @if(count($errors) > 0)
        @foreach($errors as $error)

        @endforeach
    @endif
    @if($intent)
        <style type="text/css">
            div#card-element input{
                background-color:#444;
            }
        </style>
        <div class="w-80 my-4">
            <div>
                <x-label for="card-holder-name" :value="__('Cardholder Name')"/>

                <input id="card-holder-name" placeholder="Cardholder Name" type="text">
            </div>
            <div class="mt-4">
                <x-label for="last_name" class="my-2" :value="__('Card Details')"/>
                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>

            </div>
        </div>
            <script src="https://js.stripe.com/v3/"></script>


        <x-button @click.prevent.stop id="card-button" data-secret="{{ $intent->client_secret }}">
            Create your subscription Payment Method
        </x-button>
        <script defer="defer">
            const stripe = Stripe('{{$stripeKey}}');

            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                style: {
                     base: {
                         backgroundColor:'#ddd',
                         lineHeight:2,
                         padding:2,
                    },
                    invalid: {
                         backgroundColor:'#400',
                    },
                    complete: {
                         backgroundColor:'#9c9',
                    },
                }
            });

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                );

                if (error) {
                    alert('error ' + error.message);
                    console.log(error);
                    Livewire.emit('paymentFailed', error)
                    // Display "error.message" to the user...
                } else {
                    Livewire.emit('paymentSucceeded', setupIntent)
                    console.log(setupIntent)
                    // The card has been verified successfully...
                }
            });
        </script>

    @else
        <div class="rounded-lg pl-2 bg-red-400 bg-black text-white">
            <span class="font-bold">Error</span>
            - Cannot connect to stripe
        </div>
        <div>
            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                [{{$error}}]
            @endif
        </div>
    @endif


</div>

