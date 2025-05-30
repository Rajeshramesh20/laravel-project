<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\StudentService;
use PDF;
use App\Jobs\ExportStudentsExcelJob;
use App\Models\ExportInfo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(StudentService $studentService)
    {
        try {
            $search_data = [];
            $students_data = $studentService->grtAllstudentData();
            $subjects = $studentService->getAllSubjects();
            $groups = $studentService->getAllGroups();
            $tasks =  $studentService->exportHistory();
            return view('get_data', compact('students_data', 'subjects', 'search_data', 'groups', 'tasks'));
        }
         catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Fail To Load Data :' . $e->getMessage());
        }
        // $students_data = Student::orderBy('id', 'desc')->get();
        // return view('get_data', compact('students_data'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create()

    {
        if (Gate::denies('is_user')) {
            return view('student_detais_form');
        }else{
            return back()->with('error','user connot be access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreUserRequest $request, StudentService $studentService)
    {
        try {
            if(Gate::denies('is_user')){
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

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id, StudentService $studentService)
    {
      
        try {
            if (Gate::denies('is_user')) {
                $edited_student = $studentService->editStudent($id);
            return view('edit_student_data', compact('edited_student'));
        }else{
        return back()->with('error', 'user connot be access');
        }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect('/getdata')->with('error', 'Faild To Edit Student' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateUserRequest $request, $id, StudentService $studentService)
    {
        try {
            if (Gate::denies('is_user')) {
            $data = $request->validated();
            $studentService->updatestudent($data, $id);
            return redirect('/getdata')->with('success', 'Student Updated Successfully!');
            }else{
                return back()->with('error', 'user connot be access');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Faild To Update Student' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        try {

            if (Gate::allows('is_superadmin')) {
                $student = Student::find($id);
                $student->delete();
                return redirect('/getdata')->with('success', 'Student Deleted Successfully!');
            }else{
                return back()->with('error', 'Only superadmin can delete students.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Faild To Delete Student' . $e->getMessage());
        }
    }

    public function searchOrPdf(Request $request, StudentService $studentService)
    {
        try {
            $search_data = $request->all();
            $students_data = $studentService->searchStudents($search_data);
            $subjects = $studentService->getAllSubjects();
            $groups = $studentService->getAllGroups();
            $tasks =  $studentService->exportHistory();

          
            if ($request->input('action') === 'pdf') {
                if (Gate::denies('is_user')) {
                    $students_data = $studentService->searchStudents($search_data, $paginate = false);
                $pdf = PDF::loadView('PdfDownload', compact('students_data',));
                return $pdf->download('filtered_students.pdf');
            } else {
                    return back()->with('error', 'user connot be access');
                }
        }

        
                return view('get_data', compact('students_data', 'subjects', 'search_data', 'groups','tasks'));
    
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Search Or Export Failed ');
        }
    }

    // public function pdfExport()

    // {
    //     $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'asc')->get();
    //     $pdf = PDF::loadView('PdfDownload', compact('students_data'));
    //     return $pdf->download('StudentsData.pdf');
    // }


    // public function pdfExport(Request $request, StudentService $studentService)
    // {
    //     $search_data = $request->all();
    //     $students_data = $studentService->searchStudents($search_data, false);
    //     $pdf = PDF::loadView('PdfDownload', compact('students_data'));
    //     return $pdf->download('filtered_students.pdf');
    // }  


    // public function excelExport(StudentService $studentService)
    // {
    //   return  $studentService->exportExcel();
    // }


    public function importExcelData(Request $request, StudentService $studentService)
    {
        try {
            if(Gate::allows('is_superadmin_or_admin')){

            $request->validate([
                'file' => 'required|file',
            ]);
            $action= $request->input('action');
            // dd($action);
            if ($action === 'mobile') {
                $studentService->importExcelModbileNumber($request);
                return redirect()->back()->with('success', 'Students Imported Successfully!');
            }elseif($action === 'student'){
                $studentService->importExcelData($request);
                return redirect()->back()->with('success', 'Students Imported Successfully!');
            }
        }else{
            return back()->with('error','only admin can  access');
        }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Import Faild' . $e->getMessage());
        }
    }
    
    // public function importExcelMobileNumber(Request $request, StudentService $studentService)
    // {
    //     try {
    //         $request->validate([
    //             'file' => 'required|file',
    //         ]);

    //         $studentService->importExcelModbileNumber($request);
    //         return redirect()->back()->with('success', 'Students Imported Successfully!');
    //     } catch (Exception $e) {
    //         Log::error($e->getMessage());
    //         return back()->with('error', 'Import Faild' . $e->getMessage());
    //     }
    // }

    public function excelExport(StudentService $studentService)
    {
        try {
            if(Gate::denies('is_user')){
      $studentService->exportExcel();

            return back()->with('success', 'Excel Export Started!');
        } else {
                return back()->with('error', 'user connot be access');
            }
     }
     catch (Exception $e) {
            Log::error($e->getMessage());
            return back()-> with('error', 'Faild To Start Excel Export' . $e->getMessage());
        }
    }


    public function getmark(StudentService $studentService){
    try{
            $data = $studentService->getmark();
            $mark = $data['students'];
            $subject = $data['student_marks'];
            $sub_average = $data['sub_average'];

            return view('getmark', compact('mark', 'subject', 'sub_average'));
        }
        catch(Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'faild to get mark' . $e->getMessage());
        }
    }
     
}
