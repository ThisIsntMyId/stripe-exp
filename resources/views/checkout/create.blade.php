<x-app-layout>
    <x-slot name="head">
        <title>Checkout</title>
        <script src="https://js.stripe.com/v3/"></script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product : ') }} {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <div class="relative">
                    <img alt="moto" src="{{$product->image}}" class="absolute -right-10 -bottom-8 h-40 w-40 mb-4" />
                    <div class="w-4/6">
                        <p class="text-gray-800 text-lg font-medium mb-2">
                            {{$product->name}}
                        </p>
                        <p class="text-gray-400 text-xs">
                            {{$product->desc}}
                        </p>
                        <p class="text-indigo-500 text-xl font-medium">
                            ${{$product->price}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <div class="h3">Price Calculation</div>

                <table class="table p-4 bg-white shadow rounded-lg">
                    <thead>
                        <tr>
                            <th class="border-b-2 p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                Item
                            </th>
                            <th class="border-b-2 p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                Price
                            </th>
                            <th class="border-b-2 p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                SubTotal
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-gray-700">
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                {{$product->name}}
                            </td>
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                {{$product->price}}
                            </td>
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                {{$product->price}}
                            </td>
                        </tr>
                        <tr class="text-gray-700">
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                Shipping
                            </td>
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                $10
                            </td>
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                {{$product->price + $shipping_cost}}
                            </td>
                        </tr>
                        <tr class="text-gray-700">
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                Commission
                            </td>
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                $20
                            </td>
                            <td class="border-b-2 p-4 dark:border-dark-5">
                                {{$product->price + $shipping_cost + $commission}}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="h5">Grand Total: {{$product->price + $shipping_cost + $commission}}</div>

            </div>
            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <form data-client-secret="{{$intent_secret}}" id="payment-form" method="POST" action="{{route('checkouts.store', ['product' => $product])}}">
                    @csrf

                    <div class=" relative ">
                        <label for="name" class="text-gray-700">
                            Name
                        </label>
                        <input type="text" id="name" name="name"
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

                    {{-- <div class=" relative ">
                        <label for="address_line_1" class="text-gray-700">
                            Address Line 1
                        </label>
                        <input type="text" id="address_line_1" name="address_line_1"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                    </div>

                    <div class=" relative ">
                        <label for="address_line_2" class="text-gray-700">
                            Address Line 2
                        </label>
                        <input type="text" id="address_line_2" name="address_line_2"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                    </div>

                    <div class=" relative ">
                        <label for="address_state" class="text-gray-700">
                            State
                        </label>
                        <input type="text" id="address_state" name="address_state"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                    </div>

                    <div class=" relative ">
                        <label for="address_city" class="text-gray-700">
                            City
                        </label>
                        <input type="text" id="address_city" name="address_city"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                    </div>

                    <div class=" relative ">
                        <label for="address_zipcode" class="text-gray-700">
                            Zip Code
                        </label>
                        <input type="text" id="address_zipcode" name="address_zipcode"
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                    </div> --}}

                    <div class=" relative ">
                        <label for="card_details" class="text-gray-700">
                            Card Details
                        </label>
                        <div id="card_details"></div>
                        <div id="card_errors"></div>
                    </div>

                    <input type="hidden" name="transaction_id" />

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

            let form = document.getElementById("payment-form");
            form.addEventListener("submit", function(event) {
                event.preventDefault();
                // Complete payment when the submit button is clicked
                payWithCard(stripe, card, form.dataset.clientSecret);
            });

            var payWithCard = function(stripe, card, clientSecret) {
                loading(true);
                stripe
                    .confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: card
                        },
                        setup_future_usage: 'off_session'
                    })
                    .then(function(result) {
                        if (result.error) {
                            // Show error to your customer
                            showError(result.error.message);
                        } else {
                            // The payment succeeded!
                            orderComplete(result.paymentIntent.id);
                        }
                });
            };

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

            let orderComplete = function(paymentIntentId) {
                alert('Thanks ... Pyament id: ' + paymentIntentId);
                document.querySelector('[name="transaction_id"]').value = paymentIntentId;
                HTMLFormElement.prototype.submit.call(form)
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
