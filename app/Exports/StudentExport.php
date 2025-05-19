<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class StudentExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
     
        return Student::with(['group', 'subjects'])->get();
    }
    
    public function headings(): array
    {
        return [
            'id',
            'firstname',
            'lastname',
            'email',
            'age',
            'mobile_number',
            'medium',
             'group',
             'subjects'
           
        ];
    }

    public function map($student): array
    {
       
        return [
            $student->id,
            $student->firstname,
            $student->lastname,
            $student->email,
            $student->age,
            $student->mobile_number,
            $student->medium,
            $student->group?->groupname ??'',
            $student->subjects->pluck('subjectname')->implode(', '),
        ];
    }
   


}
