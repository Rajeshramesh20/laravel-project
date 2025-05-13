<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\student_subject_maping;
use App\Models\subjects;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $students = Student::all();
        $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'desc')->paginate(5);
        $subjects = subjects::all();

        return view('get_data', compact('students_data', 'subjects'));

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
    public function store(StoreUserRequest $request)
    {

        
        //    dd($request->all());
        // $details = $request->validated();
        // $data = Student::create($details);

        $details = $request->validated();
        $student=Student::create($details);
        $student->save();
        $student->subjects()->attach($request->subject_ids);


        // if ($request->has('subject_ids') ) {
        //     foreach ($request->subject_ids as $subjectId) {
        //         student_subject_maping::create([
        //             'subject_id' => $subjectId,
        //         ]);
        //     }
        // }



        return redirect('/getdata');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
   //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
      
        $edited_student = Student::findOrFail($id);
        $studentSubjectIds = $edited_student->subjects->pluck('id')->toArray();
        return view('edit_student_data', compact('edited_student', 'studentSubjectIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $student = Student::find($id);
        $student->update($request->validated());

        $subjectIds = $request->input('subject_ids', []);
        $student->subjects()->sync($subjectIds);

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
    public function search( Request $request){
      $search_data=$request->search;
        $firstname=$request->firstname;
        $lastname=$request->lastname;
        $email=$request->email;

        $students_data = Student::with(['group', 'subjects'])
            ->when($firstname, function ($query, $firstname) {
                return $query->where('firstname', 'like', "%{$firstname}%");
            })
            ->when($lastname, function ($query, $lastname) {
                return $query->where('lastname', 'like', "%{$lastname}%");
            })
            ->when($email, function ($query, $email) {
                return $query->where('email', 'like', "%{$email}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);
        $subjects = subjects::all();
        
        return view('get_data', compact('students_data','subjects'));
    }
}
