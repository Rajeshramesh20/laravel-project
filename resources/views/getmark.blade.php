@extends('layouts.app')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/student_list.css') }}">
<style>
  

</style>
@endsection
@section('content')

@if (session('success'))
<div>
    {{ session('success') }}
</div>
@endif
<div class="back">
    <a href="{{route('getStudentData')}}" class="table_view table_btn" >back</a>
</div>

<h1>Student Mark Table</h1>
<table>
    <thead>
        <tr>
        <th rowspan="2" >Student id</th>   
        <th rowspan="2">Student Name</th>
        <th rowspan="2">Group </th>
        <th colspan="7">Subjects</th>
        <th rowspan="2">Total</th>
        <th rowspan="2">Percentage</th>
    </tr>

    <tr>
        <th>Tamil</th>
        <th>Kannada</th>
        <th>Malayalam</th>
        <th>Telugu</th>
        <th>Hindi</th>
        <th>Sanskrit</th>
        <th>French</th>
    </tr>

</thead>

    <tbody>
        @foreach ($mark as $student)
            <tr>
                <td  class="align">{{ $student['id']}} </td>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['group'] }}</td>
                {{-- <td>{{ $student->group?->groupname }}</td>
                @php
                    $marks = $student->subjectsMark->pluck('pivot.mark', 'subjectname')->toArray();
                    $total= array_sum($marks);
                    $avg=$total/count($marks);
                    $average=round($avg);

                @endphp --}}
                <td class="align">{{ $student['marks']['tamil'] ?? '' }}</td>
                <td class="align">{{ $student['marks']['Kannada'] ?? '' }}</td>
                <td class="align">{{ $student['marks']['Malayalam'] ?? '' }}</td>
                <td class="align">{{ $student['marks']['Telugu'] ?? '' }}</td>
                <td class="align">{{$student['marks']['Hindi'] ?? '' }}</td>
                <td class="align">{{$student['marks']['Sanskrit'] ?? '' }}</td>
                <td class="align">{{ $student['marks']['French'] ?? '' }}</td>
                <td class="align">{{ $student['total']}}</td>
                <td class="align">{{  $student['average'] .'%'}}</td>
            </tr> 

        @endforeach
    </tbody>
       <tfoot>
           <tr>
                <th colspan="3">Total Mark In Subject Wise</th>
                <th class="align">{{ $subject['tamil']}}</th>
                <th class="align">{{ $subject['Kannada']}}</th>
                <th class="align">{{ $subject['Malayalam']}}</th>
                <th class="align">{{ $subject['Telugu']}}</th>
                <th class="align">{{ $subject['Hindi']}}</th>
                <th class="align">{{ $subject['Sanskrit']}}</th>
                <th class="align">{{ $subject['French']}}</th>
                <th colspan="2"></th>
           </tr>
           <tr>
                <th colspan="3">Average In Subject Wise</th>
                <th class="align">{{ $sub_average['tamil']}}</th>
                <th class="align">{{ $sub_average['Kannada']}}</th>
                <th class="align">{{ $sub_average['Malayalam']}}</th>
                <th class="align">{{ $sub_average['Telugu']}}</th>
                <th class="align">{{ $sub_average['Hindi']}}</th>
                <th class="align">{{ $sub_average['Sanskrit']}}</th>
                <th class="align">{{ $sub_average['French']}}</th>
                <th colspan="2"></th>
           </tr>
       </tfoot>
 
</table> 
<p>{{ $mark->appends(request()->query())->links() }}</p>

@endsection