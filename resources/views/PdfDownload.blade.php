@extends('layouts.app')
@section('style')
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 {{-- <link rel="stylesheet" href="{{ asset('css/student_list.css') }}"> --}}
 {{-- <link rel="stylesheet" href="{{public_path('css/student_list.css') }}"> --}}
 <style>
    @page {
        margin: 20mm;
        size: A4;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 18px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
        vertical-align: top;
    }

    th {
        background-color: #f2f2f2;
    }

    .align {
        text-align: center;
    }

    .nowrap {
        white-space: nowrap;
    }
</style>
@endsection
@section('content')
<h1> STUDENT DETAILS TABLE </h1>
<table>
<thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Age</th>
        <th>Mobile NO</th>
        {{-- <th>Gender</th> -
        <th>Date of birth</th>
        <th>Class</th>
        <th>Batch</th> --}}
        <th>Medium</th>
         <th>Groups</th>
        <th>Subjects</th>
    </tr>
</thead>
<tbody>
    @foreach ($students_data as $data)
            <tr>
            <td class='align'>{{ $data->id }}</td>
            <td>{{ $data->firstname }} {{ $data->lastname }}</td>
            <td>{{ $data->email }}</td>
            <td class='align'>{{ $data->age }}</td>
            {{-- <td>{{ $data->gender }}</td> --}}
            {{-- <td>{{ $data->date_of_birth }}</td> --}}
            <td>{{ $data->mobile_number }}</td>
            {{-- <td>{{ $data->class }}</td>
            <td>{{ $data->batch }}</td> --}}
            <td>{{ $data->medium }}</td>   
       <td>
            {{$data->group?->groupname}}   
        </td> 
        <td> @foreach($data->subjects as $subject)
            {{ $subject->subjectname }}<br>
        @endforeach
    </td>
        </tr>
    @endforeach
</tbody>
</table>

@endsection