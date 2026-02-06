<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});
Route::resource('tasks', App\Http\Controllers\TaskController::class);
