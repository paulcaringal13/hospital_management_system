<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        $user->load('patient');
        $user->load('doctor');

        // Check if patient or doctor arrays are empty and remove them from the response if they are
        if ($user->patient->isEmpty()) {
            unset($user->patient);
        }

        if ($user->doctor->isEmpty()) {
            unset($user->doctor);
        }

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}