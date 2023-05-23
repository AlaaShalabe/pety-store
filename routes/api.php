<?php

use App\Http\Controllers\Message\FeedbackController;
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

Route::post('feedback', [FeedbackController::class, 'store']);
Route::middleware('isAdmin')->group(function () {
    Route::get('feedbacks', [FeedbackController::class, 'index'])->name('feedbackes.index');
    Route::get('feedbacks/{message}', [FeedbackController::class, 'show'])->name('feedbackes.show');
    Route::delete('feedbacks/{message}', [FeedbackController::class, 'destroy'])->name('feedbackes.destroy');
});
