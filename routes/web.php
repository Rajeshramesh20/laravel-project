<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\signupController;
use App\Models\Student;
use GuzzleHttp\Middleware;

Route::get('/', function () {
    return view('welcome');
})->Middleware('guest'); 
Route::middleware(['auth'])->group(function () {
Route::get('/students', [StudentController::class, 'create'])->name('create');
Route::post('/student', [StudentController::class, 'store'])->name('studentForm.store');
Route::get('/getdata', [StudentController::class, 'index'])->name('getStudentData');
Route::get('/getdata/{id}/edit', [StudentController::class, 'edit'])->name('studentData.edit');
Route::put('/getdata/{id}', [StudentController::class, 'update'])->name('studentData.update');
Route::delete('/getdata/{id}/delete', [StudentController::class, 'destroy'])->name('studentData.delete');
Route::get('logout', [signupController::class, 'logout'])->name('logout');
Route::get('search', [StudentController::class, 'search'])->name('search');

});

Route::view('signup', 'auth.signup')->Middleware('guest')->name('signuppage');
Route::post('store', [signupController::class, 'store'])->name('user.register');
Route::view('login', 'auth.login')->Middleware('guest')->name('login');
Route::post('authenticate', [signupController::class, 'authenticate'])->name('authenticate');

