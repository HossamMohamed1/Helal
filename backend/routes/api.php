<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\Helal\ChartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('updateProfile', [MeController::class, 'updateProfileInfo']);
    Route::resource('users', UserController::class);
});


/***
 * Report Charts Api
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'report'], function () {
    Route::get('charts', [ReportController::class, 'charts']);
    Route::get('statistics', [ReportController::class, 'statistics']);
    // Route::get('employee', [ReportController::class, 'employee']);
});


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'charts'], function () {
    Route::get('index', [ChartsController::class, 'index']);
    Route::get('show/{id}', [ChartsController::class, 'show']);
    Route::post('create', [ChartsController::class, 'create']);
    Route::put('edit/{id}', [ChartsController::class, 'edit']);
    Route::delete('destroy/{id}', [ChartsController::class, 'destroy']);
    Route::get('all', [ChartsController::class, 'all']);
    //Upload Excel FIle To Charts
    Route::post('upload-excel', [ChartsController::class, 'importExcel']);
    //Show Excel FIle
    Route::post('show-excel', [ChartsController::class, 'showFile']);
    //Show CHART FILESS
    Route::get('chartFiles/{id}', [ChartsController::class, 'chartFiles']);
    //Analysis Charts to get Data from Python
    Route::get('analysis/{id}', [ChartsController::class, 'analysis']);

    Route::post('EditExcelData', [ChartsController::class, 'EditExcelData']);
    Route::post('removeColumn', [ChartsController::class, 'removeColumn']);
    Route::post('addColumn', [ChartsController::class, 'addColumn']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'roles'], function () {
    Route::get('', [RoleController::class, 'index']);
    Route::post('', [RoleController::class, 'store']);
    Route::get('permissions', [RoleController::class, 'permissions']);
    Route::get('{id}', [RoleController::class, 'show']);
    Route::put('{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('{id}', [RoleController::class, 'destroy']);
    // Route::get('', 'RoleController@index')->name('roles.index');
    // Route::post('', 'RoleController@store')->name('roles.store');
    // Route::delete('{id}', 'RoleController@destroy')->name('roles.destroy');
});


/***************************************** helal ChartController **************************************************** */
Route::group(['middleware' => [], 'prefix' => 'helal/charts'], function () { //auth:sanctum

    Route::get('test', [ChartController::class, 'test']);
    Route::get('test2',[ChartController::class, 'test2']);
});
