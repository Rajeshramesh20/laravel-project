<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\SendEmailRequest;


use App\Services\StudentService;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Student;

use Exception;


class StudentController extends Controller
{

    //  Display a listing of the stuudents.

    public function index(StudentService $studentService)
    {
        try {
            
            $search_data = [];
            $students_data = $studentService->getAllstudentData();
            $subjects = $studentService->getAllSubjects();
            $groups = $studentService->getAllGroups();
            $tasks =  $studentService->exportHistory();
            return view('students.get_data', compact('students_data', 'subjects', 'search_data', 'groups', 'tasks'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Fail To Load Data :' . $e->getMessage());
        }
        // $students_data = Student::orderBy('id', 'desc')->get();
        // return view('get_data', compact('students_data'));
    }


    //Show the form for creating a new student data.
    public function create()

    {
        if (Gate::denies('is_user')) {
            return view('students.student_detais_form');
        } else {
            return back()->with('error', 'user connot be access');
        }
    }


    // Store a newly created student in storage.
    public function store(StoreUserRequest $request, StudentService $studentService)
    {
        try {
            if (Gate::denies('is_user')) {
                $details = $request->validated();
                $studentService->storeData($details);
                return redirect('/getdata')->with('success', 'Student Created Successfully!');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Faild To Create Student' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

    public function show()
    {
        // $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'asc')->get();
        // return view('PdfDownload');
    }


    //  Show the form for editing the specified student.

    public function edit($id, StudentService $studentService)
    {

        try {
            if (Gate::denies('is_user')) {
                $edited_student = $studentService->editStudent($id);
                return view('students.edit_student_data', compact('edited_student'));
            } else {
                return back()->with('error', 'user connot be access');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect('/getdata')->with('error', 'Faild To Edit Student' . $e->getMessage());
        }
    }


    // Update the specified student  in storage.

    public function update(UpdateUserRequest $request, $id, StudentService $studentService)
    {
        try {
            if (Gate::denies('is_user')) {
                $data = $request->validated();
                $studentService->updatestudent($data, $id);
                return redirect('/getdata')->with('success', 'Student Updated Successfully!');
            } else {
                return back()->with('error', 'user connot be access');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Faild To Update Student' . $e->getMessage());
        }
    }


    //  Remove the specified student from storage.

    public function destroy($id)
    {
        try {

            if (Gate::allows('is_superadmin')) {
                $student = Student::find($id);
                $student->delete();
                return redirect('/getdata')->with('success', 'Student Deleted Successfully!');
            } else {
                return back()->with('error', 'Only superadmin can delete students.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Faild To Delete Student' . $e->getMessage());
        }
    }


    //  search or download pdf  to the specified student from storage.

    public function searchOrPdf(Request $request, StudentService $studentService)
    {
        try {
            $search_data = $request->all();
            $students_data = $studentService->searchStudents($search_data);
            // dd($students_data->toSql());   
            $subjects = $studentService->getAllSubjects();
            $groups = $studentService->getAllGroups();
            $tasks =  $studentService->exportHistory();

            if ($request->input('action') === 'pdf') {
                if (Gate::denies('is_user')) {
                    $students_data = $studentService->searchStudents($search_data, $paginate = false);
                    $pdf = Pdf::loadView('students.PdfDownload', compact('students_data',));
                    return $pdf->download('filtered_students.pdf');
                } else {
                    return back()->with('error', 'user connot be access');
                }
            }

            return view('students.get_data', compact('students_data', 'subjects', 'search_data', 'groups', 'tasks'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Search Or Export Failed ');
        }
    }



    //import students data to Store students in storage.
    public function importExcelData(Request $request, StudentService $studentService)
    {
        try {
            if (Gate::allows('is_superadmin_or_admin')) {

                $request->validate([
                    'file' => 'required|file',
                ]);
                $action = $request->input('action');
                // dd($action);
                if ($action === 'mobile') {
                    $studentService->importExcelModbileNumber($request);
                    return redirect()->back()->with('success', 'Students Imported Successfully!');
                } elseif ($action === 'student') {
                    $studentService->importExcelData($request);
                    return redirect()->back()->with('success', 'Students Imported Successfully!');
                }
            } else {
                return back()->with('error', 'only admin can  access');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Import Faild' . $e->getMessage());
        }
    }

   
    // dowload student data in excel
    public function excelExport(StudentService $studentService)
    {
        try {
            if (Gate::denies('is_user')) {
                $studentService->exportExcel();

                return back()->with('success', 'Excel Export Started!');
            } else {
                return back()->with('error', 'user connot be access');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Faild To Start Excel Export' . $e->getMessage());
        }
    }

    //get student mark in mark table
    public function getmark(StudentService $studentService)
    {
        try {
            $data = $studentService->getmark();
            $mark = $data['students'];
            $subject = $data['student_marks'];
            $sub_average = $data['sub_average'];
            

            return view('students.getmark', compact('mark', 'subject', 'sub_average'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'faild to get mark'.$e->getMessage());
        }
    }

   //send welcome email
    public function SendEmail(SendEmailRequest $request, StudentService $studentservices)
    {
        if (Gate::allows('is_superadmin_or_admin')) {

            $data = $request->validated();
        $studentservices->sendEmail($data );

        return back()->with('success', 'Email sent successfully!');
    }else{
            return back()->with('error', 'user connot be access');
        }
    }
  // mail view
    public function mailsend()
    {
        if (Gate::allows('is_superadmin_or_admin')) {
            return view('mail.welcomeEmailForm');
        } else {
            return back()->with('error', 'user connot be access');
        }

    }
}

