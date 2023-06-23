<?php
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhraseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Models\User;


//Store a new phrase.
Route::post('/phrases', function (Request $request) {
    return app(PhraseController::class)->store($request);
})->middleware(['auth:sanctum', 'role:' . User::ROLE_ADMIN]);

//Store a new image.
Route::post('/create/images', function (Request $request) {
    return app(ImageController::class)->store($request);
})->middleware(['auth:sanctum', 'role:' . User::ROLE_IMAGE_CREATOR]);

//Retrieve images by size.
Route::get('/images/{size}', function ($size) {
    return app(ImageController::class)->show($size);
});

//Soft delete a phrase.
Route::delete('/phrases/{id}', function ($id) {
    return app(PhraseController::class)->softDelete($id);
});

//User login.
Route::post('/login', [AuthController::class, 'loginUser']);