<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware("web")->post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    return response()->json([
        'success'=> false,
        'message' => 'نام کاربری یا رمز عبور اشتباه است']
    );

})->name('login');


Route::middleware(['web', 'auth'])->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'user' => $request->user()
    ]);
});



Route::middleware(['web', 'auth'])->post('/logout', function (Request $request) {
    Auth::logout(); // خروج کاربر

    $request->session()->invalidate(); // باطل کردن سشن
    $request->session()->regenerateToken(); // تولید CSRF توکن جدید

    return response()->json([
        'success' => true,
        'message' => 'شما با موفقیت خارج شدید.'
    ]);
})->name('logout');


Route::middleware(['web', 'auth'])->put('/user', function (Request $request) {
    $user = Auth::user();

    $validated = $request->validate([
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
        'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
    ]);

    $user->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'اطلاعات شما با موفقیت به‌روزرسانی شد.',
        'user' => $user,
    ]);
});
