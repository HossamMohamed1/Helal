<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartsController;
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
});
Route::group(['middleware' => 'api', 'prefix' => 'charts'], function () {
    Route::get('index', [ChartsController::class, 'index']);
    Route::get('show/{id}', [ChartsController::class, 'show']);
    Route::post('create', [ChartsController::class, 'create']);
    Route::put('edit/{id}', [ChartsController::class, 'edit']);
    Route::delete('destroy/{id}', [ChartsController::class, 'destroy']);
    Route::get('all', [ChartsController::class, 'all']);
    Route::post('UploadExcelFile', [ChartsController::class, 'UploadExcelFile']);
    Route::post('EditExcelData', [ChartsController::class, 'EditExcelData']);
    Route::post('removeColumn', [ChartsController::class, 'removeColumn']);
    Route::post('addColumn', [ChartsController::class, 'addColumn']);
});
