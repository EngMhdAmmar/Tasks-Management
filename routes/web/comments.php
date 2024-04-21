<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(CommentController::class)
    ->middleware(['auth'])
    ->group(function () {
        Route::post('/store/{task_id}','store')->name('comment.store');
        Route::get('/download/{id}','download')->name('comment.download');
    });
