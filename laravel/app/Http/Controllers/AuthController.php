<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'contact' => 'required|min:10|max:10|unique:users,contact',
                'gender' => 'required',
                'date_of_birth' => 'required|date',
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

        $patient = Patient::create([
            'user_id' => $user->id,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
        ]);

        $patients = User::where('role', 'Patient')->get();

        // Load the "patient" relationship for each patient user
        $patients->load('patient');


        return response()->json(['message' => 'User registered successfully', 'patients' => $patients], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->load('patient');
            $user->load('doctor');

            // Check if patient or doctor arrays are empty and remove them from the response if they are
            if ($user->patient->isEmpty()) {
                unset($user->patient);
            }

            if ($user->doctor->isEmpty()) {
                unset($user->doctor);
            }

            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 201);
        }

        return response()->json(['message' => 'Invalid email or password'], 401);
    }
}