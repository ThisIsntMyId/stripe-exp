<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function create()
    {
        // Ask details for storing a checkout
    }

    public function store()
    {
        // when a checkout is stored, a purchase is created
        //  $u->purchases()->attach($p->id, ['transaction_id' => '123qwe', 'status' => 'fullfilled', 'amount' => '98.98']);
    }
}
