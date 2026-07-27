<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Models\ExchangeRate;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::with(['primaryImage', 'brand'])
        ->active()
        ->latest()
        ->get();

    $exchangeRate = ExchangeRate::where('base', 'USD')
        ->where('quote', 'VES')
        ->latest()
        ->first();

    return view('store.home', compact('products', 'exchangeRate'));
})->name('home');

Route::get('/buscar/sugerencias', [SearchController::class, 'suggestions'])->name('search.suggestions');
Route::get('/buscar', [SearchController::class, 'results'])->name('search.results');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/producto/{product:slug}', function (Product $product) {
    $product->load(['brand', 'images', 'primaryImage', 'categories', 'tags', 'variants']);

    $exchangeRate = ExchangeRate::where('base', 'USD')
        ->where('quote', 'VES')
        ->latest()
        ->first();

    return view('store.products.show', compact('product', 'exchangeRate'));
})->name('products.show');
