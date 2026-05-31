<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StafftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response() -> json([
            'status' => true,
            'staff'  => Staff::all()


        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request -> validate([
            'name' => 'required',
            'user_name' => 'required',
            'skill'     => 'required',
            'role'      => 'required',
            'email'     => 'required|email|unique:staff,email',
            'password'  => 'required|confirmed',
        ]);

       $staff = Staff::create([
            'name' => $request -> name,
            'user_name' => $request -> user_name,
            'skill'     => $request -> skill,
            'role'      => $request -> role,
            'email'     => $request -> email,
            'password'  => Hash::make($request -> password)
        ]);

        return response() -> json([
            'status' => true,
            'message' => 'Staff Created Successfully',
            'Staff' => $staff
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
        return response() -> json([
            'status' => true,
            'Staff' => $staff
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
/**
 * Show the form data for editing the specified resource.
 */
public function edit(Staff $staff)
{
    return response()->json([
        'status' => true,
        'staff' => $staff
    ]);
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, Staff $staff)
{
    $request->validate([
        'name' => 'required',
        'user_name' => 'required',
        'skill' => 'required',
        'role' => 'required',
        'email' => 'required|email|unique:staff,email,' . $staff->id,
        'password' => 'nullable|confirmed',
    ]);

    $data = [
        'name' => $request->name,
        'user_name' => $request->user_name,
        'skill' => $request->skill,
        'role' => $request->role,
        'email' => $request->email,
    ];

    // password শুধু দিলে update হবে
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $staff->update($data);

    return response()->json([
        'status' => true,
        'message' => 'Staff updated successfully',
        'staff' => $staff
    ]);
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(Staff $staff)
{
    $staff->delete();

    return response()->json([
        'status' => true,
        'message' => 'Staff deleted successfully'
    ]);
}
    /**
     * Login Section
     */

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $staff = Staff::where('email', $request->email)->first();

    if (!$staff || !Hash::check($request->password, $staff->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = $staff->createToken('staff-token')->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'staff' => $staff,
        'token' => $token
    ]);
}

        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logout successful'
            ]);
        }





}
