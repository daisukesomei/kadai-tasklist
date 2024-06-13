<?php

use Illuminate\Support\Facades\Route;

//USEで該当のコントローラを読み込む(tasklita)を今回は読み込む
use App\Http\Controllers\TasksController;

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

Route::get('/', [TasksController::class, 'index']);
Route::resource('tasks', TasksController::class);