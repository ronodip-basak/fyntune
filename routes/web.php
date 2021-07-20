<?php


use Illuminate\Support\Facades\Route;

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
    return view('public.index');
})->name('home');

Route::post('/start_quiz', ['App\Http\Controllers\TestController', 'startTest'])->name('test.start');

Route::get('/quiz/{test}', ['App\Http\Controllers\TestController', 'index'])->name('test.index');

Route::post('/result/{test}', ['App\Http\Controllers\UserDataController', 'saveResult'])->name('test.saveResult');

Route::get('/result/{test}', ['App\Http\Controllers\TestController', 'showResult'])->name('test.showResult');

Route::get('/admin', ['App\Http\Controllers\TestController', 'adminIndex'])->middleware('auth')->name('admin');

Route::get('/login', ['App\Http\Controllers\UserController', 'login'])->name('login');

Route::post('/login', ['App\Http\Controllers\UserController', 'loginSubmit'])->name('loginSubmit');