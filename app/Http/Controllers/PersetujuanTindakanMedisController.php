<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersetujuanTindakanMedisController extends Controller
{
    public function index()
    {
        $persetujuan = \App\Models\PersetujuanTindakanMedis::latest()->paginate(10);
        return view('persetujuan_tindakan.index', compact('persetujuan'));
    }

    public function create(Request $request)
    {
        $patients = \App\Models\Patient::all();
        $doctors = \App\Models\User::where('role', 'dokter')->get();
        
        $patient = null;
        if ($request->has('patient_id')) {
            $patient = \App\Models\Patient::find($request->patient_id);
        }

        return view('persetujuan_tindakan.create', compact('patients', 'doctors', 'patient'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $data['alternative_treatment_choices'] = array_values($request->input('alternative_treatment_choices', []));
        $data['risk_if_not_treated_choices'] = array_values($request->input('risk_if_not_treated_choices', []));
        $data['hospitalization_days'] = $request->filled('hospitalization_days')
            ? (int) $request->input('hospitalization_days')
            : null;

        if (($data['alternative_treatment'] ?? null) !== 'yes') {
            $data['alternative_treatment_detail'] = null;
            $data['alternative_treatment_choices'] = [];
        }

        if (($data['risk_if_not_treated_option'] ?? null) !== 'yes') {
            $data['risk_if_not_treated_detail'] = null;
            $data['risk_if_not_treated_choices'] = [];
        }

        if (($data['hospitalization_option'] ?? null) !== 'hospitalized') {
            $data['hospitalization_days'] = null;
        }
        
        // Handle boolean fields from checkboxes
        $booleanFields = [
            'check_received_info', 'check_understand_necessity',
            'check_given_opportunity', 'check_realize_no_guarantee',
            'check_realize_not_exact_science'
        ];
        
        foreach ($booleanFields as $field) {
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        \App\Models\PersetujuanTindakanMedis::create($data);

        return redirect()->route('persetujuan-tindakan.index')->with('success', 'Persetujuan Tindakan Medis berhasil disimpan.');
    }

    public function show($id)
    {
        $persetujuan = \App\Models\PersetujuanTindakanMedis::findOrFail($id);
        return view('persetujuan_tindakan.show', compact('persetujuan'));
    }

    public function print($id)
    {
        $persetujuan = \App\Models\PersetujuanTindakanMedis::with('patient')->findOrFail($id);
        $patient = $persetujuan->patient;

        $doctor = null;
        if (! empty($persetujuan->doctor)) {
            $doctor = is_numeric($persetujuan->doctor)
                ? \App\Models\User::find($persetujuan->doctor)
                : null;
        }

        $doctorName = $doctor?->name ?? (is_numeric($persetujuan->doctor) ? '' : ($persetujuan->doctor ?? ''));

        return view('persetujuan_tindakan.print', compact('persetujuan', 'patient', 'doctor', 'doctorName'));
    }

    public function edit($id)
    {
        $persetujuan = \App\Models\PersetujuanTindakanMedis::findOrFail($id);
        $patients = \App\Models\Patient::all();
        $doctors = \App\Models\User::where('role', 'dokter')->get();
        $patient = $persetujuan->patient;
        return view('persetujuan_tindakan.edit', compact('persetujuan', 'patients', 'doctors', 'patient'));
    }

    public function update(Request $request, $id)
    {
        $persetujuan = \App\Models\PersetujuanTindakanMedis::findOrFail($id);

        // Jika mode=patient, hanya update field yang relevan untuk pasien
        // agar field yang diisi dokter (diagnosis, planned_procedure, dll) tidak ikut terhapus
        if ($request->query('mode') === 'patient') {
            $data = [];

            // Field teks dari pasien
            foreach (['recipient_name', 'relationship', 'other_relationship',
                      'wali_nama', 'wali_umur', 'wali_jk', 'wali_alamat',
                      'wali_jenis_identitas', 'wali_identitas', 'wali_hubungan',
                      'wali_hubungan_lainnya', 'pernyataan_tindakan',
                      'tanggal_persetujuan', 'jam_persetujuan',
                      'yang_menyatakan_nama', 'saksi_1_nama', 'saksi_2_nama'] as $field) {
                $data[$field] = $request->input($field);
            }

            // diagnosis_initial adalah array dari checkboxes (paraf)
            $data['diagnosis_initial'] = $request->input('diagnosis_initial', []);

            // signature adalah array dari canvas tanda tangan
            $data['signature'] = $request->input('signature', []);

            // Boolean checkboxes pernyataan pasien
            $booleanFields = [
                'check_received_info', 'check_understand_necessity',
                'check_given_opportunity', 'check_realize_no_guarantee',
                'check_realize_not_exact_science'
            ];
            foreach ($booleanFields as $field) {
                $data[$field] = $request->has($field) ? 1 : 0;
            }

            $persetujuan->update($data);

            return redirect()->route('persetujuan-tindakan.index')->with('success', 'Persetujuan Tindakan Medis berhasil diperbarui.');
        }

        // Mode dokter: update semua field
        $data = $request->except('_token', '_method');

        $data['alternative_treatment_choices'] = array_values($request->input('alternative_treatment_choices', []));
        $data['risk_if_not_treated_choices'] = array_values($request->input('risk_if_not_treated_choices', []));
        $data['hospitalization_days'] = $request->filled('hospitalization_days')
            ? (int) $request->input('hospitalization_days')
            : null;

        if (($data['alternative_treatment'] ?? null) !== 'yes') {
            $data['alternative_treatment_detail'] = null;
            $data['alternative_treatment_choices'] = [];
        }

        if (($data['risk_if_not_treated_option'] ?? null) !== 'yes') {
            $data['risk_if_not_treated_detail'] = null;
            $data['risk_if_not_treated_choices'] = [];
        }

        if (($data['hospitalization_option'] ?? null) !== 'hospitalized') {
            $data['hospitalization_days'] = null;
        }
        
        $booleanFields = [
            'check_received_info', 'check_understand_necessity',
            'check_given_opportunity', 'check_realize_no_guarantee',
            'check_realize_not_exact_science'
        ];
        
        foreach ($booleanFields as $field) {
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        $persetujuan->update($data);

        return redirect()->route('persetujuan-tindakan.index')->with('success', 'Persetujuan Tindakan Medis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $persetujuan = \App\Models\PersetujuanTindakanMedis::findOrFail($id);
        $persetujuan->delete();

        return redirect()->route('persetujuan-tindakan.index')->with('success', 'Persetujuan Tindakan Medis berhasil dihapus.');
    }
}
