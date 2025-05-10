@extends('layouts.app')
@section('style')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
   <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection
@section('content')
    <div class="wrapper">
        <div class="container">
            <h1 class="school-name">Wellcome To Bright School</h1>
            <a href="{{route('login')}}" class="login-btn">Login</a>
        </div>
    </div>
@endsection