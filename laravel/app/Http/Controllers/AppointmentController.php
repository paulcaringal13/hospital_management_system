<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            $appointments = Appointment::with(['doctor.user', 'patient.user'])->get();
        } elseif ($user->role === 'Doctor') {
            $doctor = $user->doctor->first(); // Get the first doctor record
            if ($doctor) {
                $appointments = Appointment::with(['doctor.user', 'patient.user'])
                    ->where('doctor_id', $doctor->id)
                    ->get();
            } else {
                $appointments = collect(); // Create an empty collection if no doctor record found
            }
        } else {
            $patient = $user->patient->first(); // Get the first patient record
            if ($patient) {
                $appointments = Appointment::with(['doctor.user', 'patient.user'])
                    ->where('patient_id', $patient->id)
                    ->get();
            } else {
                $appointments = collect(); // Create an empty collection if no patient record found
            }
        }

        return response()->json($appointments);
    }


    public function getOwnAppointments()
    {
        $user = Auth::user();

        // Fetch appointments for the current user
        $appointments = Appointment::with(['doctor.user', 'patient.user'])
            ->where(function ($query) use ($user) {
                // Filter appointments for the current user
                $query->whereHas('doctor.user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                })->orWhereHas('patient.user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                });
            })
            ->get();

        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'appointment_time' => 'required',
                'status' => 'string',

            ],
            [
                'patient_id.required' => 'Please select a doctor.',
            ]
        );

        $user = Auth::user();
        $patientId = null;

        // Check if the authenticated user is a patient
        if ($user->role === 'Patient') {
            $patientId = $user->patient->first()->id; // Access the first patient record and retrieve its id
        } else {
            // If not a patient, return error response
            return response()->json(['error' => 'Only patients can create appointments'], 403);
        }

        // Create the appointment
        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'status' => $validated['status'],
            'appointment_time' => $validated['appointment_time'],
        ]);

        $appointments = Appointment::with('doctor.user', 'patient.user')->where('patient_id', $patientId)->get();

        return response()->json(['appointments' => $appointments], 201);
    }

    public function finishAppointment(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'appointment_time' => 'required',
                'status' => 'string',
                'remarks' => 'string',
            ],
        );

        $user = Auth::user();
        $doctorId = null;

        // Check if the authenticated user is a patient
        if ($user->role === 'Doctor') {
            $doctorId = $user->doctor->first()->id;
        } else {
            // If not a patient, return error response
            return response()->json(['error' => 'Only doctors can finish appointments'], 403);
        }

        // Create the appointment
        $record = Record::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'status' => $validated['status'],
            'appointment_time' => $validated['appointment_time'],
            'remarks' => $validated['remarks'],
        ]);

        // If the user is a doctor, check if the appointment belongs to the doctor
        $appointment = Appointment::where('id', $id)
            ->firstOrFail();

        // Delete the appointment
        $appointment->delete();

        $appointments = Appointment::with('doctor.user', 'patient.user')->where('doctor_id', $doctorId)->get();

        return response()->json(['appointments' => $appointments], 201);
    }

    public function destroy($id)
    {
        try {
            // Get the current logged-in user
            $user = auth()->user();

            // Determine if the user is a doctor or a patient
            $doctor = $user->doctor()->first();
            $patient = $user->patient()->first();

            if ($doctor) {
                // If the user is a doctor, check if the appointment belongs to the doctor
                $appointment = Appointment::where('id', $id)
                    ->where('doctor_id', $doctor->id)
                    ->firstOrFail();

                // Delete the appointment
                $appointment->delete();

                // Retrieve only the appointments that belong to the current doctor
                $appointments = Appointment::with('doctor.user', 'patient.user')
                    ->where('doctor_id', $doctor->id)
                    ->get();
            } elseif ($patient) {
                // If the user is a patient, check if the appointment belongs to the patient
                $appointment = Appointment::where('id', $id)
                    ->where('patient_id', $patient->id)
                    ->firstOrFail();

                // Delete the appointment
                $appointment->delete();

                // Retrieve only the appointments that belong to the current patient
                $appointments = Appointment::with('doctor.user', 'patient.user')
                    ->where('patient_id', $patient->id)
                    ->get();
            } else {
                // If the user is neither a doctor nor a patient, return an error
                return response([
                    "status" => "Error",
                    "message" => "User is neither a doctor nor a patient"
                ], 403);
            }

            return response([
                "status" => "Success",
                "appointments" => $appointments
            ]);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}