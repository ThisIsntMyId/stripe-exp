<x-app-layout>
    <x-slot name="head">
        <title>Checkout</title>
        <script src="https://js.stripe.com/v3/"></script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Card : ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <h1>Save a card so we can charge you in future.</h1>
            </div>
            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <form data-client-secret="{{$intent_secret}}" id="setup-form" method="POST" action="{{route('saved-cards.store')}}">
                    @csrf

                    <div class=" relative ">
                        <label for="cardholder-name" class="text-gray-700">
                            Name
                        </label>
                        <input type="text" id="cardholder-name" name="name" readonly  value="{{auth()->user()->name}}"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            name="email" placeholder="John Doe" />
                    </div>


                    <div class=" relative opacity-50 pointer-events-none">
                        <label for="email" class="text-gray-700">
                            Email
                        </label>
                        <input type="text" id="email" name="email" readonly="" value="{{auth()->user()->email}}"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                    </div>

                    <div class=" relative ">
                        <label for="card_details" class="text-gray-700">
                            Card Details
                        </label>
                        <div id="card_details"></div>
                        <div id="card_errors"></div>
                    </div>

                    <input type="hidden" name="setup_id" />

                    <button id="submit">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="button-text">Checkout</span>
                    </button>


                </form>
            </div>
        </div>
    </div>

    <x-slot name="foot">
        <script>
            let stripe = Stripe('{{config('stripe.key')}}');
            let elements = stripe.elements();
            var style = {
                base: {
                    color: "#32325d",
                }
            };

            let card = elements.create("card", { style: style });
            card.mount("#card_details");
            card.on('change', function(event) {
                let displayError = document.getElementById('card_errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // let form = document.getElementById("payment-form");
            // form.addEventListener("submit", function(event) {
            //     event.preventDefault();
            //     // Complete payment when the submit button is clicked
            //     payWithCard(stripe, card, form.dataset.clientSecret);
            // });

            // var payWithCard = function(stripe, card, clientSecret) {
            //     loading(true);
            //     stripe
            //         .confirmCardPayment(clientSecret, {
            //             payment_method: {
            //                 card: card
            //             },
            //             setup_future_usage: 'off_session'
            //         })
            //         .then(function(result) {
            //             if (result.error) {
            //                 // Show error to your customer
            //                 showError(result.error.message);
            //             } else {
            //                 // The payment succeeded!
            //                 orderComplete(result.paymentIntent.id);
            //             }
            //     });
            // };

            // Show a spinner on payment submission
            let loading = function(isLoading) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    document.querySelector("button#submit").disabled = true;
                    document.querySelector("#spinner").classList.remove("hidden");
                    document.querySelector("#button-text").classList.add("hidden");
                } else {
                    document.querySelector("button#submit").disabled = false;
                    document.querySelector("#spinner").classList.add("hidden");
                    document.querySelector("#button-text").classList.remove("hidden");
                }
            };



            let setupForm = document.getElementById('setup-form');
            let cardholderName = document.getElementById('cardholder-name');
            let clientSecret = setupForm.dataset.clientSecret;

            setupForm.addEventListener('submit', function(ev) {
                ev.preventDefault();
                stripe.confirmCardSetup(
                    clientSecret,
                    {
                    payment_method: {
                        card: card,
                        billing_details: {
                        name: cardholderName.value,
                        },
                    },
                    }
                ).then(function(result) {
                    if (result.error) {
                    // Display error.message in your UI.
                    } else {
                        console.log(result)
                        orderComplete(result.setupIntent.id)
                    // The setup has succeeded. Display a success message.
                    }
                });
            });

            let orderComplete = function(setupIntentId) {
                alert('Thanks ... Setup Pyament id: ' + setupIntentId);
                document.querySelector('[name="setup_id"]').value = setupIntentId;
                HTMLFormElement.prototype.submit.call(setupForm)
                loading(false);
            };

            let showError = function(errorMsgText) {
                loading(false);
                alert('Some Err. Chk console');
                console.log(errorMsgText);
            };
        </script>
    </x-slot>
</x-app-layout>
