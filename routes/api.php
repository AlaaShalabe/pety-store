<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Message\FeedbackController;
use App\Http\Controllers\Message\SupportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Models\Product;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(FeedbackController::class)->middleware('isAdmin')->group(function () {
    Route::post('feedback', 'store')->withoutMiddleware('isAdmin');
    Route::get('feedbacks',  'index')->name('feedbackes.index');
    Route::get('feedbacks/{message}',  'show')->name('feedbackes.show');
    Route::delete('feedbacks/{message}',  'destroy')->name('feedbackes.destroy');
});

Route::controller(SupportController::class)->middleware('isAdmin')->group(function () {
    Route::post('support', 'store')->withoutMiddleware('isAdmin');
    Route::get('supports',  'index')->name('supports.index');
    Route::get('supports/{message}',  'show')->name('supports.show');
    Route::delete('supports/{message}', 'destroy')->name('supports.destroy');
});
Route::controller(CartController::class)->group(function () {
    Route::post('cart', 'store');
    Route::get('carts',  'index')->name('carts.index');
    Route::get('carts/{cart}',  'show')->name('carts.show');
    Route::delete('carts/{cart}', 'destroy')->name('carts.destroy');
});
Route::controller(OrderController::class)->group(function () {
    Route::post('order', 'store');
    Route::get('orders',  'index')->name('orders.index');
    Route::get('orders/{order}',  'show')->name('orders.show');
    Route::delete('orders/{order}', 'destroy')->name('orders.destroy');
});
Route::controller(CategoryController::class)->middleware('isAdmin')->group(function () {
    Route::get('categories',  'index')->withoutMiddleware('isAdmin');
    Route::get('categories/{category}',  'show')->withoutMiddleware('isAdmin');
    Route::post('categories', 'store')->name('categories.store');
    Route::put('categories/{category}',  'update')->name('categories.update');
    Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
});
Route::controller(ProductController::class)->middleware('isAdmin')->group(function () {
    Route::get('products',  'index')->withoutMiddleware('isAdmin');
    Route::get('products/{product}',  'show')->withoutMiddleware('isAdmin');
    Route::post('products', 'store')->name('products.store');
    Route::put('products/{product}',  'update')->name('products.update');
    Route::delete('products/{product}', 'destroy')->name('products.destroy');
});
Route::controller(RateController::class)->middleware('auth:api')->group(function () {
    Route::get('rates',  'index')->name('rates.index');
    Route::post('rates', 'store')->name('rates.store');
    Route::put('rates/{rate}',  'update')->name('rates.update');
    Route::delete('rates/{rate}', 'destroy')->name('rates.destroy');
});

Route::post('search', [SearchController::class,'result']);

