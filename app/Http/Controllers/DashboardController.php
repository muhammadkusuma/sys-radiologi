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
        $assessments = RadiologyContrastAssessment::with(['patient', 'radiologyNurse', 'radiologyDoctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('patients', 'assessments'));
    }
}
