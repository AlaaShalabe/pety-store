<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Message\FeedbackController;
use App\Http\Controllers\Message\SupportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
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
    Route::get('feedbacks',  'index');
    Route::get('feedbacks/{message}',  'show');
    Route::delete('feedbacks/{message}',  'destroy');
});

Route::controller(SupportController::class)->middleware('isAdmin')->group(function () {
    Route::post('supports', 'store')->withoutMiddleware('isAdmin');
    Route::get('supports',  'index');
    Route::get('supports/{message}', 'show');
    Route::delete('supports/{message}', 'destroy');
});
Route::controller(CartController::class)->group(function () {
    Route::post('carts', 'store');
    Route::get('carts',  'index');
    Route::put('carts/{cart}',  'update');
    Route::delete('carts/{cart}', 'destroy');
});
Route::controller(OrderController::class)->group(function () {
    Route::post('order', 'store');
});
Route::controller(PaymentController::class)->group(function () {
    Route::post('payment', 'pay');
});

Route::controller(CategoryController::class)->middleware('isAdmin')->group(function () {
    Route::get('categories',  'index')->withoutMiddleware('isAdmin');
    Route::get('categories/{category}',  'show')->withoutMiddleware('isAdmin');
    Route::post('categories', 'store');
    Route::put('categories/{category}',  'update');
    Route::delete('categories/{category}', 'destroy');
});
Route::controller(ProductController::class)->group(function () {
    Route::get('products',  'index');
    Route::get('products/{product}/show',  'show');
    Route::post('products/store', 'store');
    Route::put('products/{product}/update',  'update');
    Route::delete('products/{product}/delete', 'destroy');
});
Route::controller(RateController::class)->middleware('auth:api')->group(function () {
    Route::get('rates',  'index');
    Route::post('rates', 'store');
    Route::put('rates/{rate}',  'update');
    Route::delete('rates/{rate}', 'destroy');
});

Route::post('search', [SearchController::class, 'result']);
