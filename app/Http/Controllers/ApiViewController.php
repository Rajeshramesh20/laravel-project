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
        return view('api_views.StudentDetailsForm');
    }

    public function showStudentEditForm($id)
    {
        return view('api_views.EditStudentDataForm', ['student_id' => $id]);
    }
    public function showStudentMarkList()
    {
        return view('api_views.StudentMarkList');
    }
    public function sendWelcomeEmail()
    {
        return view('mail.welcomeEmailFormApi');
    }
    public function AddRole()
    {
        return view('api_views.RoleForm');
    }
    public function AddMenu()
    {
        return view('api_views.MenuForm');
    }
    public function AddMenuPermission()
    {
        return view('api_views.PermissionForm');
    }
    public function Addinvoice()
    {
        return view('api_views.invoice_form');
    }
}
