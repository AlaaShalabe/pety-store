<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GPSController;
use App\Http\Controllers\Message\FeedbackController;
use App\Http\Controllers\Message\SupportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrackerController;
use App\Models\Product;
use App\Models\Tracker;
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
Route::controller(ForgotPasswordController::class)->group(function () {

    Route::post('/password/forgot', 'forgetPassword');
    Route::post('/verify/code', 'verifycode');
});
Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/password/reset', 'resetPassword');
});


Route::controller(FeedbackController::class)->middleware('isAdmin')->group(function () {
    Route::post('feedback', 'store')->withoutMiddleware('isAdmin');
    Route::get('feedbacks',  'index')->name('feedbackes.index');
    Route::get('feedbacks/{message}',  'show')->name('feedbackes.show');
    Route::delete('feedbacks/{message}',  'destroy')->name('feedbackes.destroy');
});

Route::controller(SupportController::class)->middleware('isAdmin')->group(function () {
    Route::post('supports', 'store')->withoutMiddleware('isAdmin');
    Route::get('supports',  'index')->name('supports.index');
    Route::get('supports/{message}',  'show')->name('supports.show');
    Route::delete('supports/{message}', 'destroy')->name('supports.destroy');
});
Route::controller(CartController::class)->group(function () {
    Route::post('carts', 'store');
    Route::get('carts',  'index')->name('carts.index');
    Route::put('carts/{cart}',  'update')->name('carts.update');
    Route::delete('carts/{cart}', 'destroy')->name('carts.destroy');
});
Route::controller(OrderController::class)->group(function () {
    Route::post('order', 'store')->middleware('auth');
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
    Route::post('products', 'store')->name('products.store')->withoutMiddleware('isAdmin');
    Route::put('products/{product}',  'update')->name('products.update');
    Route::delete('products/{product}', 'destroy')->name('products.destroy');
});
Route::controller(RateController::class)->middleware('auth:api')->group(function () {
    Route::get('rates',  'index')->name('rates.index');
    Route::post('rates', 'store')->name('rates.store');
    Route::put('rates/{rate}',  'update')->name('rates.update');
    Route::delete('rates/{rate}', 'destroy')->name('rates.destroy');
});

Route::post('search', [SearchController::class, 'result']);

Route::post('findpet', [TrackerController::class, 'index'])->middleware('auth:api');
