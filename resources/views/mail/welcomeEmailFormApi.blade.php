@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section( 'content')


<div class="wrapper cover">
    <div class="container">
        <h2>Send Mail Api</h2>
        <form id="sendMailForm">
      
            <label for="email">To Email Address</label>
            <input type="email" name="email" id="email" />
            <p class="error" id="email_error"> </p>
           
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" />
        
            <p class="error" id="subject_error">
               
            </p>

            <label for="message">Message</label>
            <textarea name="message" id="message" cols="10" rows="10" class="message"></textarea>
    
            <p class="error" id="message_error">
           
            </p>
    
            <div class="button-group">
                <button type="submit" name="send_email">send</button>
                <button type ="button" class="clear" onclick="document.querySelector('form').reset();">clear</button>
            </div>
        </form>
        <div class="sinupcontainer">
            <a href="{{route('api.studentList')}}" class="signup-btn">back</a>
        </div>

    </div>
</div>


<script>

    document.getElementById('sendMailForm').addEventListener('submit', function (e) {
        e.preventDefault();
    const email = document.getElementById('email').value.trim();
    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();

    const token = localStorage.getItem('token'); 
    // console.log("Token:", token);
    // console.log("Sending:", { email, subject, message });

    const data = {
        email: email,
        subject: subject,
        message: message
    };

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://127.0.0.1:8000/api/sendmail', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);

    
    xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert('Email sent successfully!');
                    console.log(xhr.responseText);
                } 
                else if(xhr.status === 403 ){
                    alert(' your unauthorized  to send email')
                }
                else if (xhr.status === 422) {
                    const response = JSON.parse(xhr.responseText);
                    
                    if (response.errors) {
                        for (let key in response.errors) {
                            const errorElement = document.getElementById(`${key}_error`);
                            if (errorElement) {
                                errorElement.innerText = response.errors[key][0];
                            }
                        }
                    }
                } else {
                    alert('Failed to send email: ' + xhr.statusText);
                    console.error(xhr.responseText);
                }
            }
        };
        xhr.send(JSON.stringify(data));
    });

</script>
@endsection