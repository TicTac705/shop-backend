<?php

use App\Http\Controllers\Auth\CatalogManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Catalog\CatalogBasketController;
use App\Http\Controllers\Catalog\CatalogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/sign-in', [LoginController::class, 'index'])->name('sign-in');
Route::post('/sign-in', [LoginController::class, 'signIn']);

Route::get('/signup', [RegisterController::class, 'index'])->name('signup');
Route::post('/signup', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::group([
        'name' => 'profile.',
        'prefix' => 'profile'
    ], function () {
        Route::get('/order', [ProfileController::class, 'getOrders'])->name('order');
        Route::put('/order/{id}/recall', [ProfileController::class, 'recallOrder'])->name('order.recall');

        Route::get('/catalog-management', [CatalogManagementController::class, 'index'])->name('catalogManagement');
        Route::get('/catalog-management/add', [CatalogManagementController::class, 'formAddProduct'])->name('catalogManagement.addForm');
        Route::post('/catalog-management/add', [CatalogManagementController::class, 'addProduct'])->name('catalogManagement.addProduct');

        Route::get('/catalog-management/change/{product}', [CatalogManagementController::class, 'formChangeProduct'])->name('catalogManagement.changeForm');
        Route::put('/catalog-management/change/{product}', [CatalogManagementController::class, 'changeProduct'])->name('catalogManagement.changeProduct');

        Route::delete('/catalog-management/delete/{product}', [CatalogManagementController::class, 'deleteProduct'])->name('catalogManagement.deleteProduct');
    });

    Route::get('/basket', [CatalogBasketController::class, 'index'])->name('basket');
    Route::group([
        'name' => 'basket.',
        'prefix' => 'basket'
    ], function () {
        Route::post('/add/{product}', [CatalogBasketController::class, 'addProduct'])->name('add');
        Route::put('/change/{product}/quantity/{quantity}', [CatalogBasketController::class, 'changeQuantityProduct'])->name('change');
        Route::delete('/delete/{product}', [CatalogBasketController::class, 'deleteProduct'])->name('delete');
    });


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [CatalogController::class, 'index'])->name('home');
});
