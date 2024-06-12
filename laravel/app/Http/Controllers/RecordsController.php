<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordsController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            $records = Record::with(['doctor.user', 'patient.user'])->get();
        } elseif ($user->role === 'Doctor') {
            $doctor = $user->doctor->first(); // Get the first doctor record
            if ($doctor) {
                $records = Record::with(['doctor.user', 'patient.user'])
                    ->where('doctor_id', $doctor->id)
                    ->get();
            } else {
                $records = collect(); // Create an empty collection if no doctor record found
            }
        } else {
            $patient = $user->patient->first(); // Get the first patient record
            if ($patient) {
                $records = Record::with(['doctor.user', 'patient.user'])
                    ->where('patient_id', $patient->id)
                    ->get();
            } else {
                $records = collect(); // Create an empty collection if no patient record found
            }
        }

        return response()->json($records);
    }

    public function getOwnRecords()
    {
        $user = Auth::user();

        // Fetch records for the current user
        $records = Record::with(['doctor.user', 'patient.user'])
            ->where(function ($query) use ($user) {
                // Filter records for the current user
                $query->whereHas('doctor.user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                })->orWhereHas('patient.user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                });
            })
            ->get();

        return response()->json($records);
    }


    public function update(Request $request, $id)
    {
        // Validate the request input
        $validator = $request->validate([
            'remarks' => 'required|string',
        ]);

        $record = Record::findOrFail($id);

        // Update the record
        $record->update([
            'remarks' => $request->remarks,
        ]);

        // Get the current logged-in user
        $user = auth()->user();

        // Check if the user is a doctor or a patient
        $doctor = $user->doctor()->first(); // Get the first associated doctor
        $patient = $user->patient()->first(); // Get the first associated patient

        // Determine the role and retrieve the appropriate record
        if ($doctor) {
            // If the user is a doctor, filter by doctor_id
            $record = Record::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->firstOrFail();

            // Retrieve only the records that belong to the current doctor
            $records = Record::with('doctor.user', 'patient.user')
                ->where('doctor_id', $doctor->id)
                ->get();
        } elseif ($patient) {
            // If the user is a patient, filter by patient_id
            $record = Record::where('id', $id)
                ->where('patient_id', $patient->id)
                ->firstOrFail();

            // Retrieve only the records that belong to the current patient
            $records = Record::with('doctor.user', 'patient.user')
                ->where('patient_id', $patient->id)
                ->get();
        } else {
            // If the user is neither a doctor nor a patient, return an error
            return response([
                "status" => "Error",
                "message" => "User is neither a doctor nor a patient"
            ], 403);
        }



        // Return the response
        return response([
            "status" => "Success",
            "records" => $records
        ]);
    }

}
