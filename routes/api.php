<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(QuestionController::class)->group(function () {
    Route::get('question', 'index');
    Route::get('question/export', 'export');
    Route::post('question', 'store');
    Route::get('question/{id}', 'show');
    Route::put('question/{id}', 'update');
    Route::delete('question/{id}', 'destroy');
}); 

Route::controller(AnswerController::class)->group(function () {
    Route::post('answer', 'store');
}); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
