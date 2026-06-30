<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web - Fashion SaaS Cliente Laravel
|--------------------------------------------------------------------------
| Cliente web que consume la API REST de Django como backend principal.
*/

Route::get('/', [StoreController::class, 'home'])->name('home');

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Catálogo
Route::get('/tienda/{storeSlug}', [StoreController::class, 'catalog'])->name('store.catalog');
Route::get('/tienda/{storeSlug}/producto/{productSlug}', [StoreController::class, 'productDetail'])->name('store.product');

// Órdenes
Route::get('/mis-ordenes', [OrderController::class, 'index'])->name('orders.index');