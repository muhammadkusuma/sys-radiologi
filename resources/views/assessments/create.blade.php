@extends('layouts.app')

@section('title', 'Buat Asesmen Kontras Radiologi')

@section('styles')
<style>
    .section-card {
        background: #white;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition flex items-center mb-1">
                &larr; Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-slate-950">Asesmen Tindakan Radiologi Kontras</h1>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-2 text-right">
            <div class="text-xs text-blue-600 font-medium">Pasien Terpilih</div>
            <div class="text-sm font-bold text-blue-900">{{ $patient->name }} (No. RM: {{ $patient->medical_record_number }})</div>
        </div>
    </div>

    <form action="{{ route('assessments.store') }}" method="POST" id="assessmentForm" class="space-y-8">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

        <!-- SECTION 1: IDENTITAS TINDAKAN -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Identitas Asesmen</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tanggal Tindakan</label>
                    <input type="date" name="procedure_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Jam Tindakan (WIB)</label>
                    <input type="time" name="procedure_time" value="{{ date('H:i') }}" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Dokter Pengirim / Perujuk</label>
                    <select name="referring_doctor_id" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Perawat Radiologi</label>
                    <select name="radiology_nurse_id" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Perawat --</option>
                        @foreach($nurses as $ns)
                            <option value="{{ $ns->id }}" {{ Auth::id() === $ns->id ? 'selected' : '' }}>{{ $ns->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Diagnosis Pasien</label>
                    <textarea name="diagnosis" rows="2" placeholder="Diagnosis klinis pasien..." class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Jenis Pemeriksaan</label>
                    <input type="text" name="examination_type" placeholder="Contoh: CT Scan Kepala / MRI Abdomen" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- SECTION 2: SEBELUM, SAAT, SETELAH TINDAKAN -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- SEBELUM TINDAKAN -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 bg-blue-50 text-blue-900 px-3 py-2 rounded-lg">Sebelum Tindakan</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Keadaan Umum</label>
                    <input type="text" name="general_condition" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tingkat Kesadaran</label>
                    <input type="text" name="consciousness_level" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">eGFR (ml/mnt)</label>
                        <input type="number" step="0.01" name="egfr" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Makan Terakhir (Jam)</label>
                        <input type="time" name="last_meal_time" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Berat Badan (Kg)</label>
                        <input type="number" step="0.1" name="body_weight" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Tekanan Darah (mmHg)</label>
                        <input type="text" name="blood_pressure" placeholder="120/80" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700">Nadi (x/mnt)</label>
                        <input type="number" name="pulse" class="mt-1 block w-full px-2 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700">Suhu (&deg;C)</label>
                        <input type="number" step="0.1" name="temperature" class="mt-1 block w-full px-2 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700">Nafas (x/mnt)</label>
                        <input type="number" name="respiratory_rate" class="mt-1 block w-full px-2 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Saturasi O2 (%)</label>
                    <input type="number" step="0.1" name="oxygen_saturation" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Keluhan Sebelum Tindakan</label>
                    <textarea name="pre_procedure_complaint" rows="2" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Riwayat Alergi</label>
                    <div class="flex items-center space-x-4 mb-2">
                        <label class="inline-flex items-center text-sm">
                            <input type="radio" name="has_allergy_history" value="0" checked onchange="toggleAllergy(false)" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-1.5">Tidak</span>
                        </label>
                        <label class="inline-flex items-center text-sm">
                            <input type="radio" name="has_allergy_history" value="1" onchange="toggleAllergy(true)" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-1.5">Ada</span>
                        </label>
                    </div>
                    <input type="text" name="allergy_description" id="allergy_desc_field" placeholder="Keterangan alergi..." disabled
                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <label class="block text-xs font-semibold text-slate-700">Info Media Kontras</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-[10px] text-slate-500">Batch</span>
                            <input type="text" name="contrast_batch" class="mt-0.5 block w-full px-2 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500">Konsentrasi</span>
                            <input type="text" name="contrast_concentration" class="mt-0.5 block w-full px-2 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-[10px] text-slate-500">Dosis (ml)</span>
                            <input type="number" step="0.01" name="contrast_dose_ml" class="mt-0.5 block w-full px-2 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-center pt-3">
                            <label class="inline-flex items-center text-xs">
                                <input type="checkbox" name="contrast_double_check" value="1" class="rounded text-blue-600">
                                <span class="ml-1.5 font-semibold text-slate-700">Double Check</span>
                            </label>
                        </div>
                    </div>
                    <div class="border-t border-slate-50 pt-2 grid grid-cols-2 gap-2">
                        <div class="flex items-center">
                            <label class="inline-flex items-center text-xs">
                                <input type="checkbox" name="allergy_test" value="1" class="rounded text-blue-600">
                                <span class="ml-1.5 font-semibold text-slate-700">Test Alergi</span>
                            </label>
                        </div>
                        <div>
                            <select name="allergy_test_result" class="block w-full px-2 py-1 border border-slate-300 rounded-lg text-xs">
                                <option value="">-- Hasil Test --</option>
                                <option value="tidak_alergi">Tidak Alergi</option>
                                <option value="alergi">Alergi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Riwayat Penyakit Pasien</label>
                    <div class="space-y-1.5 mt-1">
                        <label class="flex items-center text-sm">
                            <input type="checkbox" name="medical_history[]" value="Kemo/Radioterapi" class="rounded text-blue-600">
                            <span class="ml-2 text-slate-700">Kemo / Radioterapi</span>
                        </label>
                        <label class="flex items-center text-sm">
                            <input type="checkbox" name="medical_history[]" value="Diabetes" class="rounded text-blue-600">
                            <span class="ml-2 text-slate-700">Diabetes</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- DI SAAT TINDAKAN -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 bg-amber-50 text-amber-900 px-3 py-2 rounded-lg">Di Saat Tindakan</h3>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Keluhan Saat Tindakan</label>
                    <textarea name="during_complaint" rows="2" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tanda-tanda Alergi</label>
                    <input type="text" name="allergy_sign_during" placeholder="Gejala/Tanda..." class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="bg-slate-50 p-4 rounded-xl space-y-3">
                    <span class="block text-xs font-bold text-slate-800">Ceklis Gejala Alergi Saat Tindakan:</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label class="flex items-center"><input type="checkbox" name="itching_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Gatal-gatal</span></label>
                        <label class="flex items-center"><input type="checkbox" name="nausea_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Mual</span></label>
                        <label class="flex items-center"><input type="checkbox" name="dizziness_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Pusing</span></label>
                        <label class="flex items-center"><input type="checkbox" name="shortness_of_breath_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Sesak Nafas</span></label>
                        <label class="flex items-center"><input type="checkbox" name="swollen_eyes_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Mata Bengkak</span></label>
                        <label class="flex items-center"><input type="checkbox" name="swelling_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Bengkak Ekstravasasi</span></label>
                        <label class="flex items-center"><input type="checkbox" name="pain_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Nyeri</span></label>
                        <label class="flex items-center"><input type="checkbox" name="redness_during" value="1" class="rounded text-blue-600"><span class="ml-1.5">Kemerahan</span></label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tanda-tanda Ekstravasasi</label>
                    <textarea name="extravasation_sign_during" rows="2" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <span class="block text-xs font-bold text-slate-800">Infus & Akses IV</span>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700">Jam Pasang Infus</label>
                            <input type="time" name="iv_insertion_time" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700">Regio / Lokasi</label>
                            <input type="text" name="region" placeholder="cth: Antecubiti Dextra" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Ukuran IV Cath</label>
                        <input type="text" name="iv_cath_size" placeholder="cth: 20G" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- SETELAH TINDAKAN -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 bg-green-50 text-green-900 px-3 py-2 rounded-lg">Setelah Tindakan</h3>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Keluhan Setelah Tindakan</label>
                    <textarea name="post_procedure_complaint" rows="2" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tanda-tanda Alergi</label>
                    <input type="text" name="allergy_sign_after" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="bg-slate-50 p-4 rounded-xl space-y-3">
                    <span class="block text-xs font-bold text-slate-800">Ceklis Gejala Alergi Setelah Tindakan:</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label class="flex items-center"><input type="checkbox" name="itching_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Gatal-gatal</span></label>
                        <label class="flex items-center"><input type="checkbox" name="nausea_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Mual</span></label>
                        <label class="flex items-center"><input type="checkbox" name="dizziness_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Pusing</span></label>
                        <label class="flex items-center"><input type="checkbox" name="shortness_of_breath_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Sesak Nafas</span></label>
                        <label class="flex items-center"><input type="checkbox" name="swollen_eyes_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Mata Bengkak</span></label>
                        <label class="flex items-center"><input type="checkbox" name="bentol_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Bentol-bentol</span></label>
                        <label class="flex items-center"><input type="checkbox" name="swelling_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Bengkak Ekstravasasi</span></label>
                        <label class="flex items-center"><input type="checkbox" name="pain_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Nyeri</span></label>
                        <label class="flex items-center"><input type="checkbox" name="redness_after" value="1" class="rounded text-blue-600"><span class="ml-1.5">Kemerahan</span></label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tanda-tanda Ekstravasasi</label>
                    <textarea name="extravasation_sign_after" rows="2" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Tekanan Darah (mmHg)</label>
                        <input type="text" name="post_blood_pressure" placeholder="120/80" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Nadi (x/menit)</label>
                        <input type="number" name="post_pulse" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700">Suhu (&deg;C)</label>
                        <input type="number" step="0.1" name="post_temperature" class="mt-1 block w-full px-2 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700">Nafas (x/mnt)</label>
                        <input type="number" name="post_respiratory_rate" class="mt-1 block w-full px-2 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-700">Sat O2 (%)</label>
                        <input type="number" step="0.1" name="post_oxygen_saturation" class="mt-1 block w-full px-2 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Jam Lepas Infus</label>
                    <input type="time" name="iv_removal_time" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- SECTION 3: CATATAN PEMBERIAN OBAT (DARI HALAMAN 2) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900">Catatan Pemberian Obat Kontras (Halaman 2 dari 2)</h2>
                <button type="button" onclick="addMedicationRow()" class="inline-flex items-center px-3 py-1.5 border border-slate-300 text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                    + Tambah Obat
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700">Nama Obat</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700 w-24">Dosis</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700">Rute Pemberian</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700 w-24">Kecepatan</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700 w-24">Tekanan</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700 w-28">Jam</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700">Reaksi</th>
                            <th class="border border-slate-200 px-3 py-2 text-left text-xs font-bold text-slate-700">Keterangan</th>
                            <th class="border border-slate-200 px-3 py-2 text-center text-xs font-bold text-slate-700 w-16">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="medicationTableBody" class="divide-y divide-slate-200">
                        <tr>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][medication_name]" required class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Nama obat..."></td>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][dose]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Dosis..."></td>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][administration_route]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Rute..."></td>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][speed]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Speed..."></td>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][pressure]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Tekanan..."></td>
                            <td class="border border-slate-200 p-1"><input type="time" name="medications[0][administered_at]" value="{{ date('H:i') }}" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm"></td>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][reaction]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Reaksi..."></td>
                            <td class="border border-slate-200 p-1"><input type="text" name="medications[0][notes]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Keterangan..."></td>
                            <td class="border border-slate-200 p-1 text-center"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECTION 4: TANDA TANGAN -->
        @if(Auth::user()->role === 'perawat')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Tanda Tangan Perawat Radiologi</h2>
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 w-full md:w-auto">
                    <span class="block text-xs font-bold text-slate-700 mb-2">Tanda Tangan di bawah ini:</span>
                    <canvas id="nurseSigPad" class="bg-white border border-slate-300 rounded-lg cursor-crosshair" width="350" height="150"></canvas>
                    <div class="flex space-x-2 mt-2">
                        <button type="button" onclick="clearNursePad()" class="px-3 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded hover:bg-slate-350 cursor-pointer">Hapus</button>
                    </div>
                    <input type="hidden" name="nurse_signature" id="nurseSigInput">
                </div>
                <div class="text-sm text-slate-500 space-y-2">
                    <p class="font-bold text-slate-800">Instruksi Tanda Tangan:</p>
                    <p>1. Gambar tanda tangan Anda langsung di dalam kotak canvas yang disediakan.</p>
                    <p>2. Tanda tangan akan disimpan secara digital.</p>
                    <p>3. Dokter spesialis radiologi akan melakukan tanda tangan setelah data asesmen selesai dan divalidasi.</p>
                </div>
            </div>
        </div>
        @endif

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                Batal
            </a>
            <button type="submit" onclick="submitForm(event)" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-750 transition cursor-pointer">
                Simpan & Kirim
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleAllergy(show) {
        const field = document.getElementById('allergy_desc_field');
        if (show) {
            field.removeAttribute('disabled');
            field.classList.remove('bg-slate-50');
            field.focus();
        } else {
            field.setAttribute('disabled', 'true');
            field.classList.add('bg-slate-50');
            field.value = '';
        }
    }

    let medIndex = 1;
    function addMedicationRow() {
        const tbody = document.getElementById('medicationTableBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][medication_name]" required class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Nama obat..."></td>
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][dose]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Dosis..."></td>
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][administration_route]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Rute..."></td>
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][speed]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Speed..."></td>
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][pressure]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Tekanan..."></td>
            <td class="border border-slate-200 p-1"><input type="time" name="medications[${medIndex}][administered_at]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm"></td>
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][reaction]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Reaksi..."></td>
            <td class="border border-slate-200 p-1"><input type="text" name="medications[${medIndex}][notes]" class="w-full px-2 py-1 border-0 focus:ring-0 text-sm" placeholder="Keterangan..."></td>
            <td class="border border-slate-200 p-1 text-center"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
        `;
        tbody.appendChild(tr);
        medIndex++;
    }

    function removeMedRow(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('#medicationTableBody tr').length > 1) {
            row.remove();
        } else {
            alert('Minimal harus ada 1 baris catatan pemberian obat.');
        }
    }

    // CANVAS SIGNATURE PAD IMPLEMENTATION
    const nurseCanvas = document.getElementById('nurseSigPad');
    let drawing = false;
    let nurseCtx = null;

    if (nurseCanvas) {
        nurseCtx = nurseCanvas.getContext('2d');
        nurseCtx.strokeStyle = "#0f172a"; // Slate-900
        nurseCtx.lineWidth = 3;
        nurseCtx.lineCap = "round";

        function getMousePos(canvasDom, touchOrMouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: (touchOrMouseEvent.clientX || touchOrMouseEvent.touches[0].clientX) - rect.left,
                y: (touchOrMouseEvent.clientY || touchOrMouseEvent.touches[0].clientY) - rect.top
            };
        }

        nurseCanvas.addEventListener('mousedown', function(e) {
            drawing = true;
            const pos = getMousePos(nurseCanvas, e);
            nurseCtx.beginPath();
            nurseCtx.moveTo(pos.x, pos.y);
        });

        nurseCanvas.addEventListener('mousemove', function(e) {
            if (drawing) {
                const pos = getMousePos(nurseCanvas, e);
                nurseCtx.lineTo(pos.x, pos.y);
                nurseCtx.stroke();
            }
        });

        nurseCanvas.addEventListener('mouseup', function() {
            drawing = false;
        });

        // Touch support for mobile devices
        nurseCanvas.addEventListener('touchstart', function(e) {
            e.preventDefault();
            drawing = true;
            const pos = getMousePos(nurseCanvas, e);
            nurseCtx.beginPath();
            nurseCtx.moveTo(pos.x, pos.y);
        }, { passive: false });

        nurseCanvas.addEventListener('touchmove', function(e) {
            e.preventDefault();
            if (drawing) {
                const pos = getMousePos(nurseCanvas, e);
                nurseCtx.lineTo(pos.x, pos.y);
                nurseCtx.stroke();
            }
        }, { passive: false });

        nurseCanvas.addEventListener('touchend', function() {
            drawing = false;
        });
    }

    function clearNursePad() {
        if (nurseCanvas) {
            nurseCtx.clearRect(0, 0, nurseCanvas.width, nurseCanvas.height);
        }
    }

    function submitForm(event) {
        event.preventDefault();
        
        if (nurseCanvas) {
            // Check if user drew anything (or check input directly)
            const input = document.getElementById('nurseSigInput');
            // Check if blank canvas by comparing pixels
            const blank = document.createElement('canvas');
            blank.width = nurseCanvas.width;
            blank.height = nurseCanvas.height;
            if (nurseCanvas.toDataURL() !== blank.toDataURL()) {
                input.value = nurseCanvas.toDataURL();
            }
        }

        document.getElementById('assessmentForm').submit();
    }
</script>
@endsection
