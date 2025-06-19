
@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section( 'content')
    <div class="wrapper vh">
        <div class="container">
            <h2>change password</h2>
            <form action="{{route('submitresetpassword.form')}}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <label for="email"> Enter your email</label>
                <input type="email" name="email" id="email"   value="{{old('email')}}"/>
                 @if ($errors->has('email'))
                <p class="error" id="email_error">
                     {{$errors->first('email')}}
                </p>
                 @endif
                 <label for="password">create Password</label>
                 <input type="password" name="password" id="password" />
                  @if ($errors->has('password'))
                 <p class="error">
                      {{$errors->first('password')}}
                 </p>
                  @endif
                 <label for="password_confirmation">confrim Password</label>
                 <input type="password" name="password_confirmation" id="password_confirmation" />
                 <div class="button-group">
                 <button type="submit" name="">submit</button>
                 </div>
            </form>
            @endsection