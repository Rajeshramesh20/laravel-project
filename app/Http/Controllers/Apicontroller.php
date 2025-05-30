<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\student as studentResources;
use App\Http\Resources\studentCollection;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Log;

class Apicontroller extends Controller
{
    //     public function index(StudentService $studentService)
    // {
    //             $students_data = $studentService->grtAllstudentData();
    //             if($students_data){
    //              return response()->json([
    //                 'status'=>true,
    //                 'data'=> $students_data,
    //              ]);
    //             }else{
    //             return response()->json(
    //                 [
    //                     'status' => false,
    //                     'error' => 'error',]);
    //             }

    // }
   

//student list  

    public function index(StudentService $studentService)
    {
        try {


            $students_data = $studentService->grtAllstudentData();

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
        } catch (Exception $e) {
            Log::error('Failed to Create  student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }
   


//edit student data

    public function edit($id, StudentService $studentService)
    {

        try {
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
        } catch (Exception $e) {
            Log::error('Failed to get edit  student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

//update student data

    public function update(UpdateUserRequest $request, $id, StudentService $studentService)
    {
        try {
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
        } catch (Exception $e) {
            Log::error('Failed to update student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }


//delete student data

    public function destroy($id)
    {
        try {
            $student = Student::find($id);
            $deletedId = $id;
            if (!$student) {
                return response()->json([
                    'error' => 'Student not found.'
                ]);
            }
            $student->delete();
            return response()->json([
                'message' => 'Student deleted successfully.',
                'deleted id is' => $deletedId
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }

// search student data or download pdf to search student

    public function searchOrPdf(Request $request, StudentService $studentService)
    {
        try {
            $search_data = $request->all();
            $students_data = $studentService->searchStudents($search_data);
            if ($request->input('action') === 'pdf') {
                $students_data = $studentService->searchStudents($search_data, $paginate = false);
                $pdf = PDF::loadView('PdfDownload', compact('students_data',));

                // return response()->json([
                //     'status' => 'success',
                //     'message' => 'PDF generated successfully',
                //     'pdf_base64' => base64_encode($pdf->output())
                // ]);
                return response($pdf->output(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="students.pdf"'
                ]);
                    
            }
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
            $request->validate([
                'file' => 'required|file',
            ]);

            $action = $request->input('action');

            if ($action === 'mobile') {
                $studentService->importExcelModbileNumber($request);
                // return redirect()->back()->with('success', 'Students Imported Successfully!');
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
                // return redirect()->back()->with('success', 'Students Imported Successfully!');
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid action provided.'
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed to importe mobilenum Or importe  student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }


//export student data to excel 
    public function excelExport(StudentService $studentService)
    {
        try {
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
            // return $studentService->exportExcel();
        } catch (Exception $e) {
            Log::error('Failed to Export   student data', ['error_message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Server Error']);
        }
    }
 
//get mark  for student

    public function getmark(StudentService $studentService)
    {
        try {
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

//sign up or register user

    public function register(RegisterUserRequest $request, StudentService $studentService)
    {
        try {
            $user = $request->validated();

            $user = $studentService->register($user);
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
    public function authenticate(LoginUserRequest $request, StudentService $studentService)
    {
        try {
            $data = $request->validated();

            $user = $studentService->authenticate($data);

            if (!Auth::attempt($user)) {

                return  response([
                    'error' => 'Invalid credentials provided'
                ]);
            }

            $token = auth()->user()->createToken('userToken')->accessToken;

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
}
