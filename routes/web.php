<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/test', function () {
    return view('test');
});

Route::middleware('auth')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('admin_dashboard');
    // });
    Route::get('/dashboard',[UserController::class, 'dashboard']);

    Route::prefix('/users')->group(function () {
        Route::get('/',[UserController::class, 'index']);
        Route::get('/create',[UserController::class, 'create']);
        Route::post('/store',[UserController::class, 'store']);
        Route::get('/edit/{id}',[UserController::class, 'edit']);
        Route::get('/show/{id}',[UserController::class, 'view']);
        Route::put('/update/{id}',[UserController::class, 'update']);
        Route::get('/delete/{id}',[UserController::class, 'delete']);
    });

    Route::prefix('/task')->group(function () {
        Route::get('/',[TaskController::class, 'index']);
        Route::get('/my-tasks',[TaskController::class, 'MyTask']);
        Route::get('/create',[TaskController::class, 'create']);
        Route::post('/store',[TaskController::class, 'store']);
        Route::get('/edit/{id}',[TaskController::class, 'edit']);
        Route::get('/show/{id}',[TaskController::class, 'view']);
        Route::put('/update/{id}',[TaskController::class, 'update']);
        Route::get('/delete/{id}',[TaskController::class, 'delete']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
