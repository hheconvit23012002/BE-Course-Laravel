<?php

use App\Http\Controllers\Admin\CourseController as CourseControllerAlias;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Middleware\CheckApiAdminMiddleware;
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
Route::get('/coursesSelect2',[CourseController::class,'index'])->name('coursesSelect2');
Route::group([
    'middleware' => CheckApiAdminMiddleware::class,
    'as' => 'users.',
    'prefix' => 'users'
],function (){
    Route::get('/',[UserController::class,'allUser'])->name('all_users');
    Route::post('/user',[UserController::class,'getUser'])->name('get_user');
});
Route::group([
    'middleware' => CheckApiAdminMiddleware::class,
    'as' => 'courses.',
    'prefix' => 'courses'
],function (){
    Route::get('/',[CourseControllerAlias::class,'allCourse'])->name('all_courses');
    Route::post('/course',[CourseControllerAlias::class,'getCourse'])->name('get_course');
});
Route::group([
    'middleware' => CheckApiAdminMiddleware::class,
    'as' => 'dashboard',
    'prefix' => 'dashboard'
],function (){
    Route::get('/',[DashBoardController::class,'apiDashboard']);
});
