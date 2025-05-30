<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apicontroller;

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


Route::middleware(['auth:api'])->group(function(){
    Route::get('/getdata', [Apicontroller::class, 'index'])->name('getStudentData');
    Route::post('/student', [Apicontroller::class, 'store'])->name('studentForm.store')->middleware('can:is_superadmin_or_admin_or_manager');
    Route::get('/getdata/{id}', [Apicontroller::class, 'edit'])->name('studentData.edit')->middleware('can:is_superadmin_or_admin');
    Route::put('/update/{id}', [Apicontroller::class, 'update'])->name('studentData.update')->middleware('can:is_superadmin_or_admin');
    Route::delete('/delete/{id}', [Apicontroller::class, 'destroy'])->name('studentData.delete')->middleware('can:is_superadmin');
    Route::get('search', [Apicontroller::class, 'searchOrPdf'])->name('search');
    Route::post('/students/import', [Apicontroller::class, 'importExcelData'])->name('students.import')->middleware('can:is_superadmin_or_admin');
    Route::get('excel', [Apicontroller::class, 'excelExport'])->name('excel')->middleware('can:is_superadmin_or_admin');
    Route::get('getmark', [Apicontroller::class, 'getmark'])->name('getmark');
    Route::get('logout', [Apicontroller::class, 'logout'])->name('logout');
 

});

Route::post('register', [Apicontroller::class, 'register'])->name('user.register');
Route::post('authenticate', [Apicontroller::class, 'authenticate'])->name('authenticate');
 