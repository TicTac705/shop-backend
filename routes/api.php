<?php

use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Catalog\BasketController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/sign-in', [LoginController::class, 'signIn']);
Route::post('/signup', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/', [CatalogController::class, 'getList'])->name('home');

    Route::get('/profile', [ProfileController::class, 'getUserInfo'])->name('profile');

    Route::group([
        'name' => 'profile.',
        'prefix' => 'profile'
    ], function () {
//        Route::get('/orders', [ProfileController::class, 'index'])->name('order');
//        Route::put('/orders/{id}/recall', [ProfileController::class, 'recall'])->name('order.recall');

        Route::group(['middleware' => 'role:admin'], function () {
            Route::get('/catalog-management/products/', [ProductManagementController::class, 'getList'])->name('catalogManagement.products');
            Route::get('/catalog-management/products/get-create-data', [ProductManagementController::class, 'getCreateData'])->name('catalogManagement.products.create');
            Route::post('/catalog-management/products/', [ProductManagementController::class, 'store'])->name('catalogManagement.products.store');

            Route::get('/catalog-management/products/get-update-data/{id}', [ProductManagementController::class, 'getUpdateData'])->name('catalogManagement.products.edit');
            Route::put('/catalog-management/products/{id}', [ProductManagementController::class, 'update'])->name('catalogManagement.products.update');

//            Route::delete('/catalog-management/products/{id}', [ProductManagementController::class, 'destroy'])->name('catalogManagement.products.destroy');

//            Route::post('/catalog-management/image/', [ImageController::class, 'create'])->name('catalogManagement.image.create');
            Route::delete('/catalog-management/image/{id}', [ImageController::class, 'destroy'])->name('catalogManagement.image.destroy');
        });
    });

    Route::get('/basket', [BasketController::class, 'getBasket'])->name('basket');
    Route::group([
        'name' => 'basket.',
        'prefix' => 'basket'
    ], function () {
        Route::post('/product', [BasketController::class, 'storeOrUpdate'])->name('product.store');
        Route::put('/product', [BasketController::class, 'storeOrUpdate'])->name('product.update');
        Route::delete('/product/{id}', [BasketController::class, 'destroy'])->name('product.destroy');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/token/refresh', [LoginController::class, 'refresh'])->name('refresh');
});
