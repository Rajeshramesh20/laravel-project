@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/form_style.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection
{{-- @section('header')
@include('layouts.form_header')
@endsection --}}
<header>
    <div class="header_container">
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="logo">
        <div class="logoutcontainer">
            <a href='{{route('api.studentInset.Form')}}' class='create btn'>Add New</a>
            <a href="{{route('api.studentList')}}" class="table_view table_btn">View Details</a>
            <button class='logout btn' id="logoutBtn">Logout</button>
        </div>
    </div>
</header>
@section( 'content')
<div class="form_bg">
    <h1 class="std_heading">Api Student Details Form</h1>
    <div class="container">
        <h2 class="headding">Enter Your Details </h2>
        <form id="studentForm">
            <table>
                <tr>
                    <span>* required filds</span>
                    <th>
                        <span>*</span>
                        <label for="firstname">Firstname :</label>
                    </th>
                    <td class="mail-td">
                        <input type="text" name="firstname" id="firstname" placeholder="Enter your firstname">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        <span id="firstname_error"></span>
                    </td>

                </tr>

                <tr>
                    <th>
                        <span>*</span>
                        <label for="lastname">LastName :</label>
                    </th>
                    <td class="mail-td">
                        <input type="text" name="lastname" id="lastname" placeholder="Enter your lastname">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        <span id="lastname_error"></span>
                    </td>

                </tr>
                <tr>
                    <th>
                        <span>*</span>
                        <label for="email">Email id :</label>
                    </th>
                    <td class="mail-td">
                        <input type="email" name="email" id="email" placeholder="Enter your email id">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        <span id="email_error"></span>
                    </td>

                </tr>

                <tr>
                    <th>
                        <span>*</span>
                        <label for="mobile_number">Mobil number :</label>
                    </th>
                    <td class="mail-td">
                        <input type="number" name="mobile_number" id="mobile_number"
                            placeholder="Enter your mobile number">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        <span id="mobile_number_error"></span>
                    </td>
                </tr>
                <tr>
                    <th class="age-td">
                        <label for="age"> Age :</label>
                    </th>
                    <td>
                        <input type="number" name="age" id="age" placeholder="Enter your age">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="gender"> Gender :</label>
                    </th>
                    <td> <input type="radio" value="Male" name="gender" id="male">
                        <label for="male">Male</label>
                        <input type="radio" value="Female" name="gender" id="female">
                        <label for="female">Female</label>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="date_of_birth"> Date of birth :</label>
                    </th>
                    <td>
                        <input type="date" name="date_of_birth" id="date_of_birth">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="class"> Class :</label>
                    </th>
                    <td>
                        <input type="text" name="class" id="class" placeholder="Enter your class">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="batch"> Batch :</label>
                    </th>
                    <td>
                        <input type="number" name="batch" id="batch" placeholder="Enter your batch">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="medium"> Medium :</label>
                    </th>
                    <td> <input type="radio" value="Tamil" name="medium" id="medium_tamil">
                        <label for="tamil">Tamil</label>
                        <input type="radio" value="English" name="medium" id="medium_english">
                        <label for="english">English</label>
                    </td>
                </tr>
                <tr>
                    <th>
                    </th>
                    <td>
                        <span id="medium_error"></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="groupId"> Groups:</label>
                    </th>
                    <td>
                        <select name="group_id" id="groupId">
                            <option value="" disabled selected> Select Group </option>
                            <option value="1">Biology</option>
                            <option value="2">Computer Science</option>
                            <option value="3">Commerce</option>
                            <option value="4">Computer Application</option>
                            <option value="5">Business Maths</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for=""> Subjects:</label>
                    </th>
                    <td>
                        <input type="checkbox" name="subject_ids[]" id="subject_tamil" value="1">
                        <label for="subject_tamil">tamil</label>
                        <input type="checkbox" name="subject_ids[]" id="Kannada" value="2">
                        <label for="Kannada">Kannada</label>
                        <input type="checkbox" name="subject_ids[]" id="Malayalam" value="3">
                        <label for="Malayalam">Malayalam</label>
                        <input type="checkbox" name="subject_ids[]" id="Telugu" value="4">
                        <label for="Telugu">Telugu</label>
                        <input type="checkbox" name="subject_ids[]" id="Hindi" value="5">
                        <label for="Hindi">Hindi</label><br>
                        <input type="checkbox" name="subject_ids[]" id="Sanskrit" value="6">
                        <label for="Sanskrit">Sanskrit</label>
                        <input type="checkbox" name="subject_ids[]" id="French" value="7">
                        <label for="French">French</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" id="submit" value="Create">
                        <input type="reset" name="reset" id="reset" value="cancel">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

@endsection
@section('footer')
@include('layouts.form_footer')

<script>
    document.getElementById('studentForm').addEventListener('submit', function(event) {
        event.preventDefault();
      //get the token to localstorage
      const token = localStorage.getItem("token"); 

        if (!token) {
            alert("No token found. Please login first.");
            return;
        }

        const form = this;
        const formData = new FormData(form);
    
        // Setup XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', "http://127.0.0.1:8000/api/student", true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization','Bearer ' + token);
       
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Success response
                    alert('Student created successfully!');
                    window.location.href = "/api/students-list";
                    
                    //console.log(xhr.responseText);
                }else if(xhr.status === 403) {
                    alert(' your unauthorized  to  create');
                    window.location.href = "/api/students-list";
                }
                
                else if (xhr.status === 422) {
                    const response = JSON.parse(xhr.responseText);
                    // Validation error
                    if (response.errors) {
                    for (let key in response.errors) {
                        const errorElement = document.getElementById(`${key}_error`);
                        if (errorElement) {
                            errorElement.innerText = response.errors[key];
                        } 
                    }     
                } 
            }else {
                    // Other errors    
                    // console.log('Error', xhr.responseText);
                    alert('Something went wrong!.' + xhr.responseText);
                }
        }
        };
    
        xhr.send(formData);
    });

//logout
    
document.getElementById('logoutBtn').addEventListener('click', function () {
    if (!confirm("Are you sure you want to logout?")) return;

    const token = localStorage.getItem("token");

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "http://127.0.0.1:8000/api/logout", true);
    xhr.setRequestHeader("Authorization", "Bearer " + token);
    xhr.setRequestHeader("Accept", "application/json");

    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                localStorage.removeItem("token"); 
                alert("Logout successful");
                window.location.href = "/api/login";
            } else {
                alert("Logout failed");
            }
        }
    };

    xhr.send();
});
</script>

@endsection