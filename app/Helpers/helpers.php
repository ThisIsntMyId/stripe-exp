<?php

use Illuminate\Support\Facades\App;

if (!function_exists('stripe_instance')) {
    function stripe_instance()
    {
        return App::make('stripe');
    }
}
