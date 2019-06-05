@extends('layouts.app', ['activePage' =>'entrants', 'titlePage' => 'Edit ' . $thing->getName()])

@section('pagetitle', 'Edit ' . $thing->getName())
@section('content')



    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-header card-header-success">{{__('Family Members')}}</div>
                        <div class="card-body">
                            <script src="https://js.stripe.com/v3/"></script>

                            <script type="text/javascript" defer="defer">
                                var stripe = Stripe('{{config('services.stripe.key')}}');
                                var elements = stripe.elements();
                                if (window.addEventListener) {
                                    window.addEventListener('load', doStuff, false);
                                } else if (window.attachEvent) {
                                    window.attachEvent('onload', doStuff);
                                } else {
                                    window.onload = doStuff;
                                }
                                var style = {
                                    base: {
                                        // Add your base input styles here. For example:
                                        fontSize: '16px',
                                        color: "#32325d",
                                    }
                                };
                                function doStuff() {
                                    // Custom styling can be passed to options when creating an Element.


                                    // Create an instance of the card Element.
                                    var card = elements.create('card', {style: style});

                                    // Add an instance of the card Element into the `card-element` <div>.
                                    card.mount('#card-element');

                                    card.addEventListener('change', function (event) {
                                        var displayError = document.getElementById('card-errors');
                                        if (event.error) {
                                            displayError.textContent = event.error.message;
                                        } else {
                                            displayError.textContent = '';
                                        }
                                    });

                                    // Create a token or display an error when the form is submitted.
                                    var form = document.getElementById('payment-form');
                                    form.addEventListener('submit', function (event) {
                                        event.preventDefault();

                                        stripe.createToken(card).then(function (result) {
                                            if (result.error) {
                                                // Inform the customer that there was an error.
                                                var errorElement = document.getElementById('card-errors');
                                                errorElement.textContent = result.error.message;
                                            } else {
                                                // Send the token to your server.
                                                stripeTokenHandler(result.token);
                                            }
                                        });
                                    });
                                };

                                function stripeTokenHandler(token) {
                                    // Insert the token ID into the form so it gets submitted to the server
                                    var form = document.getElementById('payment-form');
                                    var hiddenInput = document.createElement('input');
                                    hiddenInput.setAttribute('type', 'hidden');
                                    hiddenInput.setAttribute('name', 'stripeToken');
                                    hiddenInput.setAttribute('value', token.id);
                                    form.appendChild(hiddenInput);

                                    // Submit the form
                                    form.submit();
                                }
                            </script>

                            <form action="/charge" method="post" id="payment-form">
                                <div class="form-row row">
                                    <div class="col-lg-8 col-md-12">

                                        <label for="card-element">
                                            Credit or debit card
                                        </label>
                                        <div id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                        </div>
                                    </div>

                                    <!-- Used to display Element errors. -->
                                    <div id="card-errors" role="alert"></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button>Submit Payment</button>
                                    </div>
                                </div>



                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection