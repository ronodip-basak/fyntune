<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/load_questions/{test}', ['App\Http\Controllers\TestController', 'returnQuestions'])->name('load_question');

Route::post('/select_answer/{answer}', ['App\Http\Controllers\AnswerController', 'markAsSelected'])->name('answer.markAsSelected');

Route::get('/user_data', ['App\Http\Controllers\UserDataController', 'search'])->middleware('auth')->name('userData.search');