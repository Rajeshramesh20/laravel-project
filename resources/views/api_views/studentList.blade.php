@extends('layouts.app')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/student_list.css') }}">
<style>
    #pagination {
        margin-top: 20px;
    }

    .page-btn {
        padding: 5px 20px;
        margin: 0 3px;
        cursor: pointer;
        border: 1px solid #ccc;
        background-color: white;
        border-radius: 4px;
        font-size: 14px;
    }

    .page-btn.active {
        background-color: #333;
        color: white;
        font-weight: bold;
        border-color: #ccc;
    }

    .pageDiv {
        text-align: center;
    }

</style>
@endsection
{{--
@section('header')
@include('layouts.form_header')
@endsection --}}
@section('content')
@if (session('success'))
<script>
    alert('{{ session('
        success ') }}')

</script>
@endif
<header>
    <div class="header_container">
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="logo">
        <div class="logoutcontainer">
            <a href='{{route('api.studentInset.Form')}}' class='create btn' id="createBtn">Add New</a>
            <a href="{{route('api.studentList')}}" class="table_view table_btn">View Details</a>
            <button class='logout btn' id="logoutBtn">Logout</button>
        </div>
    </div>
</header>
<div class="wrapper">
    <div class="searchcontainer">
        <form id="searchForm">
            <input type="text" name="firstname" id="firstname" class="searchbox" placeholder="search firstname">
            <input type="text" name="lastname" id="lastname" class="searchbox" placeholder="search lastname">
            <input type="email" name="email" id="email" class="searchbox" placeholder="search email">

            {{-- dropedown for subject --}}
            <div class="dropdown-container">
                <div class="dropdown-btn" onclick="multiDropdown()">Select Subjects</div>
                <div class="dropdown-list" id="dropdownList">
                  {{-- inputs from js --}}

                </div>
            </div>

            {{-- dropedown for groups --}}
            <div class="custom-multiselect-wrapper">
                <div class="custom-multiselect-toggle" onclick="toggleMultiselect()">Select Groups</div>
                <div id="multiselectContainer" class="custom-multiselect-container">
                    <select name="group_ids[]" multiple class="custom-multiselect" id="groupDropdown">
                         {{--option from js  --}}
                    </select>
                </div>  
            </div>
                  

            <button class="search-btn" type="submit" id="searchBtn">search</button>

            <div class="dropdown" onclick="toggleDropdown('exportDropdown')" id="dowloadBtn">
                <span class="download-btn"><i class="fas fa-download"></i> Download</span>
                <div id="exportDropdown" class="export-btn">
                    <button type="submit" class="dowload-link pdfbtn" id="downloadPdfBtn">PDF</button> <br>
                    <button class="dowload-link pdfbtn" onclick="downloadExcelFile()">Excel</button>
                    <i id="openModalBtn" class="fa-solid fa-circle-info info"></i>
                </div>
            </div>
        </form>
        <button class="clear" onclick="document.getElementById('searchForm').reset()">clear</button>
    </div>

    <div class="importcontainer">


        <form id="importForm" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required class="file-upload" id="file" />
            <label for="file" class="custom-file-label"><i class="fa fa-file-upload"
                    style="margin-right: 8px;"></i>Choose
                File</label>
            <div class="dropdown" onclick="toggleImportDropdown()">
                <span class="download-btn"><i class="fas fa-file-import"></i> Import</span>
                <div id="importDropdown" class="export-btn" style="display: none;">
                    <button type="button"  onclick="submitImport('student')"  class="submit-btn">Import Students</button><br>
                    <button type="button"  onclick="submitImport('mobile')"  class="submit-btn">Import Mobile</button>
                </div>
            </div>
        </form>

        <a href="{{route('api.StudentMarkList')}}" class="submit-btn getmark">Viwe student mark</a>
        <a href="{{route('api.welcomeEmail')}}"  class="submit-btn getmark mail" id="sendmail">send mail</a> 
        <a href="{{route('api.invoice')}}" class="submit-btn getmark mail">create invoice</a>
        <div class="dropdown" onclick="toggleDropdown('permission')" id="permissionBtn" >
            <span class="download-btn">Permission</span>
            <div id="permission" class="export-btn">
                <div class="addrole"><a href="{{route('api.storeRole')}}"  class="submit-btn rolebtn">Add role</a><i class="fas fa-eye"  onclick="openRoleModal()"></i></div> 
                <div class="addrole"> <a href="{{route('api.storeMenu')}}"  class="submit-btn rolebtn"  >Add Menu</a> <i class="fas fa-eye" onclick="openMenuModal()"></i></div>
                    <div class="addrole"><a href="{{route('api.menupermission')}}"  class="submit-btn rolebtn" >Add Permission</a> <i class="fas fa-eye" onclick="openPermissionModal()"></i></div>
            </div>
        </div>
   
    </div>

    <h1> STUDENT DETAILS FROM API</h1>

    <table id="student-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
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
                <th class="actionBtnCol">Actions</th>
            </tr>
        </thead>
        <tbody id="tbody"></tbody>
    </table>
    <div id="pagination" class="pageDiv"></div>
</div>


{{-- export history modal --}}

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
            <tbody id="exportHistoryBody"></tbody>
        </table>
    </div>
</div>

{{-- modal --}}
<!-- role and menu Data Modal -->
<div id="dataModal" class="modal" style="display:none;">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModaldata()">&times;</span>
      <h2 id="headding">menutable</h2>
  
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="modalTableBody">

        </tbody>
      </table>
  
      <div style="text-align:right; margin-top:10px;">
        <button onclick="closeModaldata()">Close</button>
      </div>
    </div>
  </div>
  {{-- permission modal --}}
  <div id="permissionModal" class="modal" style="display:none;">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2 id="headding">Permission Table</h2>
  
      <table >
        <thead>
          <tr>
            <th>ID</th>
            <th>Role ID</th>
            <th>Menu ID</th>
            <th>Full Access</th>
            <th>View Only</th>
            <th>Hidden</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="modalTablepermissionBody"></tbody>
      </table>
  
      <div style="text-align:right; margin-top:10px;">
        <button onclick="closeModal()">Close</button>
      </div>
    </div>
  </div>

@endsection
@section('footer')
@include('layouts.form_footer')
<script src="{{asset('js/studentListApi.js')}}"></script>
@endsection
{{-- 
<div id="todoModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeTodoModal()">&times;</span>
    <h2>Checker To-Do List</h2>

    <table border="1" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Maker</th>
          <th>Made At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="todoTableBody"></tbody>
    </table>
  </div>
</div>

<button onclick="loadTodoList()">Open To-Do List</button>




--}}