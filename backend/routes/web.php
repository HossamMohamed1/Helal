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

Route::get('test', function () {
    // $content = file_get_contents(public_path('excel/1672301408-part-1.json'));
    // $content = json_decode($content);
    // $content = collect($content)->map(function ($item, $index) {
    //     if ($index == 0) {
    //         return $item;
    //     }
    //     return [
    //         "Item {$index}",
    //         rand(10, 100),
    //         rand(20, 30),
    //     ];
    // });

    $content = [
        ["org", "WEB", "DEVOPPS "],
    ];

    $faker = Faker\Factory::create();
    // return [$faker];
    for ($i = 0; $i < 10; $i++) {
        $content[] = [
            $faker->name,
            rand(10, 100),
            rand(20, 30),
        ];
    }

    file_put_contents(public_path('excel/1672301408-part-1.json'), collect($content));
    // return $content;

    return ['message' => true];
});
Route::any('{path}', function () {
    try {
        return file_get_contents(public_path('build/index.html'));
    } catch (Throwable $th) {
        abort(404);
    }
})->where('path', '(.*)');