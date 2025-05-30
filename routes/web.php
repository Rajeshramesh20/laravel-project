<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\signupController;
use App\Models\Student;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Gate;

Route::get('/', function () {
    return view('welcome');
})->Middleware('guest'); 
Route::middleware(['auth'])->group(function () {   
Route::get('/students', [StudentController::class, 'create'])->name('create');
Route::post('/student', [StudentController::class, 'store'])->name('studentForm.store');
Route::get('/getdata', [StudentController::class, 'index'])->name('getStudentData');
Route::get('/getdata/{id}/edit', [StudentController::class, 'edit'])->name('studentData.edit');
Route::put('/getdata/{id}', [StudentController::class, 'update'])->name('studentData.update');
Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('studentData.delete');
Route::get('logout', [signupController::class, 'logout'])->name('logout');
Route::get('search', [StudentController::class, 'searchOrPdf'])->name('search');
Route::get('excel', [StudentController::class, 'excelExport'])->name('excel');
Route::get('pdf', [StudentController::class, 'pdfExport'])->name('pdf');
Route::post('/students/import', [StudentController::class, 'importExcelData'])->name('students.import');
// Route::post('/students/importmobile', [StudentController::class, 'importExcelMobileNumber'])->name('students.importmobile');
Route::get('getmark', [StudentController::class, 'getmark'])->name('getmark');
    // Route::get('/export-history', [StudentController::class, 'exportHistory'])->name('export.history');
});

Route::view('signup', 'auth.signup')->Middleware('guest')->name('signuppage');
Route::post('register', [signupController::class, 'register'])->name('user.register');
Route::view('login', 'auth.login')->Middleware('guest')->name('login');
Route::post('authenticate', [signupController::class, 'authenticate'])->name('authenticate');
