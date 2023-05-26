<?php

use App\Http\Controllers\Message\FeedbackController;
use App\Http\Controllers\Message\SupportController;
use App\Http\Controllers\ProductController;
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
    Route::get('supports',  'index')->name('supportes.index');
    Route::get('supports/{message}',  'show')->name('supportes.show');
    Route::delete('supports/{message}', 'destroy')->name('supportes.destroy');
});

Route::resource('products', ProductController::class);

