<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/register', function (Request $request) {
    \App\Models\User::create([
        'firstname' => 'a',
        'lastname' => 'b',
        'username' => '1',
        'password' => \Illuminate\Support\Facades\Hash::make('1'),
    ]);
});

Route::middleware("web")->post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    return response()->json(['success'=> false, 'message' => 'نام کاربری یا رمز عبور اشتباه است']);
})->name('login');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

