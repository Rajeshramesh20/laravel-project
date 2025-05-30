<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Group;
use App\Models\subjects;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        //  dd($rows->first()->keys());

        foreach ($rows as $row) {

            $groupid = Group::where('groupname', $row['groupname'])->first();
            $subject = trim($row['subjects']);
            $subjectname = explode(',', $subject);
            $subjectIds = subjects::whereIn('subjectname', $subjectname)->pluck('id')->toArray();

            $student = Student::updateOrCreate(['email' => $row['email']],[
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'email' => $row['email'],
                'age' => $row['age'],
                'gender' => $row['gender'],
                'mobile_number' => $row['mobile_number'],
                'class' => $row['class'],
                'batch' => $row['batch'],
                'medium' => $row['medium'],
                'group_id' => $groupid ? $groupid->id : '',
                'date_of_birth' => $row['date_of_birth'],

            ]);
            if (!empty($subjectIds)) {
                $student->subjects()->syncWithoutDetaching($subjectIds);
            }
        }
    }
}
