<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\SendEmailRequest;

use App\Http\Resources\student as studentResources;
use App\Http\Resources\ExportInfoResource;
use App\Models\Student;
use App\Models\ExportInfo;

use App\Services\StudentService;
use App\Services\AuthServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;    

class Apicontroller extends Controller
{
  

    public function index(StudentService $studentService)
    {
        try {
            if (Gate::denies('access-menu', ['getStudentData', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            $students_data = $studentService->getAllstudentData();
        

            if ($students_data) {
                return  studentResources::collection($students_data);
              
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'error' => 'error',
                    ]
                );
            }
        } catch (Exception $e) {
            Log::error('Failed to fetch student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

    //insert student data

    public function store(StoreUserRequest $request, StudentService $studentService)
    {
        try {

            // if (Gate::denies('is_user')) {

                if (Gate::denies('access-menu', ['studentForm.store', 'fullaccess'])) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Unauthorized: No full access to create student.',
                                ], 403);
                            }
                            
                    $details = $request->validated();
            $StoredData = $studentService->storeData($details);
            if ($StoredData) {
                return response()->json([
                    'status' => true,
                    'data' => $StoredData,
                ]);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Failed to Create Student',
                    ]
                );
            }
        }
          /*  else{
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'unauthorized user admin can only access',
                        ]
                    ); 
            }
        } */
        catch (Exception $e) {
            Log::error('Failed to Create  student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

   
    //edit student data

    public function edit($id, StudentService $studentService)
    {

        try {
            if (Gate::denies('access-menu', ['studentData.edit', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            // if (Gate::denies('is_user')) {
                $edited_student = $studentService->editStudent($id);

            if ($edited_student) {
                return response()->json([
                    'status' => true,
                    'data' => $edited_student,
                ]);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Failed to  get edit Student',
                    ]
                );
            }
        // }else{
        //         return response()->json(
        //             [
        //                 'status' => false,
        //                 'message' => 'user connot be access',
        //             ]
        //         );
        //     }
        } catch (Exception $e) {
            Log::error('Failed to get edit  student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

    //update student data

    public function update(UpdateUserRequest $request, $id, StudentService $studentService)
    {
        try {
            if (Gate::denies('access-menu', ['studentData.update', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            // if (Gate::denies('is_user')) {
                $data = $request->validated();
            $updatedStudent = $studentService->updatestudent($data, $id);
            if ($updatedStudent) {

                return response()->json([
                    'status' => true,
                    'data' => $updatedStudent,
                ]);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Failed to update Student',
                    ]
                );
            }
        // }else{
        //         return response()->json(
        //             [
        //                 'status' => false,
        //                 'message' => 'user connot be access',
        //             ]
        //         );
        //     }
        } catch (Exception $e) {
            Log::error('Failed to update student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }


    //delete student data
    
    public function destroy($id)
    {
        
            try {
                if (Gate::denies('access-menu', ['studentData.delete', 'fullaccess'])) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unauthorized: No full access to create student.',
                    ], 403);
                }
            // if (!Gate::allows('is_superadmin')) {
            //     return response()->json([
            //         'success' => false,
            //         'error' => 'Only superadmin can delete students.'
            //     ]);
            // }

            $student = Student::find($id);
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'error' => 'Student not found.'
                ]);
            }

            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully.',
                'deleted_id' => $id
            ]);
        } catch (Exception $e) {
                Log::error('Failed to delete student', ['error' => $e->getMessage()]);

                return response()->json([
                    'success' => false,
                    'message' => 'Server Error'
                ]);
            
            }
        }
    

    // search student data or download pdf to search student

    public function searchOrPdf(Request $request, StudentService $studentService)
    {
        try {

             if (Gate::denies('access-menu', ['search', 'fullaccess'])) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unauthorized: No full access to create student.',
                    ], 403);
                }
            $search_data = $request->all();

            $students_data = $studentService->searchStudents($search_data);
            // if (Gate::denies('is_user')) {

            if (Gate::denies('access-menu', ['search', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            if ($request->input('action') === 'pdf') {
                $students_data = $studentService->searchStudents($search_data, $paginate = false);
             
                $pdf = Pdf::loadView('students.PdfDownload', compact('students_data'));

                return response($pdf->output(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="students.pdf"'
                ]);
            }
            // }else{
              
            //         return response()->json(
            //             [
            //                 'status' => false,
            //                 'message' => 'user connot be access',
            //             ]
            //         );
            // }
            return  studentResources::collection($students_data);
        } catch (Exception $e) {
            Log::error('Failed to generatedPDF Or Search student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

    // import student data and mobile number to  Assign mark 

    public function importExcelData(Request $request, StudentService $studentService)
    {
        try {

            // if (Gate::allows('is_superadmin_or_admin')) {

            if (Gate::denies('access-menu', ['students.import', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
                $request->validate([
                'file' => 'required|file',
            ]);

            $action = $request->input('action');

            if ($action === 'mobile') {
                $studentService->importExcelModbileNumber($request);
         
                return response()->json([
                    'status' => true,
                    'message' => 'Mobile numbers imported successfully!'
                ]);
            } elseif ($action === 'student') {
                $studentService->importExcelData($request);
                return response()->json([
                    'status' => true,
                    'message' => 'Students imported successfully!'
                ]);
              
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid action provided.'
                ]);
            }
        // }else{
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'only admins can  access'
        //         ]);
        //     }
        } catch (Exception $e) {
            Log::error('Failed to importe mobilenum Or importe  student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }


    // export student data to excel 

    public function initiatedexcelExport(StudentService $studentService)
    {
        try {
            // if (Gate::denies('is_user')) {
            if (Gate::denies('access-menu', ['excel.export.initiate', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            $excelExport = $studentService->exportExcel();

            if ($excelExport) {
                return response()->json([
                    'status' => true,
                    'message' => 'Excel Export Started!.',
                    'data' =>     $excelExport
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Excel Export Faild'
                ]);
            }
        // }
        // else{
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'only admins can  access'
        //         ]);
        //     }
    
        } catch (Exception $e) {
            Log::error('Failed to Export   student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

    public function excelExport($id)
    {
     try{
            if (Gate::denies('access-menu', ['excel.export', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            $excelExport= ExportInfo::find($id);

            // if (Gate::denies('is_user')) {
                if($excelExport->status !== 'completed'){
                    return response()->json(['error'=>'file not found']);
                }
            $path = storage_path('app/public/exports/' . $excelExport->file_name);


            return response()->download($path, $excelExport->file_name,['Content-Type'=>'text/csv']);

            // }else{
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'only admins can  access'
            //     ]);
            // }
        } catch (Exception $e) {
            Log::error('Failed to Export   student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

    //excel export history
    public function exportHistory(StudentService $studentService)
    {
        try {
            if (Gate::denies('access-menu', ['export.history', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }

            // if (Gate::denies('is_user')) {
                $tasks = $studentService->exportHistory();

            return response()->json([
                'status' => true,
                'message' => 'Export history fetched successfully.',
                'data' =>  ExportInfoResource::collection($tasks),
            ]);
        // }else{
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'only admins can  access'
        //         ]);
        //     }
        } catch (Exception $e) {
            Log::error('Failed to fetch export history', ['error_message' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Server Error'
            ]);
        }
    }

    //get mark  for student

    public function getmark(StudentService $studentService)
    {
        try {
            if (Gate::denies('access-menu', ['getmark', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            $data = $studentService->getmark();

            if ($data) {
                return response()->json([
                    'status' => true,
                    'message' => 'Marks data fetched successfully.',
                    'data' => [
                        'mark' => $data['students'],
                        'subject' => $data['student_marks'],
                        'sub_average' => $data['sub_average']
 
                    ]

                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to fetch marks',
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed to fetch marks ', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

    //send welcome mail
    public function SendEmail(SendEmailRequest $request, StudentService $studentservices)
    {
        try {
            // if (Gate::allows('is_superadmin_or_admin')) {
            if (Gate::denies('access-menu', ['SendEmail', 'fullaccess'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: No full access to create student.',
                ], 403);
            }
            
                $data = $request->validated();
            $studentservices->sendEmail($data);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully!'
            ]);
        // }else{
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'user can not be access',
        //         ]);
        //     }
        } catch (Exception $e) {
            Log::error('Failed to send email', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again later.'
            ]);
        }
    }

    //sign up or register user

    public function register(RegisterUserRequest $request, AuthServices $AuthService)
    {
        try {
            $user = $request->validated();

            $user = $AuthService->register($user);
            if ($user) {
                return response([
                    'status' => true,
                    'data' => $user,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Registration failed', ['error_message' => $e->getMessage()]);
            return response(['status' => false, 'message' => 'Registration failed.']);
        }
    }

    // login authenticate user
    public function authenticate(LoginUserRequest $request, AuthServices $AuthService)
    {
        try {
            $data = $request->validated();

            $user = $AuthService->authenticate($data);

            if (!Auth::attempt($user)) {

                return  response([
                    'error' => 'Invalid credentials provided'
                ]);
            }

            $token = auth()->user()->createToken('userToken')->accessToken;

            session(['api_token' => $token]);
            return response([
                'data' => auth()->user(),
                'token' => $token,
            ]);
        } catch (Exception $e) {
            Log::error('Authentication failed', ['error_message' => $e->getMessage()]);
            return response(['status' => false, 'message' => 'Login failed.']);
        }
    }


    //logout user
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully.'
            ]);
        } catch (Exception $e) {
            Log::error('Logout failed', ['error_message' => $e->getMessage(),]);
            return response()->json([
                'status' => false,
                'message' => 'Logout failed: ' . $e->getMessage()
            ]);
        }
    }
    

    //forgot password
    public function submitforgotpasswordformapi(ForgotPasswordRequest $request, AuthServices $AuthService)
    {
     try{
            $data = $request->validated();
            $AuthService->submitforgotpasswordform($data, 'mail.ForgotPassword_api');
            return response()->json([
            'success' => true,
            'message' => 'We have emailed you a reset password link.'
        ]);

    } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'failed to send email.',
                'error' => $e->getMessage()
            ]);
        }
}
//
    public function submitresetpasswordform(ResetPasswordRequest $request, AuthServices $authService)
    {
        try{
            $data = $request->validated();
            $data['token'] = $request->token;
            $authService->submitresetpasswordform($data);

        return response()->json([
            'success' => true,
            'message' => 'Your password has been changed successfully.'
        ]);
    }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'failed to change password.',
                'error' => $e->getMessage()
            ]);
        }
}
}


// public function getData(Request $request){
         
//          $tableName = $request->input('tableName') ;
//         $columnName  = $request->input('columnName');

//         $conditioncolumnName =$request->input('conditioncolumnName');
//         $condition = $request->input('condition');

//         $conditioncolumnName1 = $request->input('conditioncolumnName1');
//         $condition1 = $request->input('condition1');

//       /*  $jointableName= $request->input('jointableName');
//         $jointableName1 = $request->input('jointableName1');
//         $foreignkeysub= $request->input('foreignkey');
//         $foreignkeystd = $request->input('foreignkey1');

//         $foreigcolumn =  $request->input('foreigcolumn');
//         $foreigcolumn1 =  $request->input('foreigcolumn1');
        
//         $ownercolumn =  $request->input('ownercolumn');*/

//         $data = DB::table($tableName)


//     /*    if ($jointableName1 && $foreignkeystd) {
//             $data->join($jointableName1, $jointableName1.'.'.$foreignkeystd . '=' . $tableName . '.' . $foreignkeystd);
//         }

//         if($jointableName && $foreignkeysub ){
//            $data-> join($jointableName, $foreignkeysub.'='. $tableName.'.'. $foreignkeysub);
//         }

//         $data->select(
//             $tableName . '.' . $foreignkeystd,
//             $jointableName . '.' . $foreigcolumn,
//             $tableName . '.' . $foreignkeysub,
//             $jointableName1 . '.' . $foreigcolumn1,
//             $tableName . '.' . $ownercolumn
//         );*/

//        ->select($columnName)

//         ->whereIn( $conditioncolumnName, $condition)
//             ->whereIn( $conditioncolumnName1, $condition1)
//             ->get();

//                 return response()->json([
//             'success' => true,
//             'message' => 'success',
//             'data' => $data
         
//         ]);

//     }
// }



       /* $data = DB::table($tableName)
            ->join('students', 'students.id', '=', 'student_marks.student_id')
            ->join('subjects', 'subjects.id', '=', 'student_marks.subject_id')
            ->select(
                'student_marks.student_id',
                'students.firstname as student_name',
                'student_marks.subject_id',
                'subjects.subjectname as subject_name',
                'student_marks.mark'
            )
            ->whereIn("student_marks.$conditioncolumnName", $condition)
            ->whereIn("student_marks.$conditioncolumnName1", $condition1)
            ->get();
*/