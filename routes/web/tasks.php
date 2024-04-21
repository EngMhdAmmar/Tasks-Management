<?php

use App\Http\Controllers\TaskController;
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


Route::controller(TaskController::class)
    ->middleware(['auth'])
    ->prefix('tasks')
    ->group(function () {
        Route::get('/',  'index')->name('tasks.index');
        Route::post('/store',  'store')->name('tasks.store');
        Route::post('/update/{id}',  'update')->name('tasks.update');
        Route::get('/destroy/{id}',  'destroy')->name('tasks.destroy');
        Route::get('/my/',  'userTasks')->name('tasks.user');
        Route::get('/my/approveAndComplete/{id}',  'approveAndComplete')->name('tasks.approveAndComplete');
        Route::get('/all',  'all')->name('tasks.all');
    });
