<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;




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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'user_phone_num' => 'required|digits:10|numeric|unique:users,user_phone_num',
            'password' => 'required|min:6|confirmed',
            // 'password_cofirmation' => 'required|same:create_password',
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->user_phone_num = $request->input('user_phone_num');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::login($user);
        return redirect()->route('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $name = $request->input('name');
        $password = $request->input('password');
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            $user = User::where('name', $name)->first();
            Auth::login($user);
            return redirect()->route('getStudentData');
        } else {
            return back()->withErrors([
                'name' => 'Invalid credentials provided.',
            ]); ;
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
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
