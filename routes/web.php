<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);

Route::group(['prefix' => 'stripe', 'middleware' => 'auth'], function () {
    Route::get('products', [StripeController::class, 'products']);
    Route::get('product/{id}', [StripeController::class, 'stripe']);
    Route::view('complete', 'stripe.complete');

    Route::post('purchase/{id}', [StripeController::class, 'purchase']);
});


