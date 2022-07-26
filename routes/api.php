<?php

use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Catalog\BasketController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Catalog\OrderController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/sign-in', [LoginController::class, 'signIn'])->name('signIn');
Route::post('/signup', [RegisterController::class, 'register'])->name('signUp');;

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/', [CatalogController::class, 'getList'])->name('home');

    Route::get('/profile', [ProfileController::class, 'getUserInfo'])->name('profile');

    Route::group([
        'as' => 'profile.',
        'prefix' => 'profile'
    ], function () {
        Route::get('/orders', [OrderController::class, 'getList'])->name('orders.getList');
        Route::post('/orders', [OrderController::class, 'create'])->name('orders.create');
        Route::put('/orders/{id}/recall', [OrderController::class, 'recall'])->name('orders.recall');

        Route::group([
            'middleware' => 'role:admin|manager',
            'as' => 'catalogManagement.',
            'prefix' => 'catalog-management'
        ], function () {
            Route::get('/products', [ProductManagementController::class, 'getList'])->name('products');
            Route::get('/products/get-create-data', [ProductManagementController::class, 'getCreateData'])->name('products.create');
            Route::post('/products', [ProductManagementController::class, 'store'])->name('products.store');

            Route::get('/products/get-update-data/{id}', [ProductManagementController::class, 'getUpdateData'])->name('products.edit');
            Route::put('/products/{id}', [ProductManagementController::class, 'update'])->name('products.update');
            Route::delete('/products/{id}', [ProductManagementController::class, 'destroy'])->name('products.destroy');

            Route::post('/image/', [ImageController::class, 'store'])->name('image.store');
            Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
        });

        Route::group([
            'middleware' => 'role:admin|manager',
            'as' => 'ordersManagement.',
            'prefix' => 'orders-management'
        ], function () {
            Route::get('/', [OrderManagementController::class, 'getList'])->name('getList');
            Route::get('/get-update-data/{id}', [OrderManagementController::class, 'getUpdateData'])->name('getOrder');
            Route::put('/{id}', [OrderManagementController::class, 'update'])->name('update');
        });
    });

    Route::group([
        'as' => 'basket.',
        'prefix' => 'basket'
    ], function () {
        Route::get('/', [BasketController::class, 'getBasket'])->name('getBasket');
        Route::post('/product', [BasketController::class, 'store'])->name('product.store');
        Route::put('/product', [BasketController::class, 'updateQuantity'])->name('product.update');
        Route::delete('/product/{id}', [BasketController::class, 'destroy'])->name('product.destroy');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/token/refresh', [LoginController::class, 'refresh'])->name('refresh');
});
