<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;
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
Route::get('/get-user-role/{api_token}', [App\Http\Controllers\Api\BlogController::class, 'getUserRole']);
Route::get('/articles/get-published-articles', [App\Http\Controllers\Api\BlogController::class, 'getPublishedArticles']);

Route::group(['prefix' => 'admin'], function()
{
    Route::post('/articles/post-update/{id}', [App\Http\Controllers\Api\Admin\BlogController::class, 'postUpdate'])
        ->name('articles.post_update');
    Route::apiResource('articles', App\Http\Controllers\Api\Admin\BlogController::class);
//    Route::post('/articles/upload_image/{id}', [App\Http\Controllers\Api\Admin\BlogController::class, 'uploadImage']);
    Route::get('/users', [UserController::class, 'index']);
});

Route::group(['prefix' => 'member'], function()
{
    Route::post('/articles/post-update/{id}', [App\Http\Controllers\Api\Member\BlogController::class, 'postUpdate'])
        ->name('articles.post_update');
    Route::apiResource('articles', App\Http\Controllers\Api\Member\BlogController::class);
});
