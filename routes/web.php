<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class,'category'])->name('category.show');
Route::get('/product/{id}', [ProductController::class,'show'])->name('product.show');

Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class,'checkout'])->middleware('auth')->name('checkout');
Route::post('/order/place', [OrderController::class,'place'])->middleware('auth')->name('order.place');
Route::get('/order/{order}/invoice', [OrderController::class,'invoice'])->middleware('auth')->name('order.invoice');
Route::post('/order/{order}/cancel', [OrderController::class,'cancel'])->middleware('auth')->name('order.cancel');

Route::get('/shop/request', [ShopController::class,'create'])->middleware('auth')->name('shop.request');
Route::post('/shop/request', [ShopController::class,'store'])->middleware('auth')->name('shop.request.store');

require __DIR__.'/auth.php';
