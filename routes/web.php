<?php

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

Route::get('/producto/{product:slug}', function (Product $product) {
    $product->load(['brand', 'images', 'primaryImage', 'categories', 'tags', 'variants']);

    $exchangeRate = ExchangeRate::where('base', 'USD')
        ->where('quote', 'VES')
        ->latest()
        ->first();

    return view('store.products.show', compact('product', 'exchangeRate'));
})->name('products.show');
