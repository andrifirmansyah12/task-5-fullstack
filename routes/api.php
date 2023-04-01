<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\PostController;

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

Route::middleware('auth:api')->group(function () {

    Route::controller(PostController::class)->prefix('v1')->group(function () {
        Route::get('/posts', 'index');
        Route::post('/posts/store', 'store');
        Route::get('/posts/detail/{id}', 'show');
        Route::post('/posts/update/{id}', 'update');
        Route::delete('/posts/delete/{id}', 'destroy');
    });

});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::controller(LoginController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

});

Route::controller(HomeController::class)->group(function () {

    Route::get('/home', 'index');

});

Route::get('/user', function (Request $request) {

    return $request->user();

});

Route::controller(CategoryController::class)->group(function () {

    Route::get('/category', 'index');
    Route::post('/category/store', 'store');
    Route::post('/category/update/{id}', 'update');
    Route::delete('/category/delete/{id}', 'destroy');

});

Route::controller(ArticleController::class)->group(function () {

    Route::get('/article', 'index');
    Route::post('/article/store', 'store');
    Route::post('/article/update/{id}', 'update');
    Route::delete('/article/delete/{id}', 'destroy');

});
