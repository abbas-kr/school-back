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

