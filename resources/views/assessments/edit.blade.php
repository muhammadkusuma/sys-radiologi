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
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        background-color: #f1f5f9;
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
    }

    .paper-input:focus {
        background-color: #f8fafc;
        border-bottom: 1px solid #2563eb;
    }

    .paper-textarea {
        border: 1px solid #cbd5e1;
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

    <form action="{{ route('assessments.update', $assessment->id) }}" method="POST" id="assessmentForm">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

        <!-- HALAMAN 1 -->
        <div class="paper-container mb-8">
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
                            JK / Tgl Lahir: {{ $patient->gender }} / {{ $patient->date_of_birth ? $patient->date_of_birth->format('d/m/Y') : '-' }}<br>
                            Alamat: {{ $patient->address }}
                        </div>
                    </td>
                    <td class="label-cell">Tanggal Tindakan</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            <input type="date" name="procedure_date" value="{{ $assessment->procedure_date ? $assessment->procedure_date->format('Y-m-d') : '' }}" class="paper-input w-32">
                            <span>Jam:</span>
                            <input type="time" name="procedure_time" value="{{ $assessment->procedure_time ? substr($assessment->procedure_time, 0, 5) : '' }}" class="paper-input w-20">
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
                                <option value="{{ $doc->id }}" {{ $assessment->referring_doctor_id == $doc->id ? 'selected' : '' }}>{{ $doc->name }}</option>
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
                                <option value="{{ $ns->id }}" {{ $assessment->radiology_nurse_id == $ns->id ? 'selected' : '' }}>{{ $ns->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Diagnosis Pasien</td>
                    <td>
                        <input type="text" name="diagnosis" value="{{ $assessment->diagnosis }}" placeholder="Tulis diagnosis klinis..." class="paper-input">
                    </td>
                    <td class="label-cell">Jenis Pemeriksaan</td>
                    <td>
                        <input type="text" name="examination_type" value="{{ $assessment->examination_type }}" placeholder="cth: CT Scan Kepala Kontras" class="paper-input">
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

                <!-- 1 -->
                <tr>
                    <td class="label-cell">Keadaan Umum</td>
                    <td><input type="text" name="general_condition" value="{{ $assessment->general_condition }}" class="paper-input"></td>
                    <td class="label-cell">Keluhan</td>
                    <td><input type="text" name="during_complaint" value="{{ $assessment->during_complaint }}" class="paper-input"></td>
                    <td class="label-cell">Keluhan</td>
                    <td><input type="text" name="post_procedure_complaint" value="{{ $assessment->post_procedure_complaint }}" class="paper-input"></td>
                </tr>

                <!-- 2 -->
                <tr>
                    <td class="label-cell">Tingkat Kesadaran</td>
                    <td><input type="text" name="consciousness_level" value="{{ $assessment->consciousness_level }}" class="paper-input"></td>
                    <td class="label-cell">Tanda Alergi</td>
                    <td><input type="text" name="allergy_sign_during" value="{{ $assessment->allergy_sign_during }}" class="paper-input"></td>
                    <td class="label-cell">Tanda Alergi</td>
                    <td><input type="text" name="allergy_sign_after" value="{{ $assessment->allergy_sign_after }}" class="paper-input"></td>
                </tr>

                <!-- 3 -->
                <tr>
                    <td class="label-cell">Nilai eGFR</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.01" name="egfr" value="{{ $assessment->egfr }}" class="paper-input w-20 text-right">
                            <span class="text-[9px]">ml/mnt/1.73m²</span>
                        </div>
                    </td>
                    <td class="label-cell">Gatal-gatal</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="itching_during" value="0" {{ !$assessment->itching_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="itching_during" value="1" {{ $assessment->itching_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Gatal-gatal</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="itching_after" value="0" {{ !$assessment->itching_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="itching_after" value="1" {{ $assessment->itching_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 4 -->
                <tr>
                    <td class="label-cell">Makan Terakhir</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Jam:</span>
                            <input type="time" name="last_meal_time" value="{{ $assessment->last_meal_time ? substr($assessment->last_meal_time, 0, 5) : '' }}" class="paper-input w-20">
                        </div>
                    </td>
                    <td class="label-cell">Mual</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="nausea_during" value="0" {{ !$assessment->nausea_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="nausea_during" value="1" {{ $assessment->nausea_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Mual</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="nausea_after" value="0" {{ !$assessment->nausea_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="nausea_after" value="1" {{ $assessment->nausea_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 5 -->
                <tr>
                    <td class="label-cell">Berat Badan</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="body_weight" value="{{ $assessment->body_weight }}" class="paper-input w-20 text-right">
                            <span>Kg</span>
                        </div>
                    </td>
                    <td class="label-cell">Pusing</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="dizziness_during" value="0" {{ !$assessment->dizziness_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="dizziness_during" value="1" {{ $assessment->dizziness_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Pusing</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="dizziness_after" value="0" {{ !$assessment->dizziness_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="dizziness_after" value="1" {{ $assessment->dizziness_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 6 -->
                <tr>
                    <td class="label-cell">Tekanan Darah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="text" name="blood_pressure" value="{{ $assessment->blood_pressure }}" placeholder="120/80" class="paper-input w-20 text-center">
                            <span>mmHg</span>
                        </div>
                    </td>
                    <td class="label-cell">Sesak Nafas</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="shortness_of_breath_during" value="0" {{ !$assessment->shortness_of_breath_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="shortness_of_breath_during" value="1" {{ $assessment->shortness_of_breath_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Sesak Nafas</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="shortness_of_breath_after" value="0" {{ !$assessment->shortness_of_breath_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="shortness_of_breath_after" value="1" {{ $assessment->shortness_of_breath_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 7 -->
                <tr>
                    <td class="label-cell">Nadi</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="pulse" value="{{ $assessment->pulse }}" class="paper-input w-20 text-right">
                            <span>x/mnt</span>
                        </div>
                    </td>
                    <td class="label-cell">Pemasangan Infus</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Jam:</span>
                            <input type="time" name="iv_insertion_time" value="{{ $assessment->iv_insertion_time ? substr($assessment->iv_insertion_time, 0, 5) : '' }}" class="paper-input w-20">
                        </div>
                    </td>
                    <td class="label-cell">Mata Bengkak</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="swollen_eyes_after" value="0" {{ !$assessment->swollen_eyes_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="swollen_eyes_after" value="1" {{ $assessment->swollen_eyes_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 8 -->
                <tr>
                    <td class="label-cell">Suhu</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="temperature" value="{{ $assessment->temperature }}" class="paper-input w-20 text-right">
                            <span>&deg;C</span>
                        </div>
                    </td>
                    <td class="label-cell">Regio IV</td>
                    <td><input type="text" name="region" value="{{ $assessment->region }}" placeholder="cth: Antecubiti Dextra" class="paper-input"></td>
                    <td class="label-cell">Bentol-bentol</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="bentol_after" value="0" {{ !$assessment->bentol_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="bentol_after" value="1" {{ $assessment->bentol_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 9 -->
                <tr>
                    <td class="label-cell">Pernafasan</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="respiratory_rate" value="{{ $assessment->respiratory_rate }}" class="paper-input w-20 text-right">
                            <span>x/mnt</span>
                        </div>
                    </td>
                    <td class="label-cell">Ukuran IV Cath</td>
                    <td><input type="text" name="iv_cath_size" value="{{ $assessment->iv_cath_size }}" placeholder="cth: 20G" class="paper-input"></td>
                    <td class="label-cell">Tekanan Darah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="text" name="post_blood_pressure" value="{{ $assessment->post_blood_pressure }}" class="paper-input w-20 text-center">
                            <span>mmHg</span>
                        </div>
                    </td>
                </tr>

                <!-- 10 -->
                <tr>
                    <td class="label-cell">Saturasi O2</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="oxygen_saturation" value="{{ $assessment->oxygen_saturation }}" class="paper-input w-20 text-right">
                            <span>%</span>
                        </div>
                    </td>
                    <td class="label-cell">Tanda Ekstravasasi</td>
                    <td><input type="text" name="extravasation_sign_during" value="{{ $assessment->extravasation_sign_during }}" placeholder="cth: Tidak ada" class="paper-input"></td>
                    <td class="label-cell">Nadi setelah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="post_pulse" value="{{ $assessment->post_pulse }}" class="paper-input w-20 text-right">
                            <span>x/mnt</span>
                        </div>
                    </td>
                </tr>

                <!-- 11 -->
                <tr>
                    <td rowspan="2" class="label-cell">Keluhan</td>
                    <td rowspan="2"><textarea name="pre_procedure_complaint" class="paper-textarea">{{ $assessment->pre_procedure_complaint }}</textarea></td>
                    <td class="label-cell">Bengkak Saat</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="swelling_during" value="0" {{ !$assessment->swelling_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="swelling_during" value="1" {{ $assessment->swelling_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Suhu setelah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="post_temperature" value="{{ $assessment->post_temperature }}" class="paper-input w-20 text-right">
                            <span>&deg;C</span>
                        </div>
                    </td>
                </tr>

                <!-- 12 -->
                <tr>
                    <td class="label-cell">Nyeri Saat</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="pain_during" value="0" {{ !$assessment->pain_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="pain_during" value="1" {{ $assessment->pain_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Nafas setelah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" name="post_respiratory_rate" value="{{ $assessment->post_respiratory_rate }}" class="paper-input w-20 text-right">
                            <span>x/mnt</span>
                        </div>
                    </td>
                </tr>

                <!-- 13 -->
                <tr>
                    <td class="label-cell">Riwayat Alergi</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            <label><input type="radio" name="has_allergy_history" value="0" {{ !$assessment->has_allergy_history ? 'checked' : '' }} onchange="toggleAllergy(false)"> Tidak</label>
                            <label><input type="radio" name="has_allergy_history" value="1" {{ $assessment->has_allergy_history ? 'checked' : '' }} onchange="toggleAllergy(true)"> Ada:</label>
                            <input type="text" name="allergy_description" id="allergy_desc_field" placeholder="..." value="{{ $assessment->allergy_description }}" {{ !$assessment->has_allergy_history ? 'disabled' : '' }} class="paper-input w-24">
                        </div>
                    </td>
                    <td class="label-cell">Kemerahan Saat</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="redness_during" value="0" {{ !$assessment->redness_during ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="redness_during" value="1" {{ $assessment->redness_during ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Sat O2 setelah</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.1" name="post_oxygen_saturation" value="{{ $assessment->post_oxygen_saturation }}" class="paper-input w-20 text-right">
                            <span>%</span>
                        </div>
                    </td>
                </tr>

                <!-- 14 -->
                <tr>
                    <td class="label-cell">Media Kontras</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Batch:</span>
                            <input type="text" name="contrast_batch" value="{{ $assessment->contrast_batch }}" class="paper-input w-24">
                        </div>
                    </td>
                    <td class="label-cell">Test Alergi</td>
                    <td>
                        <label class="mr-2"><input type="checkbox" name="allergy_test" value="1" {{ $assessment->allergy_test ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Pelepasan Infus</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <span>Jam:</span>
                            <input type="time" name="iv_removal_time" value="{{ $assessment->iv_removal_time ? substr($assessment->iv_removal_time, 0, 5) : '' }}" class="paper-input w-20">
                        </div>
                    </td>
                </tr>

                <!-- 15 -->
                <tr>
                    <td class="label-cell">Konsentrasi</td>
                    <td><input type="text" name="contrast_concentration" value="{{ $assessment->contrast_concentration }}" class="paper-input"></td>
                    <td class="label-cell">Hasil Test Alergi</td>
                    <td>
                        <select name="allergy_test_result" class="paper-input">
                            <option value="">-- Pilih --</option>
                            <option value="tidak_alergi" {{ $assessment->allergy_test_result === 'tidak_alergi' ? 'selected' : '' }}>Tidak Alergi</option>
                            <option value="alergi" {{ $assessment->allergy_test_result === 'alergi' ? 'selected' : '' }}>Alergi</option>
                        </select>
                    </td>
                    <td class="label-cell">Tanda Ekstravasasi</td>
                    <td><input type="text" name="extravasation_sign_after" value="{{ $assessment->extravasation_sign_after }}" class="paper-input"></td>
                </tr>

                <!-- 16 -->
                <tr>
                    <td class="label-cell">Dosis Kontras</td>
                    <td>
                        <div class="flex items-center space-x-1">
                            <input type="number" step="0.01" name="contrast_dose_ml" value="{{ $assessment->contrast_dose_ml }}" class="paper-input w-20 text-right">
                            <span>ml</span>
                        </div>
                    </td>
                    <td class="label-cell">Double Check</td>
                    <td>
                        <label><input type="checkbox" name="contrast_double_check" value="1" {{ $assessment->contrast_double_check ? 'checked' : '' }}> Ya</label>
                    </td>
                    <td class="label-cell">Bengkak setelah</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="swelling_after" value="0" {{ !$assessment->swelling_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="swelling_after" value="1" {{ $assessment->swelling_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 17 -->
                <tr>
                    <td class="label-cell">Riwayat Penyakit</td>
                    <td>
                        @php
                            $histories = $assessment->medical_history ?: [];
                        @endphp
                        <label class="checkbox-row"><input type="checkbox" name="medical_history[]" value="Kemo/Radioterapi" {{ in_array('Kemo/Radioterapi', $histories) ? 'checked' : '' }}> Kemo/Radioterapi</label>
                        <label class="checkbox-row"><input type="checkbox" name="medical_history[]" value="Diabetes" {{ in_array('Diabetes', $histories) ? 'checked' : '' }}> Diabetes</label>
                    </td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Nyeri setelah</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="pain_after" value="0" {{ !$assessment->pain_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="pain_after" value="1" {{ $assessment->pain_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>

                <!-- 18 -->
                <tr>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell"></td>
                    <td></td>
                    <td class="label-cell">Kemerahan setelah</td>
                    <td>
                        <label class="mr-2"><input type="radio" name="redness_after" value="0" {{ !$assessment->redness_after ? 'checked' : '' }}> Tidak</label>
                        <label><input type="radio" name="redness_after" value="1" {{ $assessment->redness_after ? 'checked' : '' }}> Ya</label>
                    </td>
                </tr>
            </table>
        </div>

        <!-- HALAMAN 2 -->
        <div class="paper-container mb-8">
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
                    @forelse($assessment->medications as $index => $med)
                        <tr>
                            <td><input type="text" name="medications[{{ $index }}][medication_name]" value="{{ $med->medication_name }}" required class="paper-input" placeholder="Nama obat..."></td>
                            <td><input type="text" name="medications[{{ $index }}][dose]" value="{{ $med->dose }}" class="paper-input text-center" placeholder="Dosis..."></td>
                            <td><input type="text" name="medications[{{ $index }}][administration_route]" value="{{ $med->administration_route }}" class="paper-input text-center" placeholder="Rute..."></td>
                            <td><input type="text" name="medications[{{ $index }}][speed]" value="{{ $med->speed }}" class="paper-input text-center" placeholder="Kecepatan..."></td>
                            <td><input type="text" name="medications[{{ $index }}][pressure]" value="{{ $med->pressure }}" class="paper-input text-center" placeholder="Tekanan..."></td>
                            <td><input type="time" name="medications[{{ $index }}][administered_at]" value="{{ $med->administered_at ? substr($med->administered_at, 0, 5) : '' }}" class="paper-input text-center"></td>
                            <td><input type="text" name="medications[{{ $index }}][reaction]" value="{{ $med->reaction }}" class="paper-input" placeholder="-"></td>
                            <td><input type="text" name="medications[{{ $index }}][notes]" value="{{ $med->notes }}" class="paper-input" placeholder="-"></td>
                            <td class="center no-print"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td><input type="text" name="medications[0][medication_name]" required class="paper-input" placeholder="Nama obat..."></td>
                            <td><input type="text" name="medications[0][dose]" class="paper-input text-center" placeholder="Dosis..."></td>
                            <td><input type="text" name="medications[0][administration_route]" class="paper-input text-center" placeholder="Rute..."></td>
                            <td><input type="text" name="medications[0][speed]" class="paper-input text-center" placeholder="Kecepatan..."></td>
                            <td><input type="text" name="medications[0][pressure]" class="paper-input text-center" placeholder="Tekanan..."></td>
                            <td><input type="time" name="medications[0][administered_at]" class="paper-input text-center"></td>
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
                    @if($assessment->nurse_signature)
                        <div class="mb-3 text-center bg-white border border-slate-200 p-2 rounded-lg inline-block">
                            <span class="block text-[9px] text-slate-400 font-bold uppercase mb-1">Ttd Perawat Tersimpan:</span>
                            <img src="{{ $assessment->nurse_signature }}" alt="Ttd Perawat" class="h-16 mx-auto">
                        </div>
                    @endif
                    <span class="block text-xs font-bold text-slate-800 mb-2">Gambar Baru (Tanda Tangan Perawat Radiologi):</span>
                    <canvas id="nurseSigPad" class="signature-box" width="350" height="130"></canvas>
                    <div class="flex space-x-2 mt-2">
                        <button type="button" onclick="clearNursePad()" class="px-3 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded hover:bg-slate-350 cursor-pointer">Hapus</button>
                    </div>
                    <input type="hidden" name="nurse_signature" id="nurseSigInput" value="{{ $assessment->nurse_signature }}">
                </div>
            </div>
            @endif
        </div>

        <!-- CONTROL BUTTONS -->
        <div class="flex justify-end space-x-4 max-w-7xl mx-auto px-4 pb-12">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                Batal
            </a>
            <button type="submit" onclick="submitForm(event)" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-750 transition cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <!-- DOCTOR SIGNATURE AREA (IF DOKTER LOGGED IN) -->
    @if(Auth::user()->role === 'dokter')
    <div class="paper-container mb-12">
        <h2 class="text-sm font-bold text-slate-900 border-b border-slate-200 pb-3 mb-4">Tanda Tangan Dokter Spesialis Radiologi</h2>
        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 w-full md:w-auto">
                @if($assessment->doctor_signature)
                    <div class="mb-3 text-center bg-white border border-slate-200 p-2 rounded-lg inline-block">
                        <span class="block text-[9px] text-slate-400 font-bold uppercase mb-1">Ttd Dokter Tersimpan:</span>
                        <img src="{{ $assessment->doctor_signature }}" alt="Ttd Dokter" class="h-16 mx-auto">
                    </div>
                @endif
                <form action="{{ route('assessments.sign', $assessment->id) }}" method="POST" id="doctorSignForm">
                    @csrf
                    <span class="block text-xs font-bold text-slate-700 mb-2">Tanda Tangan di bawah ini:</span>
                    <canvas id="doctorSigPad" class="signature-box bg-white" width="350" height="130"></canvas>
                    <div class="flex space-x-2 mt-2">
                        <button type="button" onclick="clearDoctorPad()" class="px-3 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded hover:bg-slate-350 cursor-pointer">Hapus</button>
                        <button type="submit" onclick="submitDoctorSign(event)" class="px-3 py-1 bg-purple-600 hover:bg-purple-750 text-white text-xs font-semibold rounded cursor-pointer shadow-sm">Tanda Tangani & Validasi</button>
                    </div>
                    <input type="hidden" name="signature" id="doctorSigInput">
                </form>
            </div>
            <div class="text-xs text-slate-500 space-y-2">
                <p class="font-bold text-slate-800">Tanda Tangan Dokter Spesialis</p>
                <p>Dokumen ini telah diisi oleh Perawat. Silakan periksa kembali seluruh inputan sebelum memberikan Tanda Tangan digital Anda.</p>
                <p>Tanda tangan dokter akan memvalidasi dan menyelesaikan asesmen tindakan radiologi kontras ini.</p>
            </div>
        </div>
    </div>
    @endif
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

    let medIndex = {{ count($assessment->medications) ?: 1 }};
    function addMedicationRow() {
        const tbody = document.getElementById('medicationTableBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="medications[${medIndex}][medication_name]" required class="paper-input" placeholder="Nama obat..."></td>
            <td><input type="text" name="medications[${medIndex}][dose]" class="paper-input text-center" placeholder="Dosis..."></td>
            <td><input type="text" name="medications[${medIndex}][administration_route]" class="paper-input text-center" placeholder="Rute..."></td>
            <td><input type="text" name="medications[${medIndex}][speed]" class="paper-input text-center" placeholder="Kecepatan..."></td>
            <td><input type="text" name="medications[${medIndex}][pressure]" class="paper-input text-center" placeholder="Tekanan..."></td>
            <td><input type="time" name="medications[${medIndex}][administered_at]" class="paper-input text-center"></td>
            <td><input type="text" name="medications[${medIndex}][reaction]" class="paper-input" placeholder="-"></td>
            <td><input type="text" name="medications[${medIndex}][notes]" class="paper-input" placeholder="-"></td>
            <td class="center no-print"><button type="button" onclick="removeMedRow(this)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
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

    // Canvas drawing setup
    function setupCanvas(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;
        const ctx = canvas.getContext('2d');
        ctx.strokeStyle = "#000000";
        ctx.lineWidth = 3;
        ctx.lineCap = "round";

        let isDrawing = false;

        function getMousePos(canvasDom, e) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: (e.clientX || e.touches[0].clientX) - rect.left,
                y: (e.clientY || e.touches[0].clientY) - rect.top
            };
        }

        canvas.addEventListener('mousedown', function(e) {
            isDrawing = true;
            const pos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        });

        canvas.addEventListener('mousemove', function(e) {
            if (isDrawing) {
                const pos = getMousePos(canvas, e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }
        });

        canvas.addEventListener('mouseup', function() {
            isDrawing = false;
        });

        canvas.addEventListener('touchstart', function(e) {
            e.preventDefault();
            isDrawing = true;
            const pos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }, { passive: false });

        canvas.addEventListener('touchmove', function(e) {
            e.preventDefault();
            if (isDrawing) {
                const pos = getMousePos(canvas, e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }
        }, { passive: false });

        canvas.addEventListener('touchend', function() {
            isDrawing = false;
        });

        return { canvas, ctx };
    }

    const nurseObj = setupCanvas('nurseSigPad');
    const doctorObj = setupCanvas('doctorSigPad');

    function clearNursePad() {
        if (nurseObj) {
            nurseObj.ctx.clearRect(0, 0, nurseObj.canvas.width, nurseObj.canvas.height);
        }
    }

    function clearDoctorPad() {
        if (doctorObj) {
            doctorObj.ctx.clearRect(0, 0, doctorObj.canvas.width, doctorObj.canvas.height);
        }
    }

    function submitForm(event) {
        event.preventDefault();
        if (nurseObj) {
            const input = document.getElementById('nurseSigInput');
            const blank = document.createElement('canvas');
            blank.width = nurseObj.canvas.width;
            blank.height = nurseObj.canvas.height;
            if (nurseObj.canvas.toDataURL() !== blank.toDataURL()) {
                input.value = nurseObj.canvas.toDataURL();
            }
        }
        document.getElementById('assessmentForm').submit();
    }

    function submitDoctorSign(event) {
        event.preventDefault();
        if (doctorObj) {
            const input = document.getElementById('doctorSigInput');
            const blank = document.createElement('canvas');
            blank.width = doctorObj.canvas.width;
            blank.height = doctorObj.canvas.height;
            if (doctorObj.canvas.toDataURL() !== blank.toDataURL()) {
                input.value = doctorObj.canvas.toDataURL();
                document.getElementById('doctorSignForm').submit();
            } else {
                alert('Silakan tanda tangan terlebih dahulu pada canvas.');
            }
        }
    }
</script>
@endsection
