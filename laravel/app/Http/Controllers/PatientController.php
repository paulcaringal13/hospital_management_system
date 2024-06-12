<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'Patient')->get();

        $patients->load('patient');

        return response()->json($patients);
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id . ",id",
                'contact' => 'required|min:10|max:10|unique:users,contact,' . $id . ",id",
                'gender' => 'required',
                'date_of_birth' => 'required|date',
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

        $patient = Patient::where('user_id', $id)->firstOrFail();

        $patient->update([
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender
        ]);

        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'contact' => $user->contact,
            'email' => $user->email,
            'role' => $user->role,
            'date_of_birth' => $patient->date_of_birth,
            'gender' => $patient->gender,
        ];

        $patients = User::where('role', 'Patient')->get();

        $patients->load('patient');

        return response([
            "status" => "Success",
            "patients" => $patients
        ]);
    }

    public function destroy($id)
    {
        try {
            // Find the user by id
            $user = User::findOrFail($id);

            // Check if the user has a role of 'Patient'
            if ($user->role === 'Patient') {
                // Delete the associated patient record
                Patient::where('user_id', $id)->delete();
            }

            // Delete the user
            $user->delete();

            // Retrieve all remaining patients
            $patients = User::where('role', 'Patient')->get();

            // Load the associated patient data
            $patients->load('patient');

            return response([
                "status" => "Success",
                "patients" => $patients
            ]);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
