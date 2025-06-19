@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section( 'content')

@if (session('success'))
<script>
    alert('{{ session('success')}}')
</script>


@endif
<div class="wrapper cover">
    <div class="container">
        <h2>Send Mail</h2>
        <form action="{{route('sendmail')}}" method="POST">
            @csrf
            <label for="email">To Email Address</label>
            <input type="email" name="email" id="toemail" />
            @if ($errors->has('email'))
            <p class="error">
                {{$errors->first('email')}}
            </p>
            @endif
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" />
            @if ($errors->has('subject'))
            <p class="error">
                {{$errors->first('subject')}}
            </p>
            @endif
            <label for="message">Message</label>
            <textarea name="message" id="message" cols="10" rows="10" class="message">
            </textarea>
            @if ($errors->has('message'))
            <p class="error">
                {{$errors->first('message')}}
            </p>
            @endif
            <div class="button-group">
                <button type="submit" name="send_email">send</button>
                <button type="reset" class="clear">clear</button>
            </div>
        </form>
        <div class="sinupcontainer">
            <a href="{{route('getStudentData')}}" class="signup-btn">back</a>
        </div>

    </div>
</div>
@endsection