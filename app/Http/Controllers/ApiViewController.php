<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApiViewController extends Controller
{
    public function showRegisterForm()
    {
        return view('api_views.register');
    }

    public function showLoginForm()
    {
        return view('api_views.login');
    }

    public function showStudentList()
    {
        // if (Gate::denies('access-menu', ['studentData.list', 'viewonly'])) {
        //     abort(403, 'Unauthorized: You cannot view the student list.');
        // }

        return view('api_views.studentList');
    }

    public function showForgotPasswordForm()
    {
        return view('api_views.Forgotpassword_api');
    }

    public function showResetPasswordForm($token)
    {
        return view('api_views.ForgotPasswordLinkForm_api', ['token' => $token]);
    }

    public function showStudentDetailsForm()
    {

        if (Gate::denies('access-menu', ['studentInset.Form', 'viewonly'])) {
            abort(403, 'Unauthorized: You cannot view the Student Details Form.');
        }

        return view('api_views.StudentDetailsForm');
    }

    public function showStudentEditForm($id)
    {
        if (Gate::denies('access-menu', ['studentEdit.Form', 'viewonly'])) {
            abort(403, 'Unauthorized: You cannot view the Student Details Form.');
        }
        return view('api_views.EditStudentDataForm',['student_id' => $id]);
    }
    public function showStudentMarkList()
    {
        
        return view('api_views.StudentMarkList');
    }
    public function sendWelcomeEmail()
    {
        return view('mail.welcomeEmailFormApi');
    }

    
}
