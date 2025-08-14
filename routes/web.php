<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('main');
})->name('home');


Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');


// PAGES

Route::get('/product', function () {
    return view('pages.product');
})->name('product');

Route::get('/product-detail', function () {
    return view('pages.product-detail');
})->name('product.detail');

Route::get('/about-us', function () {
    return view('pages.about-us');
})->name('about-us');

Route::get('/cart', function () {
    return view('pages.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('pages.checkout');
})->name('checkout');

Route::get('/checkout-process', function () {
    return view('pages.checkout');
})->name('checkout.process');


Route::get('/address', function () {
    return view('pages.address');
})->name('address');
Route::post('/address-store', function () {
    return view('pages.address');
})->name('addresses.store');



Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/categories', function () {
        return view('pages.admin.category');
    })->name('admin.categories');


});

