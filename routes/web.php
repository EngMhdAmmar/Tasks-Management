<?php

use App\Models\Task;
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

Route::group([], function() {
    include 'web/auth.php';
    include 'web/tasks.php';
    include 'web/comments.php';
});



// Route::group([], function () {
//     Route::get('/comments/index/{task_id}', [CommentController::class, 'index']);
// });

// Route::get('/', function() {
//         return Task::all();
//     });



Route::get('/', function() {
        return redirect()->route('tasks.index');
    })->middleware(['auth']);
