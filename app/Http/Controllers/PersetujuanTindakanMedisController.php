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
        $data = $request->except('_token', '_method');
        
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
