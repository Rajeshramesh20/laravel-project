@extends('layouts.app')
@section('style')
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('css/student_list.css') }}">
@endsection
@section('header')
@include('layouts.form_header')
@endsection
@section('content')
  
        {{-- <a href='{{route('create')}}' class='create btn'>Add New</a>   --}}
    {{-- <a  href="{{route('logout')}}" class='btn logout' >Logout</a> </div> --}}
    <div class="wrapper">
    <h1> STUDENT DETAILS TABLE </h1>
    <table>
    <thead>
        <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>LastName</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Date of birth</th>
            <th>Mobile number</th>
            <th>Class</th>
            <th>Batch</th>
            <th>Medium</th>
            <th>Actions</th>
             <th>Groups</th>
            <th>Subjects</th>
           
        </tr>
    </thead>

    <tbody>
        @foreach ($students_data as $data)
                <tr>
                <td class='align'>{{ $data->id }}</td>
                <td>{{ $data->firstname }}</td>
                <td>{{ $data->lastname }}</td>
                <td>{{ $data->email }}</td>
                <td class='align'>{{ $data->age }}</td>
                <td>{{ $data->gender }}</td>
                <td>{{ $data->date_of_birth }}</td>
                <td>{{ $data->mobile_number }}</td>
                <td>{{ $data->class }}</td>
                <td>{{ $data->batch }}</td>
                <td>{{ $data->medium }}</td>   
                <td><a href="{{ route('studentData.edit',$data->id)}}" class='edite'><i class='fas fa-edit' title='Edit'></i></a>
                    <form action="{{route('studentData.delete',$data->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                <button type="submit"  class='delete'><i class='fas fa-trash' title='Delete'></i></button>
                    </form>
            {{-- <a href="{{ route('studentData.delete',$data->id)}}">delete</a> --}}
            </td>             
           <td>
               @foreach($data->groups as $group)
                    {{ $group->groupname }}<br>
                @endforeach
                {{-- {{$data->groups}} --}}
            </td>
            <td> @foreach($data->subjects as $subject)
                {{ $subject->subjectname }}<br>
            @endforeach</td>
      
            </tr>
        @endforeach
    </tbody>
</table>

</div>

<p>{{$students_data->links()}}</p>
@endsection
 @section('footer')
   @include('layouts.form_footer')
   @endsection
