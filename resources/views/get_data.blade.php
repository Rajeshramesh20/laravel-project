@extends('layouts.app')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/student_list.css') }}">
@endsection
@section('header')
@include('layouts.form_header')
@endsection

@section('content')

@if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

<script>
    //for subject dropdown
    function multiDropdown() {
        const dropdown = document.getElementById('dropdownList');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdownList');
        const btn = document.querySelector('.dropdown-btn');
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
    

   //for groups dropdown
    function toggleMultiselect() {
        const container = document.getElementById('multiselectContainer');
        container.style.display = (container.style.display === 'block') ? 'none' : 'block';
    }

    document.addEventListener('click', function (e) {
        const wrapper = document.querySelector('.custom-multiselect-wrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('multiselectContainer').style.display = 'none';
        }
    });


 //for export dropdown
    function toggleDropdown() {
    var dropdown = document.getElementById('exportDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
  }
</script>

<div class="wrapper">
    <div class="searchcontainer">
        <form action="{{route('search')}}" name="search">
            <input type="text" name="firstname" id="firstname" class="searchbox" placeholder="search firstname"
                value="{{$search_data['firstname']??''}}">
            <input type="text" name="lastname" id="lastname" class="searchbox" placeholder="search lastname"
                value="{{$search_data['lastname']??''}}">
            <input type="email" name="email" id="email" class="searchbox" placeholder="search email"
                value="{{$search_data['email']??''}}">
                
 {{-- dropedown for subject --}}
            <div class="dropdown-container">
                <div class="dropdown-btn" onclick="multiDropdown()">Select Subjects</div>
                <div class="dropdown-list" id="dropdownList">
                    @foreach ($subjects as $subject)
                    <label class="dropdown-item">
                        <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"    {{ in_array($subject->id, old('subject_ids', $search_data['subject_ids'] ?? [])) ? 'checked' : '' }}>
                        {{ $subject->subjectname }}
                    </label>
                    @endforeach
                </div>
            </div>

  {{-- dropedown for groups --}}
            <div class="custom-multiselect-wrapper">
                <div class="custom-multiselect-toggle" onclick="toggleMultiselect()">Select Groups</div>
                <div id="multiselectContainer" class="custom-multiselect-container">
                    <select name="group_ids[]" multiple class="custom-multiselect">
                        @foreach ($groups as $group)
                        <option value="{{ $group->id }}" {{ in_array($group->id, old('group_ids',
                            $search_data['group_ids'] ?? [])) ? 'selected' : '' }}>
                            {{ $group->groupname }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="search-btn" type="submit" name="action" value="search">search</button>
            <a href="{{route('getStudentData')}}" class="clear">clear</a>

             {{-- dropedown for export --}}
        <div class="dropdown" onclick="toggleDropdown()">
            <span class="download-btn"><i class="fas fa-download"></i> Download</span>
            <div id="exportDropdown" class="export-btn">
                <a href="{{route('pdf')}}" class="dowload-link">PDF</a><br>
                <button type="submit" name="action"  class="dowload-link"  value="pdf" style="all: unset; cursor: pointer;"> filterd PDF</button><br>
                <a href="{{route('excel')}}" class="dowload-link">Excel</a>
            </div>
        </div>
    </div>
        </form>

  
    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required class="file-upload"  id="file"/>
        <label for="file" class="custom-file-label"><i class="fa fa-file-upload" style="margin-right: 8px;"></i>Choose File</label>
        <button type="submit"  class="submit-btn">Import Students</button>
    </form>


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
                <th>Groups</th>
                <th>Subjects</th>
                <th>Actions</th>
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
                <td>
                    {{$data->group?->groupname}}
                </td>
                <td>
                     @foreach($data->subjects as $subject)
                    {{ $subject->subjectname }}<br>
                    @endforeach
                </td>
                <td>
                <a href="{{ route('studentData.edit',$data->id)}}" class='edite'><i class='fas fa-edit '
                            title='Edit'></i></a>
                    <form action="{{route('studentData.delete',$data->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class='delete'><i class='fas fa-trash' title='Delete'></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{--for pagination --}}
<p>{{$students_data->links()}}</p>


@endsection
@section('footer')
@include('layouts.form_footer')
@endsection