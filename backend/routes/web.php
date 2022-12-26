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

// Route::get('/', function () {
//     try {
//         return file_get_contents(public_path('build/index.html'));
//     } catch (Throwable $th) {
//         $command = "cd " . base_path('vue') . " && npm run build";
//         $message = "Product file doesnt exists please run $command";
//         return response()->json(['message' => $message], 500);
//     }

// });

Route::any('{path}', function () {
    try {
        return file_get_contents(public_path('build/index.html'));
    } catch (Throwable $th) {
        abort(404);
    }
})->where('path', '(.*)');