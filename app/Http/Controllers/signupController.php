<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\StudentService;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Log;

// use App\Http\Requests\LoginUserRequest;




class signupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterUserRequest $request, StudentService $studentService)
    {

        try {
            // $request->validate([
            //     'name' => 'required|string',
            //     'email' => 'required|email|unique:users,email',
            //     'user_phone_num' => 'required|digits:10|numeric|unique:users,user_phone_num',
            //     'password' => 'required|min:6|confirmed',
            //     // 'password_cofirmation' => 'required|same:create_password',
            // ]);

            // $user = new User;
            // $user->name = $request->input('name');
            // $user->email = $request->input('email');
            // $user->user_phone_num = $request->input('user_phone_num');
            // $user->password = Hash::make($request->input('password'));
            // $user->save();
              $user= $request->validated();

            $studentService->register($user);

            // Auth::login($user);
            
            return redirect()->route('login');

        } catch (Exception $e) {
            Log::error('Failed to fetch marks data', [
                'error_message' => $e->getMessage()
            ]);
            return back()->with('error', 'Registration  Failed' . $e->getMessage());
        }
    }

    public function authenticate(LoginUserRequest $request , StudentService $studentService)
    {
        try {

            // $request->validate([
            //     'name' => 'required',
            //     'password' => 'required',
            // ]);
            
            // $name = $request->input('name');
            // $password = $request->input('password');

            // if (Auth::attempt(['name' => $name, 'password' => $password])) {
            //     $user = User::where('name', $name)->first();
            //     Auth::login($user);
            //     return redirect()->route('getStudentData')->with('success', 'Logged in successfully!');
            // } else {
            //     return back()->withErrors([
            //         'name' => 'Invalid credentials provided.',
            //     ]);
            // }

             $data=$request->validated();

            $user = $studentService->authenticate($data);

            if (Auth::attempt($user)) {
                return redirect()->route('getStudentData')->with('success', 'Logged in successfully!');

            }  else {
                    return back()->withErrors([
                        'name' => 'Invalid credentials provided.',
                    ]);
                }
            }
            catch (Exception $e) {
                return back()->with('error', 'Login Failed' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return redirect()->route('login');
        } catch (Exception $e) {
            return back()->with('error', 'Logout Failed' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
