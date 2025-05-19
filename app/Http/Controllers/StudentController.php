<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\StudentService;
use PDF;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(StudentService $studentService)
    {
        $search_data = [];
        $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'desc')->paginate(5);
        $subjects = $studentService->getAllSubjects();
        $groups = $studentService->getAllGroups();

        return view('get_data', compact('students_data', 'subjects', 'search_data', 'groups'));

        // $students_data = Student::orderBy('id', 'desc')->get();
        // return view('get_data', compact('students_data'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {
        return view('student_detais_form');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreUserRequest $request, StudentService $studentService )
    {
        $details = $request->validated();
        $studentService->storeData($details);
        return redirect('/getdata');
    }

   /**
     * Display the specified resource.
     */ 

    public function show(Student $student  )
    {
        $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'asc')->get();
        return view('PdfDownload', compact('students_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id , StudentService $studentService)
    {
        $edited_student = $studentService->editStudent($id);
        return view('edit_student_data', compact('edited_student'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateUserRequest $request, $id , StudentService $studentService)
    {
        $data = $request->validated();
        $studentService->updatestudent($data, $id);
        return redirect('/getdata');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return redirect('/getdata');
    }


    public function searchOrPdf(Request $request, StudentService $studentService)
    {
        //$search_data=$request->search;

        $search_data = $request->all();
        $students_data = $studentService->searchStudents($search_data);
        $subjects = $studentService->getAllSubjects();
        $groups = $studentService->getAllGroups();

        if($request->input('action')==='pdf'){
            $pdf = PDF::loadView('PdfDownload', compact('students_data'));
            return $pdf->download('filtered_students.pdf');
        }

        return view('get_data', compact('students_data', 'subjects', 'search_data', 'groups'));
    }


    public function pdfExport()

    {
        $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'asc')->get();
        $pdf = PDF::loadView('PdfDownload', compact('students_data'));
        return $pdf->download('StudentsData.pdf');
    }


    // public function pdfExport(Request $request, StudentService $studentService)
    // {
    //     $search_data = $request->all();
    //     $students_data = $studentService->searchStudents($search_data, false);
    //     $pdf = PDF::loadView('PdfDownload', compact('students_data'));
    //     return $pdf->download('filtered_students.pdf');
    // }  


    public function excelExport(StudentService $studentService)
    {
      return  $studentService->exportExcel();
    }


    public function importExcelData(Request $request , StudentService $studentService )
    {  

         $request->validate([
            'file' => 'required|file',
           ]);

        $studentService->importExcelData($request );
        return redirect()->back()->with('success','Students imported successfully!');

    }
}