<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pen', function (Request $request) {
    $pen = \App\PenHouse::select('pen_id')->where('farm_id', $request->json('farm_id'))
        ->where('bird_type', $request->json('bird'))->get();
    return $pen;
})->name('api.pen');

// Route::get('/sales', 'SalesController@test')->name('test.sales');