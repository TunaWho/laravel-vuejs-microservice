<?php

use App\Http\Controllers\Api\Auth\{
    LoginController,
    RegisterController,
};
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\UploadImageController;
use App\Http\Controllers\Api\User\UserController;
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

Route::post(
    '/login',
    [LoginController::class, 'login']
)->name('login');

Route::post(
    '/register',
    [RegisterController::class, 'register']
)->name('register');

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::post(
        'image/upload',
        UploadImageController::class
    );
    Route::apiResource(
        'users',
        UserController::class
    );
    Route::apiResource(
        'products',
        ProductController::class
    );
});
