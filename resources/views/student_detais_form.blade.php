{{-- @if($errors)
@dd($errors)
@endif --}}
@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/form_style.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection
@section('header')
@include('layouts.form_header')
@endsection
@section( 'content')
<div class="form_bg">
    <h1 class="std_heading">Student Details Form</h1>
    <div class="container">
        <h2 class="headding">Enter Your Details </h2>
        <form action="{{route('studentForm.store')}}" method="post">
            @csrf
            <table>
                <tr>
                    <span>* required filds</span>
                    <th>
                        <span>*</span>
                        <label for="firstname">Firstname :</label>
                    </th>
                    <td class="mail-td">
                        <input type="text" name="firstname" id="firstname" placeholder="Enter your firstname"
                            value="{{old('firstname')}}">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        @if ($errors->has('firstname'))
                        <span> {{$errors->first('firstname')}}</span>
                        @endif
                    </td>

                </tr>

                <tr>
                    <th>
                        <span>*</span>
                        <label for="lastname">LastName :</label>
                    </th>
                    <td class="mail-td">
                        <input type="text" name="lastname" id="lastname" placeholder="Enter your lastname"
                            value="{{old('lastname')}}">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        @if ($errors->has('lastname'))
                        <span> {{$errors->first('lastname')}}</span>

                        @endif
                    </td>

                </tr>


                <tr>
                    <th>
                        <span>*</span>
                        <label for="email">Email id :</label>
                    </th>
                    <td class="mail-td">
                        <input type="email" name="email" id="email" placeholder="Enter your email id"
                            value="{{old('email')}}">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        @if ($errors->has('email'))
                        <span> {{$errors->first('email')}}</span>

                        @endif
                    </td>

                </tr>

                <tr>
                    <th>
                        <span>*</span>
                        <label for="mobile_number">Mobil number :</label>
                    </th>
                    <td class="mail-td">
                        <input type="number" name="mobile_number" id="mobile_number"
                            placeholder="Enter your mobile number" value="{{old('mobile_number')}}">
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        @if ($errors->has('mobile_number'))
                        <span>{{$errors->first('mobile_number')}}</span>

                        @endif
                    </td>

                </tr>
                <tr>
                    <th class="age-td">

                        <label for="age"> Age :</label>
                    </th>
                    <td>
                        <input type="number" name="age" id="age" placeholder="Enter your age" value="{{old('age')}}">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="gender"> Gender :</label>
                    </th>
                    <td> <input type="radio" value="Male" name="gender" id="male" {{ old('gender')=='Male' ? 'checked'
                            : '' }}>
                        <label for="male">Male</label>
                        <input type="radio" value="Female" name="gender" id="female" {{ old('gender')=='Female'
                            ? 'checked' : '' }}>
                        <label for="female">Female</label>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="date_of_birth"> Date of birth :</label>
                    </th>
                    <td>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{old('date_of_birth')}}">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="class"> Class :</label>
                    </th>
                    <td>
                        <input type="text" name="class" id="class" placeholder="Enter your class"
                            value="{{old('class')}}">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="batch"> Batch :</label>
                    </th>
                    <td>
                        <input type="number" name="batch" id="batch" placeholder="Enter your batch"
                            value="{{old('batch')}}">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="medium"> Medium :</label>
                    </th>
                    <td> <input type="radio" value="Tamil" name="medium" id="tamil">
                        <label for="tamil">Tamil</label>
                        <input type="radio" value="English" name="medium" id="english">
                        <label for="english">English</label>
                    </td>
                </tr>
                <tr>
                    <th>

                    </th>
                    <td>
                        @if ($errors->has('medium'))
                        <span> {{$errors->first('medium')}}</span>

                        @endif
                    </td>

                </tr>
                <tr>
                    <th>
                        <label for="groupId"> Groups:</label>
                    </th>
                    <td>
                        <select name="group_id" id="groupId">
                            <option value="" disabled selected> Select Group </option>
                            <option value="1" {{ old('groupId')==1 ? 'selected' : '' }}>Biology</option>
                            <option value="2" {{ old('groupId')==2 ? 'selected' : '' }}>Computer Science</option>
                            <option value="3" {{ old('groupId')==3 ? 'selected' : '' }}>Commerce</option>
                            <option value="4" {{ old('groupId')==4 ? 'selected' : '' }}>Computer Application</option>
                            <option value="5" {{ old('groupId')==5 ? 'selected' : '' }}>Business Maths</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for=""> Subjects:</label>
                    </th>
                    <td>
                     
                        <input type="checkbox" name="subject_ids[]" id="tamil" value="1">
                        <label for="tamil">tamil</label>
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
@endsection