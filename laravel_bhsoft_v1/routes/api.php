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
    'middleware' => ['auth:api',CheckApiAdminMiddleware::class],
    'as' => 'users.',
    'prefix' => 'users'
], function () {
    Route::get('/', [UserController::class, 'users'])->name('index');
    Route::get('/{id}', [UserController::class, 'user'])->name('show');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
});
Route::group([
    'middleware' => ['auth:api',CheckApiAdminMiddleware::class],
    'as' => 'courses.',
    'prefix' => 'courses'
], function () {
    Route::get('/', [CourseControllerAlias::class, 'courses'])->name('index');
    Route::get('/{id}', [CourseControllerAlias::class, 'course'])->name('show');
    Route::delete('/{id}', [CourseControllerAlias::class, 'destroy'])->name('destroy');
    Route::post('/', [CourseControllerAlias::class, 'store'])->name('store');
    Route::put('/{id}', [CourseControllerAlias::class, 'update'])->name('update');
});
Route::group([
    'middleware' => ['auth:api',CheckApiAdminMiddleware::class],
    'as' => 'dashboard',
    'prefix' => 'dashboard'
], function () {
    Route::get('/', [DashBoardController::class, 'apiDashboard']);
});
Route::group([
    'middleware' => ['auth:api',CheckApiAdminMiddleware::class],
],function (){
    Route::post('/import-csv', [CourseControllerAlias::class, 'importCsv'])->name('import_csv');
    Route::get('/export-csv', [CourseControllerAlias::class, 'exportCsv'])->name('export_csv');
});

Route::group([],function (){
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login');
    Route::get('/user', [UserController::class, 'user'])->name('get_user');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
//
//Route::group([
////    'middleware' => CheckLoginedMiddleware::class,
//], function () {
//    Route::post('/login', [AuthController::class, 'processLogin'])->name('authenticate');
//});
