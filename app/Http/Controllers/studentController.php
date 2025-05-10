<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\student_subject_maping;


class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
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
        $details = $request->validated();
        $data = Student::create($details);
        $data->save();
    //     //    echo "test";
    //     $studenrId= student_subject_maping::firstOrCreate(['student_id'=>$data->id,
    //         'group_id' => $data->group_id,
    //         'subject_id' => $data->subject_ids,
    // ]);
        

        return redirect('/getdata');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {

        $students_data = Student::with(['groups', 'subjects'])->orderBy('id', 'desc')->get();
        return view('get_data', compact('students_data'));

        // $students_data = Student::orderBy('id', 'desc')->get();
        // return view('get_data', compact('students_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
      
        $edited_student = Student::findOrFail($id);
        return view('edit_student_data', compact('edited_student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $student = Student::find($id);
        $student->update($request->validated());
        return redirect('/getdata');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        // $x = $student->toArray();
        // dd($x);
        $student->delete();
        return redirect('/getdata');
    }
}
