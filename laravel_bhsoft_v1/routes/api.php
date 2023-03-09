<?php

use App\Http\Controllers\Admin\CourseController as CourseControllerAlias;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Middleware\CheckApiAdminMiddleware;
use App\Http\Middleware\CheckLoginedMiddleware;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/coursesSelect2', [CourseController::class, 'index'])->name('coursesSelect2');
Route::group([
    'middleware' => CheckApiAdminMiddleware::class,
    'as' => 'users.',
    'prefix' => 'users'
], function () {
    Route::get('/', [UserController::class, 'users'])->name('index');
    Route::get('/show', [UserController::class, 'user'])->name('show');
    Route::delete('/destroy', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
});
Route::group([
    'middleware' => CheckApiAdminMiddleware::class,
    'as' => 'courses.',
    'prefix' => 'courses'
], function () {
    Route::get('/', [CourseControllerAlias::class, 'courses'])->name('index');
    Route::get('/show', [CourseControllerAlias::class, 'course'])->name('show');
    Route::delete('/destroy', [CourseControllerAlias::class, 'destroy'])->name('destroy');
    Route::post('/store', [CourseControllerAlias::class, 'store'])->name('store');
    Route::put('/update/{course}', [CourseControllerAlias::class, 'update'])->name('update');
});
Route::group([
//    'middleware' => CheckApiAdminMiddleware::class,
    'as' => 'dashboard',
    'prefix' => 'dashboard'
], function () {
    Route::get('/', [DashBoardController::class, 'apiDashboard']);
});
//
//Route::group([
////    'middleware' => CheckLoginedMiddleware::class,
//], function () {
//    Route::post('/login', [AuthController::class, 'processLogin'])->name('authenticate');
//});
