<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function index()
    {
        $doctors = User::where('role', 'Doctor')->get();

        $doctors->load('doctor');

        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        $validator = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'contact' => 'required|min:10|max:10|unique:users,contact',
                'specialization' => 'required|string',
                'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ],
            [
                'email.unique' => 'The email has already been taken.',
                'contact.unique' => 'The contact has already been taken.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
                'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
        ]);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
        ]);

        $doctors = User::where('role', 'Doctor')->get();

        $doctors->load('doctor');


        return response()->json(['message' => 'User registered successfully', 'doctors' => $doctors], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id . ",id",
                'contact' => 'required|min:10|max:10|unique:users,contact,' . $id . ",id",
                'specialization' => 'required|string',
            ],
            [
                'email.unique' => 'The email has already been taken.',
                'contact.unique' => 'The contact has already been taken.',
            ]
        );

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email
        ]);

        $doctor = Doctor::where('user_id', $id)->firstOrFail();

        $doctor->update([
            'specialization' => $request->specialization,
        ]);

        $doctors = User::where('role', 'Doctor')->get();

        $doctors->load('doctor');

        return response([
            "status" => "Success",
            "doctors" => $doctors
        ]);
    }

    public function destroy($id)
    {
        try {
            // Find the user by id
            $user = User::findOrFail($id);

            if ($user->role === 'Doctor') {
                // Delete the associated patient record
                Doctor::where('user_id', $id)->delete();
            }

            // Delete the user
            $user->delete();

            $doctors = User::where('role', 'Doctor')->get();

            // Load the associated patient data
            $doctors->load('doctor');

            return response([
                "status" => "Success",
                "doctors" => $doctors
            ]);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
