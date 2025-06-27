<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\RoleMenuPermissionController;
use Maatwebsite\Excel\Row;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['auth:api'])->group(function () {
    Route::get('/getdata', [Apicontroller::class, 'index'])->name('getStudentData');
    Route::post('/student', [Apicontroller::class, 'store'])->name('student.store');
    Route::get('/getdata/{id}', [Apicontroller::class, 'edit'])->name('studentData.edit');
    Route::put('/update/{id}', [Apicontroller::class, 'update'])->name('studentData.update');
    Route::delete('/delete/{id}', [Apicontroller::class, 'destroy'])->name('studentData.delete');
    Route::get('search', [Apicontroller::class, 'searchOrPdf'])->name('search');
    Route::post('/import', [Apicontroller::class, 'importExcelData'])->name('students.import');
    Route::get('excel/{id}', [Apicontroller::class, 'excelExport'])->name('excel.export');
    Route::get('excel', [Apicontroller::class, 'initiatedexcelExport'])->name('excel.export.initiate');
    Route::get('/export-history', [Apicontroller::class, 'exportHistory'])->name('export.history');

    Route::get('getmark', [Apicontroller::class, 'getmark'])->name('getmark');

    Route::post('sendmail',[Apicontroller::class, 'SendEmail']);
    Route::get('logout', [Apicontroller::class, 'logout'])->name('logout');
    Route::post('/student/temp', [Apicontroller::class, 'storeTempStudent'])->name('student.tempstore');
    Route::get('tempStudent',[Apicontroller::class, 'tempStudentIndex'])->name('temp.student.list');
    // Route::get('getdata',[Apicontroller::class, 'getData']);
});

//auth
Route::post('register', [Apicontroller::class, 'register'])->name('user.register');
Route::post('authenticate', [Apicontroller::class, 'authenticate'])->name('authenticate');

//forgot password
Route::post('/forgot-password', [Apicontroller::class, 'submitforgotpasswordformapi']);
Route::post('/reset-password', [Apicontroller::class, 'submitResetPasswordForm']);

Route::middleware(['auth:api'])->group(function () {
//add role
Route::post('role',[RoleController::class, 'store']);
Route::get('role/{id}',[RoleController::class,'edit']);
Route::put('role/{id}',[RoleController::class,'update']);
Route::delete('role/{id}',[RoleController::class, 'destroy']);
Route::get('roleList',[RoleController::class, 'index']);
//add menu
Route::post('menu', [MenusController::class, 'store']);
Route::get('menu/{id}', [MenusController::class, 'edit']);
Route::put('menu/{id}', [MenusController::class, 'update']);
Route::delete('menu/{id}', [MenusController::class, 'destroy']);
Route::get('menuList', [MenusController::class, 'index']);
//add menu role permission
Route::post('MenuPermission', [RoleMenuPermissionController::class, 'store']);
Route::get('MenuPermissionList',[RoleMenuPermissionController::class,'index']);
Route::delete('MenuPermissionList/{id}', [RoleMenuPermissionController::class, 'destroy']);
});


Route::middleware(['auth:api'])->group(
    function () {
//invoice 
Route::post('invoice',[InvoiceController::class,'store']);
Route::get('generatepdf',[InvoiceController::class, 'generatePdf']);

//customer data
Route::post('customer', [InvoiceController::class, 'storeCustomerData']);
    });