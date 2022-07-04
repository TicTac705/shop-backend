<?php

use App\Http\Controllers\Auth\CatalogManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Catalog\CatalogBasketController;
use App\Http\Controllers\Catalog\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/sign-in', [LoginController::class, 'index'])->name('sign-in');
Route::post('/sign-in', [LoginController::class, 'signIn']);

Route::post('/token/refresh', [LoginController::class, 'refresh'])->name('refresh');

Route::get('/signup', [RegisterController::class, 'index'])->name('signup');
Route::post('/signup', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/', [CatalogController::class, 'index'])->name('home');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::group([
        'name' => 'profile.',
        'prefix' => 'profile'
    ], function () {
        Route::get('/orders', [ProfileController::class, 'index'])->name('order');
        Route::put('/orders/{id}/recall', [ProfileController::class, 'recall'])->name('order.recall');

        Route::group(['middleware' => 'role:admin'], function () {
            Route::get('/catalog-management/products/', [CatalogManagementController::class, 'index'])->name('catalogManagement.products');
            Route::get('/catalog-management/products/create', [CatalogManagementController::class, 'create'])->name('catalogManagement.products.create');
            Route::post('/catalog-management/products/create', [CatalogManagementController::class, 'store'])->name('catalogManagement.products.store');

            Route::get('/catalog-management/products/update/{product}', [CatalogManagementController::class, 'edit'])->name('catalogManagement.products.edit');
            Route::put('/catalog-management/products/update/{product}', [CatalogManagementController::class, 'update'])->name('catalogManagement.products.update');

            Route::delete('/catalog-management/products/destroy/{product}', [CatalogManagementController::class, 'destroy'])->name('catalogManagement.products.destroy');
        });
    });

    Route::get('/basket', [CatalogBasketController::class, 'index'])->name('basket');
    Route::group([
        'name' => 'basket.',
        'prefix' => 'basket'
    ], function () {
        Route::post('/add/{product}', [CatalogBasketController::class, 'store'])->name('store');
        Route::put('/change/{product}/quantity/{quantity}', [CatalogBasketController::class, 'update'])->name('update');
        Route::delete('/destroy/{product}', [CatalogBasketController::class, 'destroy'])->name('destroy');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
