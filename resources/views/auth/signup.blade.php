
@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section( 'content')
    <div class="wrapper">
        <div class="container">
            <h2>sign up</h2>
            <form action="{{route('user.register')}}" method="POST">
                @csrf
                <label for="name">Enter your Name</label>
                <input type="text" name="name" id="name"   value="{{old('name')}}"/>
                  @if ($errors->has('name'))
                <p class="error" id="name_error">
                 {{$errors->first('name')}}        
                </p>
                  @endif
                <label for="email"> Enter your email</label>
                <input type="email" name="email" id="email"   value="{{old('email')}}"/>
                 @if ($errors->has('email'))
                <p class="error" id="email_error">
                     {{$errors->first('email')}}
                </p>
                 @endif
                <label for="user_phone_num"> Enter your phone number</label>
                <input type="number" name="user_phone_num" id="user_phone_num"   value="{{old('user_phone_num')}}" />
                 @if ($errors->has('user_phone_num'))
                
                <p class="error" id="phone_num_error">
                  {{$errors->first('user_phone_num')}}
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
                <p class="error">
               
                </p>
                <p class="error">
                  
                </p>

                <div class="button-group">
                 {{-- <input type="submit" name="submit" id="submit"> --}}
                   <button type="submit" >Sign Up</button>
                    
                    <button type="reset" class="clear">clear</button>
                    
                </div>
            </form>
            <div class="sinupcontainer">
                <a href="{{route('login')}}" class="back">Back</a>
            </div>
        </div>
    </div>
@endsection