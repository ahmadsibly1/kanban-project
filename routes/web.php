<?php

use App\Http\Controllers\TaskController;
use Illuminate\Routing\RouteUri;
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

Route::get('/', function () {
    return view('home');
})->name('home');


// Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
// Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

// mengelompokan route task agar lebih efisien
Route::prefix('tasks')
    ->name('tasks.')
    ->controller(TaskController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}/update', 'update')->name('update');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{id}/delete', 'delete')->name('delete');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');

        // Progress Page
        Route::get('progress', 'progress')->name('progress');
    });
