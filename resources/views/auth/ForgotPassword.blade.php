
@extends('layouts.app')
@section('style')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    .page-heading {
        text-align: center;
        padding: 20px 0;
        font-size: 28px;
        font-weight: bold;
        color: #333;
        background-color: #eaeaea;
        margin-bottom: 30px;
    }

    .form-container {
        width: 100%;
    }

    .form-box {
        width: 350px;
        background: white;
        padding: 25px 30px;
        margin: 0 auto; /* center horizontally */
        border-radius: 8px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input[type="email"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: -10px;
        margin-bottom: 10px;
    }

    button {
        width: 50%;
        background-color: #3498db;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin: 0 90px;
    }

    button:hover {
        background-color: #2980b9;
    }
</style>


@endsection
@section( 'content')
@if (session('message'))
<script>
    alert('{{ session('message')}}')
</script>
@endif
<h1 class="page-heading">Forgot Your Password?</h1>

<div class="form-container">
    <div class="form-box">
<form action="{{route('submit.forgotpassword.form')}}" method="POST">
    @csrf
    <label for="email">User Email</label>
    <input type="email" name="email" id="email" />
    @if ($errors->has('email'))
    <p class="error">
        {{$errors->first('eamil')}}
    </p>
    @endif
    <button type="submit" name="send_password_reset_link">Send  Link</button>
</form>
    </div>
</div>
@endsection