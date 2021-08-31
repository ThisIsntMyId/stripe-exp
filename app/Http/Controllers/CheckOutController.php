<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    const SHIPPING_COST = 10;
    const COMMISSION = 20;

    public function create(Product $product)
    {
        // Ask details for storing a checkout

        // chk if user have customer id, if not create and save it
        $user = auth()->user();
        if(! $user->stripe_id)
        {
            $stripeCustomer = stripe_instance()->customers->create([
                'name' => $user->name,
                'email' => $user->email,
                'metadata' => ['app_id' => $user->id],
                'address' => [
                    'city' => $user->address_city,
                    'country' => 'IN',
                    'line1' => $user->address_line_1,
                    'line2' => $user->address_line_2,
                    'postal_code' => $user->address_zipcode,
                    'state' => $user->address_state,
                ]
            ]);
            $user->stripe_id = $stripeCustomer->id;
            $user->save();
        }

        // create payment intent
        $intent = stripe_instance()->paymentIntents->create([
            'amount' => $product->price * 100 + self::SHIPPING_COST + self::COMMISSION,
            'currency' => 'inr',
            'customer' => $user->stripe_id,
            'description' => 'Some random product on internet : ' . $product->name,
        ]);

        // dd($intent);

        return view('checkout.create', [
            'intent_secret' => $intent->client_secret,
            'product' => $product,
            'shipping_cost' => self::SHIPPING_COST,
            'commission' => self::COMMISSION,
        ]);
        // send product details, payment intent secret to view
    }

    public function store(Product $product)
    {
        $paymentIntent = stripe_instance()->paymentIntents->retrieve(
            request()->transaction_id,
            []
        );

        // when a checkout is stored, a purchase is created
        $user = auth()->user();
        $user->purchases()->attach($product->id, ['transaction_id' => request()->transaction_id, 'status' => 'processing', 'amount' => $paymentIntent->amount / 100]);

        return redirect()->route('purchases');
    }
}
