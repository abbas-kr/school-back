<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::name('user.')->controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('index');
        Route::get('/users/{user:username}', 'index')->name('index');
        Route::put('/users/{user:username}', 'update')->name('update');
    });
});
