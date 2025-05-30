<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student;
use App\Models\StudentMark;
use App\Models\subjects;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentMobileNumberImportToFindStudentId implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $mobile = trim($row['mobile_number']);
            $student = Student::where('mobile_number', $mobile)->first();
            $subjects= subjects::all();
            if ($student) {
                foreach ($subjects as $subject) {
                    if (!StudentMark::where('student_id', $student->id)
                        ->where('subject_id', $subject->id)
                        ->exists()) {
                    StudentMark::firstOrCreate([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'mark' => rand(40, 100),
                    ]);
                }
                }
            }
        }
    }
}
