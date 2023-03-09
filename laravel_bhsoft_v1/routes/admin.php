<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\CheckAdminMiddleware;
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
    'middleware' => CheckAdminMiddleware::class,
    'as' => 'users.',
    'prefix' => 'users',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
//    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
//    Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
//    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::get('/show/{user}', [UserController::class, 'show'])->name('show');
});
Route::group([
    'middleware' => CheckAdminMiddleware::class,
    'as' => 'courses.',
    'prefix' => 'courses',
], function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/create', [CourseController::class, 'create'])->name('create');
//    Route::post('/store', [CourseController::class, 'store'])->name('store');
    Route::post('/import-csv', [CourseController::class, 'importCsv'])->name('import_csv');
    Route::get('/export-csv', [CourseController::class, 'exportCsv'])->name('export_csv');
    Route::get('/edit/{course}', [CourseController::class, 'edit'])->name('edit');
//    Route::put('/update/{course}', [CourseController::class, 'update'])->name('update');
//    Route::delete('/destroy/{course}', [CourseController::class, 'destroy'])->name('destroy');
    Route::get('/show/{course}', [CourseController::class, 'show'])->name('show');
});
Route::group([
    'middleware' => CheckAdminMiddleware::class,
    'as' => 'dashboard.',
    'prefix' => 'dashboard',
], function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('index');
});
