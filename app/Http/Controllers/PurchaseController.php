<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        // list users purchases
        $products = Product::paginate(12);
        return view('products.index', ['products' => $products]);
    }
}
