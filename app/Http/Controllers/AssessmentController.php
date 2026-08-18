<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RadiologyContrastAssessment;
use App\Models\RadiologyContrastMedication;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $doctors = User::where('role', 'dokter')->get();
        $nurses = User::where('role', 'perawat')->get();
        $doses = \Illuminate\Support\Facades\DB::table('dosis_obat')->pluck('Dosis')->toArray();
        $routes = \Illuminate\Support\Facades\DB::table('rute_pemberian_obat')->pluck('Nama')->toArray();

        return view('assessments.create', compact('patient', 'doctors', 'nurses', 'doses', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'procedure_date' => 'nullable|date',
            'procedure_time' => 'nullable',
            'referring_doctor_id' => 'nullable|exists:users,id',
            'radiology_nurse_id' => 'nullable|exists:users,id',
            'diagnosis' => 'nullable|string',
            'examination_type' => 'nullable|string',
            'general_condition' => 'nullable|string',
            'consciousness_level' => 'nullable|string',
            'egfr' => 'nullable|numeric|between:0,999999.99',
            'last_meal_time' => 'nullable',
            'body_weight' => 'nullable|numeric|between:0,9999.99',
            'blood_pressure' => 'nullable|string',
            'pulse' => 'nullable|integer|between:0,999',
            'temperature' => 'nullable|numeric|between:0,99.9',
            'respiratory_rate' => 'nullable|integer|between:0,999',
            'oxygen_saturation' => 'nullable|numeric|between:0,100',
            'pre_procedure_complaint' => 'nullable|string',
            'has_allergy_history' => 'nullable|boolean',
            'allergy_description' => 'nullable|string',
            'contrast_batch' => 'nullable|string',
            'contrast_concentration' => 'nullable|string',
            'contrast_dose_ml' => 'nullable|numeric|between:0,99999.99',
            'contrast_double_check' => 'nullable|boolean',
            'allergy_test' => 'nullable|boolean',
            'allergy_test_result' => 'nullable|string',
            'during_complaint' => 'nullable|string',
            'allergy_sign_during' => 'nullable|string',
            'itching_during' => 'nullable|boolean',
            'nausea_during' => 'nullable|boolean',
            'dizziness_during' => 'nullable|boolean',
            'shortness_of_breath_during' => 'nullable|boolean',
            'swollen_eyes_during' => 'nullable|boolean',
            'swelling_during' => 'nullable|boolean',
            'pain_during' => 'nullable|boolean',
            'redness_during' => 'nullable|boolean',
            'extravasation_sign_during' => 'nullable|string',
            'iv_insertion_time' => 'nullable',
            'region' => 'nullable|string',
            'iv_cath_size' => 'nullable|string',
            'post_procedure_complaint' => 'nullable|string',
            'allergy_sign_after' => 'nullable|string',
            'itching_after' => 'nullable|boolean',
            'nausea_after' => 'nullable|boolean',
            'dizziness_after' => 'nullable|boolean',
            'shortness_of_breath_after' => 'nullable|boolean',
            'swollen_eyes_after' => 'nullable|boolean',
            'bentol_after' => 'nullable|boolean',
            'swelling_after' => 'nullable|boolean',
            'pain_after' => 'nullable|boolean',
            'redness_after' => 'nullable|boolean',
            'extravasation_sign_after' => 'nullable|string',
            'post_blood_pressure' => 'nullable|string',
            'post_pulse' => 'nullable|integer|between:0,999',
            'post_temperature' => 'nullable|numeric|between:0,99.9',
            'post_respiratory_rate' => 'nullable|integer|between:0,999',
            'post_oxygen_saturation' => 'nullable|numeric|between:0,100',
            'iv_removal_time' => 'nullable',
            'medical_history' => 'nullable|array',
            'nurse_signature' => 'nullable|string',
            'medications' => 'nullable|array',
        ]);

        // Convert boolean fields
        $booleanFields = [
            'has_allergy_history',
            'contrast_double_check',
            'allergy_test',
            'itching_during',
            'nausea_during',
            'dizziness_during',
            'shortness_of_breath_during',
            'swollen_eyes_during',
            'swelling_during',
            'pain_during',
            'redness_during',
            'itching_after',
            'nausea_after',
            'dizziness_after',
            'shortness_of_breath_after',
            'swollen_eyes_after',
            'bentol_after',
            'swelling_after',
            'pain_after',
            'redness_after'
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field) ? true : false;
        }

        $validated['created_by'] = Auth::id();

        $assessment = RadiologyContrastAssessment::create($validated);

        // Store medications
        if ($request->has('medications')) {
            foreach ($request->input('medications') as $med) {
                $hasContent = !empty($med['medication_name']) ||
                    !empty($med['dose']) ||
                    !empty($med['administration_route']) ||
                    !empty($med['speed']) ||
                    !empty($med['pressure']) ||
                    !empty($med['reaction']) ||
                    !empty($med['notes']);

                if ($hasContent) {
                    $assessment->medications()->create([
                        'medication_name' => !empty($med['medication_name']) ? $med['medication_name'] : '-',
                        'dose' => $med['dose'] ?? null,
                        'administration_route' => $med['administration_route'] ?? null,
                        'speed' => $med['speed'] ?? null,
                        'pressure' => $med['pressure'] ?? null,
                        'administered_at' => $med['administered_at'] ?? null,
                        'reaction' => $med['reaction'] ?? null,
                        'notes' => $med['notes'] ?? null,
                        'nurse_id' => Auth::user()->role === 'perawat' ? Auth::id() : null,
                        'nurse_initials' => Auth::user()->role === 'perawat' ? Auth::user()->name : null,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Asesmen Kontras Radiologi berhasil disimpan.');
    }

    public function show($id)
    {
        $assessment = RadiologyContrastAssessment::with(['patient', 'referringDoctor', 'radiologyNurse', 'radiologyDoctor', 'medications.nurse'])->findOrFail($id);
        return view('assessments.show', compact('assessment'));
    }

    public function pdf(Request $request, $id)
    {
        $assessment = RadiologyContrastAssessment::with([
            'patient',
            'referringDoctor',
            'radiologyNurse',
            'radiologyDoctor',
            'medications.nurse',
        ])->findOrFail($id);

        $maxFullPage = 22;
        $maxLastPage = 20;
        $medications = $assessment->medications->values();
        $medicationPages = collect();

        if ($medications->isEmpty()) {
            $medicationPages->push(collect());
        } elseif ($medications->count() <= $maxLastPage) {
            $medicationPages->push($medications);
        } else {
            $remaining = $medications;

            while ($remaining->isNotEmpty()) {
                if ($remaining->count() <= $maxLastPage) {
                    $medicationPages->push($remaining);
                    break;
                }

                if ($remaining->count() <= ($maxFullPage + $maxLastPage)) {
                    $firstCount = min($maxFullPage, $remaining->count() - 1);
                    $lastCount = $remaining->count() - $firstCount;

                    if ($lastCount > $maxLastPage) {
                        $firstCount = $remaining->count() - $maxLastPage;
                    }

                    if ($firstCount > 0) {
                        $medicationPages->push($remaining->take($firstCount));
                        $remaining = $remaining->slice($firstCount)->values();
                    }

                    $medicationPages->push($remaining);
                    break;
                }

                $medicationPages->push($remaining->take($maxFullPage));
                $remaining = $remaining->slice($maxFullPage)->values();
            }
        }

        $totalPages = 1 + $medicationPages->count();

        $pdf = Pdf::loadView('assessments.pdf', compact('assessment', 'medicationPages', 'totalPages'))
            ->setPaper('a4', 'landscape');

        $filename = 'asesmen-radiologi-kontras-' . $assessment->id . '.pdf';

        if ($request->boolean('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    public function edit($id)
    {
        $assessment = RadiologyContrastAssessment::with('medications')->findOrFail($id);
        $patient = $assessment->patient;
        $doctors = User::where('role', 'dokter')->get();
        $nurses = User::where('role', 'perawat')->get();
        $doses = \Illuminate\Support\Facades\DB::table('dosis_obat')->pluck('Dosis')->toArray();
        $routes = \Illuminate\Support\Facades\DB::table('rute_pemberian_obat')->pluck('Nama')->toArray();

        return view('assessments.edit', compact('assessment', 'patient', 'doctors', 'nurses', 'doses', 'routes'));
    }

    public function update(Request $request, $id)
    {
        $assessment = RadiologyContrastAssessment::findOrFail($id);

        $validated = $request->validate([
            'procedure_date' => 'nullable|date',
            'procedure_time' => 'nullable',
            'referring_doctor_id' => 'nullable|exists:users,id',
            'radiology_nurse_id' => 'nullable|exists:users,id',
            'diagnosis' => 'nullable|string',
            'examination_type' => 'nullable|string',
            'general_condition' => 'nullable|string',
            'consciousness_level' => 'nullable|string',
            'egfr' => 'nullable|numeric|between:0,999999.99',
            'last_meal_time' => 'nullable',
            'body_weight' => 'nullable|numeric|between:0,9999.99',
            'blood_pressure' => 'nullable|string',
            'pulse' => 'nullable|integer|between:0,999',
            'temperature' => 'nullable|numeric|between:0,99.9',
            'respiratory_rate' => 'nullable|integer|between:0,999',
            'oxygen_saturation' => 'nullable|numeric|between:0,100',
            'pre_procedure_complaint' => 'nullable|string',
            'has_allergy_history' => 'nullable|boolean',
            'allergy_description' => 'nullable|string',
            'contrast_batch' => 'nullable|string',
            'contrast_concentration' => 'nullable|string',
            'contrast_dose_ml' => 'nullable|numeric|between:0,99999.99',
            'contrast_double_check' => 'nullable|boolean',
            'allergy_test' => 'nullable|boolean',
            'allergy_test_result' => 'nullable|string',
            'during_complaint' => 'nullable|string',
            'allergy_sign_during' => 'nullable|string',
            'itching_during' => 'nullable|boolean',
            'nausea_during' => 'nullable|boolean',
            'dizziness_during' => 'nullable|boolean',
            'shortness_of_breath_during' => 'nullable|boolean',
            'swollen_eyes_during' => 'nullable|boolean',
            'swelling_during' => 'nullable|boolean',
            'pain_during' => 'nullable|boolean',
            'redness_during' => 'nullable|boolean',
            'extravasation_sign_during' => 'nullable|string',
            'iv_insertion_time' => 'nullable',
            'region' => 'nullable|string',
            'iv_cath_size' => 'nullable|string',
            'post_procedure_complaint' => 'nullable|string',
            'allergy_sign_after' => 'nullable|string',
            'itching_after' => 'nullable|boolean',
            'nausea_after' => 'nullable|boolean',
            'dizziness_after' => 'nullable|boolean',
            'shortness_of_breath_after' => 'nullable|boolean',
            'swollen_eyes_after' => 'nullable|boolean',
            'bentol_after' => 'nullable|boolean',
            'swelling_after' => 'nullable|boolean',
            'pain_after' => 'nullable|boolean',
            'redness_after' => 'nullable|boolean',
            'extravasation_sign_after' => 'nullable|string',
            'post_blood_pressure' => 'nullable|string',
            'post_pulse' => 'nullable|integer|between:0,999',
            'post_temperature' => 'nullable|numeric|between:0,99.9',
            'post_respiratory_rate' => 'nullable|integer|between:0,999',
            'post_oxygen_saturation' => 'nullable|numeric|between:0,100',
            'iv_removal_time' => 'nullable',
            'medical_history' => 'nullable|array',
            'nurse_signature' => 'nullable|string',
            'doctor_signature' => 'nullable|string',
            'medications' => 'nullable|array',
        ]);

        $booleanFields = [
            'has_allergy_history',
            'contrast_double_check',
            'allergy_test',
            'itching_during',
            'nausea_during',
            'dizziness_during',
            'shortness_of_breath_during',
            'swollen_eyes_during',
            'swelling_during',
            'pain_during',
            'redness_during',
            'itching_after',
            'nausea_after',
            'dizziness_after',
            'shortness_of_breath_after',
            'swollen_eyes_after',
            'bentol_after',
            'swelling_after',
            'pain_after',
            'redness_after'
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field) ? true : false;
        }

        $validated['updated_by'] = Auth::id();

        // If doctor signs from edit form
        if ($request->filled('doctor_signature') && !$assessment->doctor_signature) {
            $validated['radiology_doctor_id'] = Auth::id();
            $validated['signed_at'] = now();
        }

        $assessment->update($validated);

        // Update medications
        $assessment->medications()->delete();
        if ($request->has('medications')) {
            foreach ($request->input('medications') as $med) {
                $hasContent = !empty($med['medication_name']) ||
                    !empty($med['dose']) ||
                    !empty($med['administration_route']) ||
                    !empty($med['speed']) ||
                    !empty($med['pressure']) ||
                    !empty($med['reaction']) ||
                    !empty($med['notes']);

                if ($hasContent) {
                    $assessment->medications()->create([
                        'medication_name' => !empty($med['medication_name']) ? $med['medication_name'] : '-',
                        'dose' => $med['dose'] ?? null,
                        'administration_route' => $med['administration_route'] ?? null,
                        'speed' => $med['speed'] ?? null,
                        'pressure' => $med['pressure'] ?? null,
                        'administered_at' => $med['administered_at'] ?? null,
                        'reaction' => $med['reaction'] ?? null,
                        'notes' => $med['notes'] ?? null,
                        'nurse_id' => Auth::user()->role === 'perawat' ? Auth::id() : ($assessment->radiology_nurse_id ?? null),
                        'nurse_initials' => Auth::user()->role === 'perawat' ? Auth::user()->name : null,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Asesmen Kontras Radiologi berhasil diperbarui.');
    }

    public function sign(Request $request, $id)
    {
        $assessment = RadiologyContrastAssessment::findOrFail($id);

        if (Auth::user()->role === 'dokter') {
            if (!$assessment->nurse_signature) {
                return redirect()->route('assessments.show', $assessment->id)
                    ->with('error', 'Dokumen belum ditandatangani perawat.');
            }

            if ($assessment->doctor_signature) {
                return redirect()->route('assessments.show', $assessment->id)
                    ->with('error', 'Dokumen sudah ditandatangani dokter.');
            }

            $signature = Auth::user()->signature ?: $request->input('signature');

            if (!$signature) {
                return redirect()->route('assessments.show', $assessment->id)
                    ->with('error', 'Tanda tangan dokter belum tersedia. Silakan hubungi Superadmin/IT untuk mengunggah TTD di Master User.');
            }

            $assessment->update([
                'radiology_doctor_id' => Auth::id(),
                'doctor_signature' => $signature,
                'signed_at' => now(),
            ]);

            return redirect()->route('assessments.show', $assessment->id)
                ->with('success', 'Dokumen berhasil ditandatangani oleh Dokter Spesialis Radiologi.');
        }

        $request->validate([
            'signature' => 'required|string',
        ]);

        $assessment->update([
            'nurse_signature' => $request->input('signature'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil ditandatangani oleh Perawat Radiologi.');
    }

    public function destroy($id)
    {
        $assessment = RadiologyContrastAssessment::findOrFail($id);
        $assessment->delete();

        return redirect()->route('dashboard')->with('success', 'Data asesmen berhasil dihapus.');
    }
}
