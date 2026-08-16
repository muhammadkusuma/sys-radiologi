@extends('layouts.app')

@section('title', 'Edit Asesmen Kontras Radiologi')

@section('styles')
<style>
    /* Styled like paper but interactive */
    .paper-container {
        background: #fff;
        border: 1px solid #cbd5e1;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        padding: 20px;
        border-radius: 12px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
        max-width: 277mm;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
        margin-bottom: 10px;
    }

    .form-title {
        font-size: 15px;
        font-weight: bold;
        text-align: center;
        flex-grow: 1;
        text-transform: uppercase;
        color: #000;
    }

    table.paper-table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
        margin-bottom: 10px;
    }

    table.paper-table td, table.paper-table th {
        border: 1px solid #000;
        padding: 4px 6px;
        vertical-align: middle;
        color: #000;
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        background-color: #f1f5f9;
        color: #000;
        height: 24px;
    }

    /* Form control elements styled to blend in */
    .paper-input {
        border: none;
        border-bottom: 1px dotted #000;
        outline: none;
        font-size: 11px;
        padding: 1px 2px;
        background: transparent;
        width: 100%;
        color: #000;
    }

    .paper-input:focus {
        background-color: #f8fafc;
        border-bottom: 1px solid #2563eb;
    }

    .paper-textarea {
        border: 1px solid #cbd5e1;
        background-color: #fff;
        color: #000;
        border-radius: 4px;
        outline: none;
        font-size: 11px;
        padding: 3px;
        width: 100%;
        resize: none;
        height: 45px;
    }

    .paper-textarea:focus {
        border-color: #2563eb;
        background-color: #f8fafc;
    }

    .label-cell {
        font-weight: bold;
        background-color: #f8fafc;
        color: #000;
        width: 13%;
    }

    .value-cell {
        width: 20%;
    }

    .signature-box {
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
        background: #f8fafc;
        cursor: crosshair;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center no-print">
        <div>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition flex items-center mb-1">
                &larr; Kembali ke Dashboard
            </a>
            <h1 class="text-xl font-bold text-slate-900">Edit Form Asesmen Tindakan Radiologi Kontras</h1>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-2 text-right">
            <span class="text-xs text-blue-600 block">Nama Pasien</span>
            <span class="text-sm font-bold text-blue-900">{{ $patient->name }} (RM: {{ $patient->medical_record_number }})</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 shadow-sm">
            <div class="font-bold text-sm mb-1">Gagal memperbarui! Harap periksa inputan berikut:</div>
            <ul class="list-disc pl-5 text-xs space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assessments.update', $assessment->id) }}" method="POST" id="assessmentForm">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

        <!-- HALAMAN 1 -->
        <div class="overflow-x-auto w-full mb-8">
            <div class="paper-container">
            <div class="form-header">
                <div style="font-weight: bold;">RS AWAL BROS<br><span style="font-size: 9px; font-weight: normal;">Pekanbaru</span></div>
                <div class="form-title">Asesmen Tindakan Radiologi Kontras (Halaman 1 dari 2)</div>
                <div style="width: 80px;"></div>
            </div>

            <!-- IDENTITAS PASIEN -->
            <table class="paper-table">
                <tr>
                    <td rowspan="3" class="label-cell center" style="width: 12%;">Identitas Pasien</td>
                    <td rowspan="3" style="width: 38%;">
                        <div style="font-weight: bold; font-size: 11px; line-height: 15px;">
                            Nama Pasien: {{ $patient->name }}<br>
                            No. RM: {{ $patient->medical_record_number }}<br>
                            Tanggal Lahir: {{ $patient->date_of_birth ? $patient->date_of_birth->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td class="label-cell">Tanggal Tindakan</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            <input type="date" name="procedure_date" value="{{ old('procedure_date', $assessment->procedure_date ? $assessment->procedure_date->format('Y-m-d') : '') }}" class="paper-input w-32">
                            <span>Jam:</span>
                            <input type="text" data-clocklet="format: HH:mm" name="procedure_time" value="{{ old('procedure_time', $assessment->procedure_time ? substr($assessment->procedure_time, 0, 5) : '') }}" class="paper-input w-20 text-center">
                            <span>WIB</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Dokter Pengirim</td>
                    <td>
                        <select name="referring_doctor_id" class="paper-input">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}" {{ old('referring_doctor_id', $assessment->referring_doctor_id) == $doc->id ? 'selected' : '' }}>{{ $doc->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Perawat Radiologi</td>
                    <td>
                        <select name="radiology_nurse_id" class="paper-input">
                            <option value="">-- Pilih Perawat --</option>
                            @foreach($nurses as $ns)
                                <option value="{{ $ns->id }}" {{ old('radiology_nurse_id', $assessment->radiology_nurse_id) == $ns->id ? 'selected' : '' }}>{{ $ns->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Diagnosis Pasien</td>
                    <td>
                        <input type="text" name="diagnosis" value="{{ old('diagnosis', $assessment->diagnosis) }}" placeholder="Tulis diagnosis klinis..." class="paper-input">
                    </td>
                    <td class="label-cell">Jenis Pemeriksaan</td>
                    <td>
                        <input type="text" name="examination_type" value="{{ old('examination_type', $assessment->examination_type) }}" placeholder="cth: CT Scan Kepala Kontras" class="paper-input">
                    </td>
                </tr>
            </table>

            <!-- SEBELUM, SAAT, SETELAH TINDAKAN -->
            <table class="paper-table">
                <tr>
                    <th colspan="2" class="section-title">Sebelum Tindakan</th>
                    <th colspan="2" class="section-title">Di Saat Tindakan</th>
                    <th colspan="2" class="section-title">Setelah Tindakan</th>
                </tr>

                <!-- Row 1 -->
                <tr>
                    <td class="label-cell">Keadaan Umum</td>
                    <td><input type="text" name="general_condition" value="{{ old('general_condition', $assessment->general_condition) }}" class="paper-input"></td>
                    <td class="label-cell">Keluhan</td>
                    <td><input type="text" name="during_complaint" value="{{ old('during_complaint', $assessment->during_complaint) }}" class="paper-input"></td>
                    <td class="label-cell">Keluhan</td>
                    <td><input type="text" name="post_procedure_complaint" value="{{ old('post_procedure_complaint', $assessment->post_procedure_complaint) }}" class="paper-input"></td>
                </tr>

                <!-- Row 2 -->
                <tr>
                    <td class="label-cell">Tingkat Kesadaran</td>
                    <td><input type="text" name="consciousness_level" value="{{ old('consciousness_level', $assessment->consciousness_level) }}" class="paper-input"></td>
                    <td class="label-cell">Tanda-tanda Alergi</td>
                    <td><input type="text" name="allergy_sign_during" value="{{ old('allergy_sign_during', $assessment->allergy_sign_during) }}" class="paper-input"></td>
                    <td class="label-cell">Tanda-tanda Alergi</td>
                    <td><input type="text" name="allergy_sign_after" value="{{ old('allergy_sign_after', $assessment->allergy_sign_after) }}" class="paper-input"></td>
                </tr>

                <!-- Row 3 -->
                <tr>
                    <td class="label-cell">Nilai eGFR</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.01" name="egfr" min="0" max="300" value="{{ old('egfr', $assessment->egfr) }}" class="paper-input w-20 text-right">
                            <span class="text-[9px]">ml/menit/1,73m²</span>
                        </div>
                    </td>
                    <td class="label-cell">Gatal-gatal</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="itching_during" value="0" {{ old('itching_during', $assessment->itching_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="itching_during" value="1" {{ old('itching_during', $assessment->itching_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Gatal-gatal</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="itching_after" value="0" {{ old('itching_after', $assessment->itching_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="itching_after" value="1" {{ old('itching_after', $assessment->itching_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 4 -->
                <tr>
                    <td class="label-cell">Makan Terakhir</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Jam:</span>
                            <input type="text" data-clocklet="format: HH:mm" name="last_meal_time" value="{{ old('last_meal_time', $assessment->last_meal_time ? substr($assessment->last_meal_time, 0, 5) : '') }}" class="paper-input w-20 text-center">
                        </div>
                    </td>
                    <td class="label-cell">Mual</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="nausea_during" value="0" {{ old('nausea_during', $assessment->nausea_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="nausea_during" value="1" {{ old('nausea_during', $assessment->nausea_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Mual</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="nausea_after" value="0" {{ old('nausea_after', $assessment->nausea_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="nausea_after" value="1" {{ old('nausea_after', $assessment->nausea_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 5 -->
                <tr>
                    <td class="label-cell">Berat Badan</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="body_weight" min="1" max="500" value="{{ old('body_weight', $assessment->body_weight) }}" class="paper-input w-20 text-right">
                            <span>Kg</span>
                        </div>
                    </td>
                    <td class="label-cell">Pusing</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="dizziness_during" value="0" {{ old('dizziness_during', $assessment->dizziness_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="dizziness_during" value="1" {{ old('dizziness_during', $assessment->dizziness_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Pusing</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="dizziness_after" value="0" {{ old('dizziness_after', $assessment->dizziness_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="dizziness_after" value="1" {{ old('dizziness_after', $assessment->dizziness_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 6 -->
                <tr>
                    <td class="label-cell">Tekanan Darah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="text" name="blood_pressure" value="{{ old('blood_pressure', $assessment->blood_pressure) }}" placeholder="120/80" class="paper-input w-20 text-center">
                            <span>mmHg</span>
                        </div>
                    </td>
                    <td class="label-cell">Sesak Nafas</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="shortness_of_breath_during" value="0" {{ old('shortness_of_breath_during', $assessment->shortness_of_breath_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="shortness_of_breath_during" value="1" {{ old('shortness_of_breath_during', $assessment->shortness_of_breath_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Sesak Nafas</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="shortness_of_breath_after" value="0" {{ old('shortness_of_breath_after', $assessment->shortness_of_breath_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="shortness_of_breath_after" value="1" {{ old('shortness_of_breath_after', $assessment->shortness_of_breath_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 7 -->
                <tr>
                    <td class="label-cell">Nadi</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="pulse" min="30" max="220" value="{{ old('pulse', $assessment->pulse) }}" class="paper-input w-20 text-right">
                            <span>x/menit</span>
                        </div>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Mata Bengkak</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="swollen_eyes_after" value="0" {{ old('swollen_eyes_after', $assessment->swollen_eyes_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="swollen_eyes_after" value="1" {{ old('swollen_eyes_after', $assessment->swollen_eyes_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 8 -->
                <tr>
                    <td class="label-cell">Suhu</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="temperature" min="35" max="43" value="{{ old('temperature', $assessment->temperature) }}" class="paper-input w-20 text-right">
                            <span>&deg;C</span>
                        </div>
                    </td>
                    <td class="label-cell">Pemasangan Infus</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Jam:</span>
                            <input type="text" data-clocklet="format: HH:mm" name="iv_insertion_time" value="{{ old('iv_insertion_time', $assessment->iv_insertion_time ? substr($assessment->iv_insertion_time, 0, 5) : '') }}" class="paper-input w-20 text-center">
                            <span>WIB</span>
                        </div>
                    </td>
                    <td class="label-cell">Bentol-bentol</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="bentol_after" value="0" {{ old('bentol_after', $assessment->bentol_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="bentol_after" value="1" {{ old('bentol_after', $assessment->bentol_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 9 -->
                <tr>
                    <td class="label-cell">Pernafasan</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="respiratory_rate" min="8" max="60" value="{{ old('respiratory_rate', $assessment->respiratory_rate) }}" class="paper-input w-20 text-right">
                            <span>x/menit</span>
                        </div>
                    </td>
                    <td class="label-cell">Regio</td>
                    <td><input type="text" name="region" value="{{ old('region', $assessment->region) }}" placeholder="cth: Antecubiti Dextra" class="paper-input"></td>
                    <td class="label-cell">Tekanan Darah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="text" name="post_blood_pressure" value="{{ old('post_blood_pressure', $assessment->post_blood_pressure) }}" placeholder="120/80" class="paper-input w-20 text-center">
                            <span>mmHg</span>
                        </div>
                    </td>
                </tr>

                <!-- Row 10 -->
                <tr>
                    <td class="label-cell">Saturasi O2</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="oxygen_saturation" min="50" max="100" value="{{ old('oxygen_saturation', $assessment->oxygen_saturation) }}" class="paper-input w-20 text-right">
                            <span>%</span>
                        </div>
                    </td>
                    <td class="label-cell">Ukuran IV Cath</td>
                    <td><input type="text" name="iv_cath_size" value="{{ old('iv_cath_size', $assessment->iv_cath_size) }}" placeholder="cth: 20G" class="paper-input"></td>
                    <td class="label-cell">Nadi</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="post_pulse" min="30" max="220" value="{{ old('post_pulse', $assessment->post_pulse) }}" class="paper-input w-20 text-right">
                            <span>x/menit</span>
                        </div>
                    </td>
                </tr>

                <!-- Row 11 & 12 (Keluhan rowspan=2) -->
                <tr>
                    <td rowspan="2" class="label-cell">Keluhan</td>
                    <td rowspan="2">
                        <textarea name="pre_procedure_complaint" class="paper-textarea h-full" style="height: 64px;">{{ old('pre_procedure_complaint', $assessment->pre_procedure_complaint) }}</textarea>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Suhu</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="post_temperature" min="35" max="43" value="{{ old('post_temperature', $assessment->post_temperature) }}" class="paper-input w-20 text-right">
                            <span>&deg;C</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Pernafasan</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="post_respiratory_rate" min="8" max="60" value="{{ old('post_respiratory_rate', $assessment->post_respiratory_rate) }}" class="paper-input w-20 text-right">
                            <span>x/menit</span>
                        </div>
                    </td>
                </tr>

                <!-- Row 13 -->
                <tr>
                    <td class="label-cell">Riwayat Alergi</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            <label><input type="radio" name="has_allergy_history" value="0" {{ old('has_allergy_history', $assessment->has_allergy_history ? '1' : '0') == '0' ? 'checked' : '' }} onchange="toggleAllergy(false)"> Tidak</label>
                            <label><input type="radio" name="has_allergy_history" value="1" {{ old('has_allergy_history', $assessment->has_allergy_history ? '1' : '0') == '1' ? 'checked' : '' }} onchange="toggleAllergy(true)"> Ada:</label>
                            <input type="text" name="allergy_description" id="allergy_desc_field" placeholder="..." value="{{ old('allergy_description', $assessment->allergy_description) }}" {{ old('has_allergy_history', $assessment->has_allergy_history ? '1' : '0') != '1' ? 'disabled' : '' }} class="paper-input w-24">
                        </div>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Saturasi O2</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="post_oxygen_saturation" min="50" max="100" value="{{ old('post_oxygen_saturation', $assessment->post_oxygen_saturation) }}" class="paper-input w-20 text-right">
                            <span>%</span>
                        </div>
                    </td>
                </tr>

                <!-- Row 14 -->
                <tr>
                    <td class="label-cell">Obat Media Kontras</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Batch:</span>
                            <input type="text" name="contrast_batch" value="{{ old('contrast_batch', $assessment->contrast_batch) }}" class="paper-input w-24">
                        </div>
                    </td>
                    <td class="label-cell">Tanda-tanda Ekstravasasi</td>
                    <td><input type="text" name="extravasation_sign_during" value="{{ old('extravasation_sign_during', $assessment->extravasation_sign_during) }}" placeholder="cth: Tidak ada" class="paper-input"></td>
                    <td class="label-cell"></td>
                    <td></td>
                </tr>

                <!-- Row 15 -->
                <tr>
                    <td class="label-cell">Konsentrasi</td>
                    <td><input type="text" name="contrast_concentration" value="{{ old('contrast_concentration', $assessment->contrast_concentration) }}" class="paper-input"></td>
                    <td class="label-cell">Bengkak</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="swelling_during" value="0" {{ old('swelling_during', $assessment->swelling_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="swelling_during" value="1" {{ old('swelling_during', $assessment->swelling_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Pelepasan Infus</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Jam:</span>
                            <input type="text" data-clocklet="format: HH:mm" name="iv_removal_time" value="{{ old('iv_removal_time', $assessment->iv_removal_time ? substr($assessment->iv_removal_time, 0, 5) : '') }}" class="paper-input w-20 text-center">
                            <span>WIB</span>
                        </div>
                    </td>
                </tr>

                <!-- Row 16 -->
                <tr>
                    <td class="label-cell">Dosis</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.01" name="contrast_dose_ml" min="0" max="500" value="{{ old('contrast_dose_ml', $assessment->contrast_dose_ml) }}" class="paper-input w-20 text-right">
                            <span>ml</span>
                        </div>
                    </td>
                    <td class="label-cell">Nyeri</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="pain_during" value="0" {{ old('pain_during', $assessment->pain_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="pain_during" value="1" {{ old('pain_during', $assessment->pain_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Tanda-tanda Ekstravasasi</td>
                    <td><input type="text" name="extravasation_sign_after" value="{{ old('extravasation_sign_after', $assessment->extravasation_sign_after) }}" class="paper-input"></td>
                </tr>

                <!-- Row 17 -->
                <tr>
                    <td class="label-cell">Dobel Cek Obat Kontras</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="contrast_double_check" value="0" {{ old('contrast_double_check', $assessment->contrast_double_check ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="contrast_double_check" value="1" {{ old('contrast_double_check', $assessment->contrast_double_check ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Kemerahan</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="redness_during" value="0" {{ old('redness_during', $assessment->redness_during ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="redness_during" value="1" {{ old('redness_during', $assessment->redness_during ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Bengkak</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="swelling_after" value="0" {{ old('swelling_after', $assessment->swelling_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="swelling_after" value="1" {{ old('swelling_after', $assessment->swelling_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 18 -->
                <tr>
                    <td class="label-cell">Test Alergi</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="allergy_test" value="0" {{ old('allergy_test', $assessment->allergy_test ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="allergy_test" value="1" {{ old('allergy_test', $assessment->allergy_test ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Nyeri</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="pain_after" value="0" {{ old('pain_after', $assessment->pain_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="pain_after" value="1" {{ old('pain_after', $assessment->pain_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 19 -->
                <tr>
                    <td class="label-cell">Hasil Test Alergi*</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            <label class="mr-2"><input type="radio" name="allergy_test_result" value="tidak_alergi" {{ old('allergy_test_result', $assessment->allergy_test_result) === 'tidak_alergi' ? 'checked' : '' }}> Tidak Alergi</label>
                            <label><input type="radio" name="allergy_test_result" value="alergi" {{ old('allergy_test_result', $assessment->allergy_test_result) === 'alergi' ? 'checked' : '' }}> Alergi</label>
                        </div>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Kemerahan</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="redness_after" value="0" {{ old('redness_after', $assessment->redness_after ? '1' : '0') == '0' ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="redness_after" value="1" {{ old('redness_after', $assessment->redness_after ? '1' : '0') == '1' ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- Row 20 -->
                <tr>
                    <td class="label-cell">Riwayat penyakit pasien</td>
                    <td>
                        @php
                            $histories = old('medical_history', $assessment->medical_history ?: []);
                        @endphp
                        <label class="checkbox-row"><input type="checkbox" name="medical_history[]" value="Kemo/Radioterapi" {{ in_array('Kemo/Radioterapi', $histories) ? 'checked' : '' }}> Kemo/Radioterapi</label>
                        <label class="checkbox-row"><input type="checkbox" name="medical_history[]" value="Diabetes" {{ in_array('Diabetes', $histories) ? 'checked' : '' }}> Diabetes</label>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell"></td>
                    <td></td>
                </tr>
            </table>
            </div>
        </div>

        <!-- HALAMAN 2 -->
        <div class="overflow-x-auto w-full mb-8">
            <div class="paper-container">
            <div class="form-header">
                <div style="font-weight: bold;">RS AWAL BROS<br><span style="font-size: 9px; font-weight: normal;">Pekanbaru</span></div>
                <div class="form-title">Catatan Pemberian Obat Kontras (Halaman 2 dari 2)</div>
                <button type="button" onclick="addMedicationRow()" class="no-print inline-flex items-center px-3 py-1.5 border border-slate-300 text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                    + Tambah Obat
                </button>
            </div>

            <!-- TABLE OBAT -->
            <table class="paper-table">
                <thead class="bg-slate-50">
                    <tr class="font-bold text-center">
                        <td style="width: 20%;">Nama Obat</td>
                        <td style="width: 10%;">Dosis</td>
                        <td style="width: 15%;">Rute Pemberian</td>
                        <td style="width: 10%;">Kecepatan</td>
                        <td style="width: 10%;">Tekanan</td>
                        <td style="width: 10%;">Jam</td>
                        <td style="width: 10%;">Reaksi</td>
                        <td style="width: 10%;">Keterangan</td>
                        <td style="width: 5%;" class="no-print">Aksi</td>
                    </tr>
                </thead>
                <tbody id="medicationTableBody">
                    @php
                        $meds = old('medications', $assessment->medications ?: []);
                    @endphp
                    @forelse($meds as $index => $med)
                        @php
                            // Can be Model or Array from old request
                            $medName = is_array($med) ? ($med['medication_name'] ?? '') : $med->medication_name;
                            $medDose = is_array($med) ? ($med['dose'] ?? '') : $med->dose;
                            $medRoute = is_array($med) ? ($med['administration_route'] ?? '') : $med->administration_route;
                            $medSpeed = is_array($med) ? ($med['speed'] ?? '') : $med->speed;
                            $medPressure = is_array($med) ? ($med['pressure'] ?? '') : $med->pressure;
                            $medAt = is_array($med) ? ($med['administered_at'] ?? '') : ($med->administered_at ? substr($med->administered_at, 0, 5) : '');
                            $medReaction = is_array($med) ? ($med['reaction'] ?? '') : $med->reaction;
                            $medNotes = is_array($med) ? ($med['notes'] ?? '') : $med->notes;
                        @endphp
                        <tr>
                            <td><input type="text" name="medications[{{ $index }}][medication_name]" value="{{ $medName }}" required class="paper-input" placeholder="Nama obat..."></td>
                            <td><input type="text" name="medications[{{ $index }}][dose]" value="{{ $medDose }}" class="paper-input text-center" placeholder="Dosis..."></td>
                            <td><input type="text" name="medications[{{ $index }}][administration_route]" value="{{ $medRoute }}" class="paper-input text-center" placeholder="Rute..."></td>
                            <td><input type="text" name="medications[{{ $index }}][speed]" value="{{ $medSpeed }}" class="paper-input text-center" placeholder="Kecepatan..."></td>
                            <td><input type="text" name="medications[{{ $index }}][pressure]" value="{{ $medPressure }}" class="paper-input text-center" placeholder="Tekanan..."></td>
                            <td><input type="text" data-clocklet="format: HH:mm" name="medications[{{ $index }}][administered_at]" value="{{ $medAt }}" class="paper-input text-center"></td>
                            <td><input type="text" name="medications[{{ $index }}][reaction]" value="{{ $medReaction }}" class="paper-input" placeholder="-"></td>
                            <td><input type="text" name="medications[{{ $index }}][notes]" value="{{ $medNotes }}" class="paper-input" placeholder="-"></td>
                            <td class="center no-print"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td><input type="text" name="medications[0][medication_name]" required class="paper-input" placeholder="Nama obat..."></td>
                            <td><input type="text" name="medications[0][dose]" class="paper-input text-center" placeholder="Dosis..."></td>
                            <td><input type="text" name="medications[0][administration_route]" class="paper-input text-center" placeholder="Rute..."></td>
                            <td><input type="text" name="medications[0][speed]" class="paper-input text-center" placeholder="Kecepatan..."></td>
                            <td><input type="text" name="medications[0][pressure]" class="paper-input text-center" placeholder="Tekanan..."></td>
                            <td><input type="text" data-clocklet="format: HH:mm" name="medications[0][administered_at]" class="paper-input text-center"></td>
                            <td><input type="text" name="medications[0][reaction]" class="paper-input" placeholder="-"></td>
                            <td><input type="text" name="medications[0][notes]" class="paper-input" placeholder="-"></td>
                            <td class="center no-print"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- SIGNATURE AREA FOR NURSE -->
            @if(Auth::user()->role === 'perawat')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center border-t border-slate-200 pt-6 mt-6">
                <div>
                    <span class="block text-xs font-bold text-slate-800 mb-2">Tanda Tangan Perawat Radiologi:</span>
                    @if($assessment->nurse_signature)
                        <div class="bg-white p-3 border border-slate-200 rounded-lg inline-block shadow-sm">
                            <img src="{{ $assessment->nurse_signature }}" alt="Tanda Tangan" class="h-16">
                            <span class="text-[10px] text-green-600 font-bold block mt-1">Sudah Ditandatangani</span>
                        </div>
                        <input type="hidden" name="nurse_signature" id="nurseSigInput" value="{{ $assessment->nurse_signature }}">
                    @elseif(Auth::user()->signature)
                        <div class="bg-white p-3 border border-slate-200 rounded-lg inline-block shadow-sm">
                            <img src="{{ Auth::user()->signature }}" alt="Tanda Tangan" class="h-16">
                            <span class="text-[10px] text-slate-500 font-bold block mt-1">Otomatis Terisi saat klik "Minta TTD Dokter"</span>
                        </div>
                        <input type="hidden" name="nurse_signature" id="nurseSigInput" value="">
                    @else
                        <div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-lg">
                            Anda belum mengunggah tanda tangan di Master TTD. Silakan 
                            <a href="{{ route('signatures.index') }}" class="underline font-semibold text-blue-600" target="_blank">Unggah TTD Anda di sini</a> 
                            agar dapat mengirim dokumen untuk ditandatangani dokter.
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- SIGNATURE AREA FOR DOCTOR (IF LOGGED IN AS DOKTER) -->
            @if(Auth::user()->role === 'dokter')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center border-t border-slate-200 pt-6 mt-6">
                <div>
                    <span class="block text-xs font-bold text-slate-800 mb-2">Tanda Tangan Dokter Spesialis Radiologi:</span>
                    @if(Auth::user()->signature)
                        <div class="bg-white p-3 border border-slate-200 rounded-lg inline-block shadow-sm">
                            <img src="{{ Auth::user()->signature }}" alt="Tanda Tangan" class="h-16">
                            <span class="text-[10px] text-green-600 font-bold block mt-1">Otomatis dari Profil Master TTD</span>
                        </div>
                        <input type="hidden" name="doctor_signature" id="doctorSigInput" value="{{ Auth::user()->signature }}">
                    @else
                        <div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-lg">
                            Anda belum mengunggah tanda tangan di Master TTD. Silakan 
                            <a href="{{ route('signatures.index') }}" class="underline font-semibold text-blue-600" target="_blank">Unggah TTD Anda di sini</a> 
                            agar dapat melakukan tanda tangan otomatis.
                        </div>
                    @endif
                </div>
                <div class="text-xs text-slate-500 space-y-2">
                    <p class="font-bold text-slate-800">Tanda Tangan Dokter Spesialis</p>
                    <p>Sistem mendeteksi tanda tangan PNG Anda yang diunggah di menu Master TTD. Tanda tangan ini akan otomatis dicantumkan pada lembar Asesmen Radiologi Kontras.</p>
                </div>
            </div>
            @endif
            </div>
        </div>

        <!-- CONTROL BUTTONS -->
        <div class="flex justify-end space-x-4 max-w-7xl mx-auto px-4 pb-12">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                Batal
            </a>
            @if(Auth::user()->role === 'perawat')
                <button type="button" onclick="submitAsDraft(event)" class="px-6 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                    Simpan Draft
                </button>
                <button type="button" onclick="submitMintaTtd(event)" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-750 transition cursor-pointer">
                    Minta TTD Dokter
                </button>
            @else
                <button type="submit" onclick="submitForm(event)" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-750 transition cursor-pointer">
                    Simpan Perubahan
                </button>
            @endif
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
            field.focus();
        } else {
            field.setAttribute('disabled', 'true');
            field.value = '';
        }
    }

    let medIndex = {{ old('medications', $assessment->radiologyContrastMedications) ? count(old('medications', $assessment->radiologyContrastMedications)) : 1 }};
    function addMedicationRow() {
        const tbody = document.getElementById('medicationTableBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="medications[${medIndex}][medication_name]" required class="paper-input" placeholder="Nama obat..."></td>
            <td><input type="text" name="medications[${medIndex}][dose]" class="paper-input text-center" placeholder="Dosis..."></td>
            <td><input type="text" name="medications[${medIndex}][administration_route]" class="paper-input text-center" placeholder="Rute..."></td>
            <td><input type="text" name="medications[${medIndex}][speed]" class="paper-input text-center" placeholder="Kecepatan..."></td>
            <td><input type="text" name="medications[${medIndex}][pressure]" class="paper-input text-center" placeholder="Tekanan..."></td>
            <td><input type="text" data-clocklet="format: HH:mm" name="medications[${medIndex}][administered_at]" class="paper-input text-center"></td>
            <td><input type="text" name="medications[${medIndex}][reaction]" class="paper-input" placeholder="-"></td>
            <td><input type="text" name="medications[${medIndex}][notes]" class="paper-input" placeholder="-"></td>
            <td class="center no-print"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
        `;
        tbody.appendChild(tr);
        medIndex++;
        saveDraft();
    }

    function removeMedRow(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('#medicationTableBody tr').length > 1) {
            row.remove();
            saveDraft();
        } else {
            alert('Minimal harus ada 1 baris catatan pemberian obat.');
        }
    }

    const storageKey = 'assessment_draft_edit_{{ $assessment->id }}';
    const form = document.getElementById('assessmentForm');

    function saveDraft() {
        const formData = {};
        const elements = form.querySelectorAll('input, select, textarea');
        
        elements.forEach(el => {
            if (!el.name) return;
            
            if (el.type === 'radio') {
                if (el.checked) {
                    formData[el.name] = el.value;
                }
            } else if (el.type === 'checkbox') {
                if (!formData[el.name]) {
                    formData[el.name] = [];
                }
                if (el.checked) {
                    if (el.name.endsWith('[]')) {
                        formData[el.name].push(el.value);
                    } else {
                        formData[el.name] = el.value;
                    }
                }
            } else {
                formData[el.name] = el.value;
            }
        });
        
        localStorage.setItem(storageKey, JSON.stringify(formData));
    }

    function loadDraft() {
        const rawData = localStorage.getItem(storageKey);
        if (!rawData) return;
        
        try {
            const formData = JSON.parse(rawData);
            
            // Recreate medication rows if they exist in draft
            let maxMedIndex = 0;
            Object.keys(formData).forEach(key => {
                const match = key.match(/^medications\[(\d+)\]/);
                if (match) {
                    const idx = parseInt(match[1]);
                    if (idx > maxMedIndex) {
                        maxMedIndex = idx;
                    }
                }
            });
            
            for (let i = 1; i <= maxMedIndex; i++) {
                if (!form.querySelector(`[name="medications[${i}][medication_name]"]`)) {
                    addMedicationRow();
                }
            }

            const elements = form.querySelectorAll('input, select, textarea');
            elements.forEach(el => {
                if (!el.name || formData[el.name] === undefined) return;
                
                if (el.type === 'radio') {
                    if (el.value === formData[el.name]) {
                        el.checked = true;
                        el.dispatchEvent(new Event('change'));
                    }
                } else if (el.type === 'checkbox') {
                    if (el.name.endsWith('[]')) {
                        if (Array.isArray(formData[el.name]) && formData[el.name].includes(el.value)) {
                            el.checked = true;
                            el.dispatchEvent(new Event('change'));
                        }
                    } else {
                        if (el.value === formData[el.name]) {
                            el.checked = true;
                            el.dispatchEvent(new Event('change'));
                        }
                    }
                } else {
                    el.value = formData[el.name];
                    el.dispatchEvent(new Event('change'));
                }
            });

            // Auto handle allergy visibility based on the restored value
            const allergyRadio = form.querySelector('input[name="has_allergy_history"]:checked');
            if (allergyRadio) {
                toggleAllergy(allergyRadio.value === '1');
            }
            
            showToast('Draf perubahan formulir yang belum disimpan berhasil dipulihkan secara otomatis.', 'success');
        } catch (e) {
            console.error('Gagal memuat draf:', e);
        }
    }

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    form.addEventListener('input', debounce(saveDraft, 500));
    form.addEventListener('change', saveDraft);

    window.addEventListener('load', () => {
        loadDraft();
    });

    function submitAsDraft(event) {
        event.preventDefault();
        const nurseSig = document.getElementById('nurseSigInput');
        if (nurseSig) {
            nurseSig.value = ''; // Kosongkan agar status kembali ke Draft / Belum Lengkap
        }
        localStorage.removeItem(storageKey);
        document.getElementById('assessmentForm').submit();
    }

    function submitMintaTtd(event) {
        event.preventDefault();
        @if(Auth::user()->signature)
            const nurseSig = document.getElementById('nurseSigInput');
            if (nurseSig) {
                nurseSig.value = "{{ Auth::user()->signature }}"; // Set ttd perawat agar status menjadi Menunggu TTD Dokter
            }
        @else
            alert('Anda harus mengunggah tanda tangan terlebih dahulu di Master TTD sebelum meminta TTD Dokter.');
            return;
        @endif
        localStorage.removeItem(storageKey);
        document.getElementById('assessmentForm').submit();
    }

    function submitForm(event) {
        event.preventDefault();
        @if(Auth::user()->role === 'dokter')
            @if(!Auth::user()->signature)
                alert('Anda harus mengunggah tanda tangan terlebih dahulu di Master TTD sebelum menyimpan perubahan.');
                return;
            @endif
        @endif
        localStorage.removeItem(storageKey);
        document.getElementById('assessmentForm').submit();
    }
</script>
@endsection
