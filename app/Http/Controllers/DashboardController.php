<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RadiologyContrastAssessment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $patients = Patient::orderBy('name')->get();
        
        $query = RadiologyContrastAssessment::with(['patient', 'radiologyNurse', 'radiologyDoctor']);
        
        if (auth()->user()->role === 'dokter') {
            $query->whereNotNull('nurse_signature')->whereNull('doctor_signature');
        }
        
        $assessments = $query->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('patients', 'assessments'));
    }
}
