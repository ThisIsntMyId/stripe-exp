<?php

use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SavedCardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/checkout/{product}', [CheckOutController::class, 'create'])->name('checkouts.create');
Route::post('/checkout/{product}', [CheckOutController::class, 'store'])->name('checkouts.store');

Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases');

Route::get('saved-cards', [SavedCardController::class, 'index'])->name('saved-cards');
Route::get('saved-cards/create', [SavedCardController::class, 'create'])->name('saved-cards.create');
Route::post('saved-cards', [SavedCardController::class, 'store'])->name('saved-cards.store');

Route::post('saved-cards/{card}/charge', [SavedCardController::class, 'charge'])->name('saved-cards.charge');

require __DIR__.'/auth.php';
