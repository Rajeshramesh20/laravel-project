<?php
namespace App\Services;
use App\Models\Student;
use App\Models\subjects;
use App\Models\Group;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;


use App\Http\Requests\UpdateUserRequest;

class StudentService
{
   
    public function searchStudents($filters )
    {
        $firstname = $filters['firstname']??'';
        $lastname = $filters['lastname']??'' ;
        $email = $filters['email'] ??'';
        $subjectIds = $filters['subject_ids'] ?? [];
        $groupIds = $filters['group_ids'] ?? [];

        $response = Student::with(['group', 'subjects'])
            ->when($firstname, function ($query, $firstname) {
                return $query->where('firstname', 'like', "%{$firstname}%");
            })
            ->when($lastname, function ($query, $lastname) {
                return $query->where('lastname', 'like', "%{$lastname}%");
            })
            ->when($email, function ($query, $email) {
                return $query->where('email', 'like', "%{$email}%");
            })
            ->when($groupIds, function ($query) use ($groupIds) {
                return $query->whereIn('group_id', $groupIds);
            })
            ->when(!empty($subjectIds), function ($query) use ($subjectIds) {
                return $query->whereHas('subjects', function ($data) use ($subjectIds) {
                    $data->whereIn('subjects.id', $subjectIds);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(6);
            return $response;

    }

public function storeData($request){
        $student = Student::create($request);
        $student->save();
        $student->subjects()->attach($request['subject_ids']);
        return $student;
    }


public function editStudent($id){
        $edited_student = Student::with('group', 'subjects')->findOrFail($id);
        return    $edited_student;
    }


    public function updatestudent( $request, $id){
        $student = Student::find($id);
        $student->update($request);
        $subjectIds = $request['subject_ids'] ?? [];
        $student->subjects()->sync($subjectIds);
        return $student;
    }


    public function getAllSubjects()
    {
        return subjects::all();
    }



    public function getAllGroups()
    {
        return Group::all();

    }


    public function exportExcel(){

        return Excel::download(new StudentExport,'students.csv');  

    }

   public function importExcelData($request){


        $file = $request->file('file');

        Excel::import(new StudentImport, $file);
   }

}

?>