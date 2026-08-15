<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_number' => 'required|unique:patients,medical_record_number',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->route('dashboard')->with('success', 'Pasien baru berhasil didaftarkan.');
    }
}
