<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhraseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/phrases', function (Request $request) {
    return app(PhraseController::class)->store($request);
})->middleware('auth:sanctum');

Route::post('/create/images', function (Request $request) {
    return app(ImageController::class)->store($request);
});

Route::get('/images/{size}', function ($size) {
    return app(ImageController::class)->show($size);
});

/*Route::get('/templates/{size}', function ($size) {
    return app(TemplateController::class)->show($size);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('phrases', PhraseController::class)->middleware('auth:sanctum');
*/

/*
Route::get('/phrases/list', function (Request $request) {
    return app(PhraseController::class)->getList($request);
})->middleware('auth:sanctum');*/

/*
Route::post('/phrases', function (Request $request) {
    return app(PhraseController::class)->store($request);
})->middleware('auth:sanctum');*/

/*Route::get('/phrases', function () {
    return app(PhraseController::class)->getRandomPhrase();
});

Route::delete('/phrases/{id}', function ($id) {
    return app(PhraseController::class)->softDelete($id);
});*/

Route::post('/login', [AuthController::class, 'loginUser']);

/*Route::post('/login', function (Request $request) {
    return app(AuthController::class)->login($request);
})->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');*/

//Route::group(['middleware' => 'auth:api'], function () {
    // Rutas protegidas por autenticación
//});

//Route::group(['middleware' => ['auth:api', 'admin']], function () {
//    Route::post('/phrases', 'PhraseController@store');
//});

