<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiViewController;


Route::get('/', function () {
    return view('welcome');
})->Middleware('guest'); 

Route::middleware(['auth'])->group(function () {  
//Crud routes
Route::get('/students', [StudentController::class, 'create'])->name('create');
Route::post('/student', [StudentController::class, 'store'])->name('studentForm.store');
Route::get('/getdata', [StudentController::class, 'index'])->name('getStudentData');
Route::get('/getdata/{id}/edit', [StudentController::class, 'edit'])->name('studentData.edit');
Route::put('/getdata/{id}', [StudentController::class, 'update'])->name('studentData.update');
Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('studentData.delete');
Route::get('search', [StudentController::class, 'searchOrPdf'])->name('search');
Route::get('getmark', [StudentController::class, 'getmark'])->name('getmark');

// Import & Export routes 
Route::get('excel', [StudentController::class, 'excelExport'])->name('excel');
Route::get('pdf', [StudentController::class, 'pdfExport'])->name('pdf');
Route::post('/students/import', [StudentController::class, 'importExcelData'])->name('students.import');

// Logout route
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

//email routes
Route::post('sendmail',[StudentController::class,'SendEmail'])->name('sendmail');
Route::get('mailsend', [StudentController::class, 'mailsend'])->name('mailsend');
});


Route::middleware('guest')->group(function () {

    // Signup & Login
    Route::view('signup', 'auth.signup')->name('signuppage');
    Route::post('register', [AuthController::class, 'register'])->name('user.register');

    Route::view('login', 'auth.login')->name('login');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

    // Forgot & Reset Password
    Route::prefix('password')->group(function () {
        Route::get('forgot', [AuthController::class, 'showforgotpasswordform'])->name('forgotpassword.form');
        Route::post('forgot', [AuthController::class, 'submitforgotpasswordform'])->name('submit.forgotpassword.form');

        Route::get('reset/{token}', [AuthController::class, 'showresetpasswordform'])->name('resetpassword.form');
        Route::post('reset', [AuthController::class, 'submitresetpasswordform'])->name('submitresetpassword.form');
    });
});


// Api viewes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/register', [ApiViewController::class, 'showRegisterForm'])->name('signuppage');
    Route::get('/login', [ApiViewController::class, 'showLoginForm'])->name('api.login');
    Route::get('/forgot-password', [ApiViewController::class, 'showForgotPasswordForm'])->name('forgotpassword.form');
    Route::get('/reset-password/{token}', [ApiViewController::class, 'showResetPasswordForm'])->name('resetpassword.form');
    Route::get('/students-list', [ApiViewController::class, 'showStudentList'])->name('studentList');
    Route::get('/studentInsetForm',[ApiViewController::class, 'showStudentDetailsForm'])->name('studentInset.Form');
    Route::get('/studentEditForm/{id}', [ApiViewController::class, 'showStudentEditForm'])->name('studentEdit.Form');
    Route::get('/studentMarkList', [ApiViewController::class, 'showStudentMarkList'])->name('StudentMarkList');
    Route::get('email',[ApiViewController::class, 'sendWelcomeEmail'])->name('welcomeEmail');
    Route::get('role',[ApiViewController::class, 'AddRole'])->name('storeRole');
    Route::get('menu', [ApiViewController::class, 'AddMenu'])->name('storeMenu');
    Route::get('permission',[ApiViewController::class, 'AddMenuPermission'])->name('menupermission');
}); 

//invoice
Route::get('/invoice',function(){
    return view('invoice');

});
