<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'read_article'])->name('article.read');

Route::group(['middleware'=>'roles', 'roles'=> ['admin'], 'prefix' => 'admin'], function()
{
    Route::prefix('dashboard')->group(function () {
        Route::get('/blog', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.blog');
    });
});

Route::group(['middleware'=>'roles', 'roles'=> ['member'], 'prefix' => 'member'], function()
{
    Route::prefix('dashboard')->group(function () {
        Route::get('/blog', [App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard.blog');
    });
});

