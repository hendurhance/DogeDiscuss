<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\NotificationController;

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


Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});




/*=============================== QUESTIONS ===============================*/
Route::apiResource('question', QuestionController::class);

/*=============================== QUESTIONS VOTES ===============================*/
Route::group([
    'prefix' => 'question/{question}/vote'
], function () {
    Route::post('up', [QuestionController::class, 'upVote']);
    Route::post('down', [QuestionController::class, 'downVote']);
    Route::delete('reset', [QuestionController::class, 'resetVote']);
});

/*=============================== CATEGORY ===============================*/
Route::apiResource('category', CategoryController::class)->except('update', 'destroy');


/*============================ REPLIES ============================*/
Route::apiResource('/question/{question}/reply', ReplyController::class)->except('show');

/*======================== LIKE ========================*/
Route::post('/like/{reply}', [LikeController::class, 'likeIt']);
Route::delete('/like/{reply}', [LikeController::class, 'unlikeIt']);

// Crypto currency API
Route::get('/ticker/doge', [CryptoController::class, 'doge']);
Route::get('/news/doge', [CryptoController::class, 'dogeNews']);

// Notifications API
Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/{notification}', [NotificationController::class, 'markAsRead']);