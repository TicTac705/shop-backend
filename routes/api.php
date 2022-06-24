<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
Route::get('/', [Controller::class, 'index'])->name('main');

Route::get('/login', [Controller::class, 'index'])->name('login');
Route::post('/login', [Controller::class, 'authorize']);

Route::get('/registration', [Controller::class, 'index'])->name('registration');
Route::post('/registration', [Controller::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/profile', [Controller::class, 'index'])->name('profile');
    Route::group([
        'name' => 'profile.',
        'prefix' => 'profile'
    ], function () {
        Route::get('/order', [Controller::class, 'index'])->name('order');
        Route::put('/order/{id}/recall', [Controller::class, 'recall'])->name('order.recall');

        Route::get('/catalog-management', [Controller::class, 'index'])->name('catalogManagement');
        Route::get('/catalog-management/add', [Controller::class, 'index'])->name('catalogManagement.addForm');
        Route::post('/catalog-management/add', [Controller::class, 'addProduct'])->name('catalogManagement.addProduct');

        Route::get('/catalog-management/change/{product}', [Controller::class, 'index'])->name('catalogManagement.changeForm');
        Route::put('/catalog-management/change/{product}', [Controller::class, 'addProduct'])->name('catalogManagement.changeProduct');

        Route::delete('/catalog-management/delete/{product}', [Controller::class, 'addProduct'])->name('catalogManagement.deleteProduct');
    });

    Route::get('/basket', [Controller::class, 'index'])->name('basket');
    Route::group([
        'name' => 'basket.',
        'prefix' => 'basket'
    ], function () {
        Route::post('/add/{product}', [Controller::class, 'addProduct'])->name('add');
        Route::put('/change/{product}/quantity/{quantity}', [Controller::class, 'changeQuantityProduct'])->name('change');
        Route::delete('/delete/{product}', [Controller::class, 'deleteProduct'])->name('delete');
    });

    Route::get('/catalog', [Controller::class, 'index'])->name('catalog');
});
