<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckLoginedMiddleware;
use App\Http\Middleware\CheckLoginMiddleware;
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
Route::get('/not-found', function () {
    return view('other.index');
})->name('not_found');
Route::group([
    'middleware' => CheckLoginedMiddleware::class,
], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('authenticate');
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'processSignup'])->name('process_signup');
});

Route::group([
    'middleware' => CheckLoginMiddleware::class,
    'as' => 'user.',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/user', [UserController::class, 'user'])->name('get_user');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/test', [TestController::class, 'index']);

