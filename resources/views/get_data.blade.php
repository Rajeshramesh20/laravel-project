@extends('layouts.app')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/student_list.css') }}">
@can('is_user')
<style>
 .submit-btn{
    padding: 10px 20px;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    border: none;
    margin: 100px;
}
.searchcontainer {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 50px;
}
</style>  
@endcan

@endsection
@section('header')
@include('layouts.form_header')
@endsection

@section('content')

@if (session('success'))
<script>
    alert('{{ session('success')}}')
</script>
   

@endif
{{-- @if (session('error'))
<div>
    {{ session('error') }}
</div>
@endif --}}

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
  function toggleImportDropdown(){
    var importdropdown = document.getElementById('importDropdown');
    importdropdown.style.display = importdropdown.style.display === 'none' ? 'block' : 'none';
  }



//export status modal
  document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById("myModal");
  const openBtn = document.getElementById("openModalBtn");
  const closeBtn = document.getElementById("closeModalBtn");

  openBtn.onclick = () => {
    modal.style.display = "block";
  }

  closeBtn.onclick = () => {
    modal.style.display = "none";
  }

  window.onclick = (event) => {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});



//error modal

function closeModal() {
        document.getElementById('errorModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('error'))
            document.getElementById('errorModal').style.display = 'block';
        @endif
    });
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
                        <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" {{ in_array($subject->id,
                        old('subject_ids', $search_data['subject_ids'] ?? [])) ? 'checked' : '' }}>
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
           
            @can('is_superadmin_or_admin_or_manager')
                
         
            {{-- dropedown for export --}}
            <div class="dropdown" onclick="toggleDropdown()">
                <span class="download-btn"><i class="fas fa-download"></i> Download</span>
                <div id="exportDropdown" class="export-btn">
                    {{-- <a href="{{route('pdf')}}" class="dowload-link">PDF</a><br> --}}
                    <button type="submit" name="action" class="dowload-link pdfbtn" value="pdf">PDF</button> <br> 
                    <a href="{{route('excel')}}" class="dowload-link">Excel</a>
                    <i id="openModalBtn" class="fa-solid fa-circle-info info" ></i>
                </div>
            </div>
            @endcan
            <a href="{{route('getStudentData')}}" class="clear">clear</a>
    </div>
    
    </form>
    @can('is_superadmin_or_admin')

<div class="importcontainer">
    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required class="file-upload" id="file" />
        <label for="file" class="custom-file-label"><i class="fa fa-file-upload" style="margin-right: 8px;"></i>Choose
            File</label>
            <div class="dropdown" onclick="toggleImportDropdown()">
                <span class="download-btn"><i class="fas fa-file-import"></i>  Import</span>
                <div id="importDropdown" class="export-btn" style="display: none;">
                    <button type="submit" name="action" value="student" class="submit-btn">Import Students</button><br>
                    <button type="submit" name="action" value="mobile" class="submit-btn">Import Mobile</button>
                </div>
            </div>
    </form> 
    @endcan
<a href="{{route('getmark')}}" class="submit-btn getmark">Viwe student mark</a>
</div>
   
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
                @can('is_superadmin_or_admin')
                <th>Actions</th>
                @endcan
               
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
                @can('is_superadmin_or_admin')
                <td>
                     <a href="{{ route('studentData.edit',$data->id)}}" class='edite'><i class='fas fa-edit '
                        title='Edit'></i></a>
                     @endcan
                   

                            @can('is_superadmin')
                            <form action="{{route('studentData.delete',$data->id)}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class='delete' onclick="return confirm('Are you sure you want to delete this student?')"><i class='fas fa-trash' title='Delete'></i></button>
                            </form>
                            @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="myModal" class="modal">
  <div class="modal-content">
    <i id="closeModalBtn" class="fa-solid fa-xmark close" style="font-size: 24px;"></i>
    <h2>Export Excel History</h2>
<table>
    <tr>
        <th>Id</th>
        <th>User</th>
        <th>File</th>
        <th>Status</th>
        <th>Initiated At</th>
        <th>Completed At</th>
        <th>Download</th>
    </tr>
    
    @foreach($tasks as $task)
    <tr>
        <td>{{ $task->id}}</td>
        <td>{{ $task->user->name ?? 'System' }}</td>
        <td>{{ $task->file_name }}</td>
        <td>{{ $task->status }}</td>
        <td>{{ $task->initiated_at }}</td>
        <td>{{ $task->completed_at }}</td>
        <td>
            @if($task->status == 'completed')
            <a href="{{ asset('storage/exports/' . $task->file_name) }}"><i class="fas fa-download"></i>Download</a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
  </div>
</div>

{{--for pagination --}}
<p>{{ $students_data->appends(request()->query())->links() }}</p>

{{-- error modal --}}
<div id="errorModal" class="custom-modal">
    <div class="custom-modal-content">
      <span class="custom-close" onclick="closeModal()">&times;</span>
      <h2 class="error">Error</h2>
      <p>{{ session('error') }}</p>
      <button onclick="closeModal()">Close</button>
    </div>
  </div>

@endsection
@section('footer')
@include('layouts.form_footer')
@endsection