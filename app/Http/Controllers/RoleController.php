<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use Exception;
use Illuminate\Support\Facades\Log;


class RoleController extends Controller
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
    public function create(Request $request)
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
       $request->validate([
            'RoleName'=> 'required|string|unique:Roles,RoleName'
       ]);

       $role= Roles::create([
        'RoleName'=>$request->RoleName]);

        return response()->json([
            'status' => true,
            'data' => $role,
            'message' => 'userRole created successfully.'
        ]);
    }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Failed to create Role',
            ], 404);
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
        try {
            $edit_user_role = Roles::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $edit_user_role,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
        $request->validate([
            'RoleName' => 'required|string|unique:Roles,RoleName,' . $id,
        ]);

        
        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found.',
            ]);
        }

       
        $role->RoleName = $request->RoleName;
        $role->save();

        return response()->json([
            'status' => true,
            'data' => $role,
            'message' => 'Role updated successfully.',
        ]);
    }catch(Exception $e){


    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found.',
            ]);
        }

        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully.',
        ]);
    }catch(Exception $e){
        
    }
}
}
