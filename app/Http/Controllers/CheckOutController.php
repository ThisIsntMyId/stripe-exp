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
                'metadata' => ['app_id' => $user->id]
            ]);
            $user->stripe_id = $stripeCustomer->id;
            $user->save();
        }

        // create payment intent
        $intent = stripe_instance()->paymentIntents->create([
            'amount' => $product->price * 100 + self::SHIPPING_COST + self::COMMISSION,
            'currency' => 'usd',
            'customer' => $user->stripe_id,
        ]);

        return view('checkout.create', [
            'intent_secret' => $intent->secret,
            'product' => $product,
            'shipping_cost' => self::SHIPPING_COST,
            'commission' => self::COMMISSION,
        ]);
        // send product details, payment intent secret to view
    }

    public function store(Product $product)
    {
        // when a checkout is stored, a purchase is created
        //  $u->purchases()->attach($p->id, ['transaction_id' => '123qwe', 'status' => 'fullfilled', 'amount' => '98.98']);
    }
}
