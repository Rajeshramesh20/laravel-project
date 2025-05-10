@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section( 'content')
    <div class="wrapper cover">
        <div class="container">
            <h2>Login</h2>
            <form action="{{route('authenticate')}}" method="POST">
                @csrf
                <label for="name">User Name</label>
                <input type="text" name="name" id="name" />
                @if ($errors->has('name'))
                <p class="error">
                    {{$errors->first('name')}}
                </p>
                @endif
                <label for="password">Password</label>
                <input type="password" name="password" id="password" />
                @if ($errors->has('password'))
                <p class="error">
                    {{$errors->first('password')}}
                </p>
                @endif
                <div class="button-group">
                    <button type="submit" name="student_login_button">Log In</button>
                    <button type="reset" class="clear">clear</button>
                </div>

            </form>
            <div class="sinupcontainer">
                <a href="{{route('signuppage')}}" class="signup-btn">Sign Up</a>
            </div>

        </div>
    </div>
    @endsection
