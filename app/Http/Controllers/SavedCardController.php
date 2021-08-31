<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedCardController extends Controller
{
    public function index(Request $request)
    {
        $cards = stripe_instance()->paymentMethods->all([
            'customer' => auth()->user()->stripe_id,
            'type' => 'card',
          ]);

        return view('saved-cards.index', [
            'cards' => $cards
        ]);
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $intent = stripe_instance()->setupIntents->create([
            'customer' => $user->stripe_id
        ]);

        return view('saved-cards.create', [
            'intent_secret' => $intent->client_secret,
        ]);
    }

    public function store(Request $request)
    {
        dd(request()->all());
    }

    public function charge(Request $request)
    {
        $payment_method_id = $request->card;

        try {
            stripe_instance()->paymentIntents->create([
              'amount' => 1099,
              'currency' => 'inr',
              'customer' => auth()->user()->stripe_id,
              'payment_method' => $payment_method_id,
              'off_session' => true,
              'confirm' => true,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            dd($e);
            // Error code will be authentication_required if authentication is needed
            // echo 'Error code is:' . $e->getError()->code;
            // $payment_intent_id = $e->getError()->payment_intent->id;
            // $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }
    }
}
