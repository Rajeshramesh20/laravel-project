<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\Student;
use App\Models\subjects;
use App\Models\Group;
use App\Models\ExportInfo;
use App\Models\temp_student;

use App\Imports\StudentMobileNumberImportToFindStudentId;
use App\Imports\StudentImport;
use App\Jobs\ExportStudentsExcelJob;
use Maatwebsite\Excel\Facades\Excel;


class StudentService
{

    //serched student list

    public function searchStudents($filters, $paginate = true)
    {
        $firstname = $filters['firstname'] ?? '';
        $lastname = $filters['lastname'] ?? '';
        $email = $filters['email'] ?? '';
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
            ->orderBy('id', 'desc');

        // dd($response->toSql());   

        if (!$paginate) {
            $response = $response->get();
        } else {
            $response = $response->paginate(6);
        }
        return $response;
    }


    // store student data
    
    public function storeData($request)
    {
        $student = Student::create($request);
        $student->save();
        $student->subjects()->attach($request['subject_ids']);
        return $student;
    }

    // edit student data

    public function editStudent($id)
    {
        $edited_student = Student::with('group', 'subjects')->findOrFail($id);
        return $edited_student;
    }

    // update student data

    public function updatestudent($request, $id)
    {
        $student = Student::find($id);
        $student->update($request);
        $subjectIds = $request['subject_ids'] ?? [];
        $student->subjects()->sync($subjectIds);
        return $student;
    }


    // get all subject from subject table

    public function getAllSubjects()
    {
        return subjects::all();
    }


    // get all group from group table

    public function getAllGroups()
    {
        return Group::all();
    }

    // export excel student data   
    public function exportExcel()
    {
        $fileName = 'students_export_' . now()->format('Y_m_d_His') . '.csv';

        $task = ExportInfo::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'status' => 'initiated',
            'initiated_at' => now(),
        ]);
        ExportStudentsExcelJob::dispatch($task->id);
        return $task;
        // return Excel::download(new StudentExport, 'students.csv');
    }

    //import student  data

    public function importExcelData($request)
    {

        $file = $request->file('file');

        Excel::import(new StudentImport, $file);
    }

    //import mobile number to Assign mark 

    public function importExcelModbileNumber($request)
    {
        $file = $request->file('file');
        Excel::import(new StudentMobileNumberImportToFindStudentId, $file);
    }

    // get all students data from student table

    public function getAllstudentData()
    {
        $students_data = Student::with(['group', 'subjects'])->orderBy('id', 'desc')->paginate(5);
        return $students_data;
    }

    //display export history

    public function exportHistory()
    {

        $tasks = ExportInfo::with('user')->orderBy('created_at', 'desc')->get();
        return $tasks;
    }

    // get mark from marks table and display mark

    public function getmark()
    {
        $students = Student::whereHas('subjectsMark')
            ->with(['group', 'subjectsMark'])->get();
        $student_marks = [];
        $sub_count = [];
        foreach ($students as $student) {

            foreach ($student->subjectsMark as $subject) {

                $subname = $subject->subjectname;
                $marks = $subject->pivot->mark;

                if (!isset($student_marks[$subname])) {
                    $student_marks[$subname] = 0;
                    $sub_count[$subname] = 0;
                }
                $student_marks[$subname] += $marks;
                $sub_count[$subname]++;
            }
        }
        $sub_average = [];

        foreach ($student_marks as $subject => $total) {
            $sub_average[$subject] = round($total / $sub_count[$subject]);
        }

        $students = Student::whereHas('subjectsMark')
            ->with(['group', 'subjectsMark'])
            ->paginate(10);


        $students->getCollection()->transform(function ($student) {
            $marks = $student->subjectsMark->pluck('pivot.mark', 'subjectname')->toArray();
            $total = array_sum($marks);
            $average = round($total / count($marks));

            return [
                'id' => $student->id,
                'name' => $student->firstname . ' ' . $student->lastname,
                'group' => $student->group?->groupname,
                'marks' => $marks,
                'total' => $total,
                'average' => $average,
            ];
        });

        return [
            'students' => $students,
            'student_marks' => $student_marks,
            'sub_average' => $sub_average
        ];
    }
    public function sendEmail($data)
    {
        Mail::send(
            'mail.welcomeEmail',
            ['data' => $data['message']],
            function ($mail) use ($data) {
                $mail->to($data['email'])->subject($data['subject']);
            }
        );
    }

    //store student to temp_student_table
    public function storeTempStudent($data,$action='add'){
       $data['subject_ids'] = array_map('intval', $data['subject_ids']);
       $data['action'] = $action;
       $data['maker_by'] = auth()->user()->id;
       $data['maker_at'] = now();
        $student = temp_student::create($data);
        $student->save();
        return $student;
    }


}
