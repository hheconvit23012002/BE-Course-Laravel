<?php

use App\Http\Controllers\AuthController;
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
Route::group([
    'middleware' => CheckLoginedMiddleware::class,
],function (){
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('login', [AuthController::class,'processLogin'])->name('process_login');
});

Route::group([
    'middleware' => CheckLoginMiddleware::class,
    'as' =>'user.',
],function(){
    Route::get('/',[UserController::class,'index'])->name('index');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});
//Route::get('/', function () {
//    return view('welcome');
//});
