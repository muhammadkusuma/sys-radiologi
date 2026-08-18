<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Assement-Radiologi</title>

    <style>
        /* ========================================
    A4 LANDSCAPE - PRINT
    ======================================== */
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #fff;
        }

        body {
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .page-break {
            page-break-after: always;
        }

        /* ========================================
    CONTAINER
    ======================================== */
        .page {
            width: 100%;
            max-width: 277mm;
            margin: 0 auto;
            position: relative;
        }

        @media screen {

            html,
            body {
                background-color: #f8fafc !important;
            }

            .page {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 10mm 15mm;
                margin-top: 20px;
                margin-bottom: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            }

            .no-print-bar {
                background-color: #ffffff !important;
                border-bottom: 1px solid #cbd5e1 !important;
                color: #0f172a !important;
            }
        }

        /* ========================================
    HEADER / LOGO
    ======================================== */
        .header {
            width: 100%;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-area {
            display: flex;
            flex-direction: column;
        }

        .logo-text {
            font-weight: bold;
            font-size: 14px;
            color: #1e3a8a;
        }

        .logo-subtext {
            font-size: 9px;
            color: #4b5563;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            line-height: 20px;
            margin-bottom: 5px;
            flex-grow: 1;
        }

        .no-print-bar {
            background: #f1f5f9;
            padding: 10px 20px;
            border-bottom: 1px solid #cbd5e1;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ========================================
    TABLE
    ======================================== */
        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            margin: 0;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: middle;
            line-height: 14px;
            overflow-wrap: break-word;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        /* ========================================
    TABLE IDENTITAS
    ======================================== */
        .identitas {
            width: 100%;
        }

        .identitas td {
            height: 21px;
        }

        .identitas .label {
            width: 14%;
        }

        .identitas .stiker {
            width: 36%;
            padding: 6px;
        }

        .identitas .label-kanan {
            width: 19%;
        }

        .identitas .isi-kanan {
            width: 31%;
        }

        /* ========================================
    TABLE TINDAKAN
    ======================================== */
        .tindakan {
            width: 100%;
            margin-top: 6px;
        }

        .tindakan td {
            height: 21px;
        }

        .tindakan .label {
            width: 12%;
        }

        .tindakan .isi {
            width: 21%;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            padding: 4px;
            height: 23px;
            line-height: 15px;
            background-color: #f3f4f6;
        }

        /* ========================================
    INPUTS
    ======================================== */
        input[type="radio"],
        input[type="checkbox"] {
            width: 12px;
            height: 12px;
            margin: 0 3px 0 0;
            vertical-align: middle;
        }

        label {
            white-space: nowrap;
        }

        .input-line {
            border: none;
            border-bottom: 1px dotted #000;
            outline: none;
            width: 85px;
            font-size: 11px;
            padding: 0;
            height: 14px;
            background: transparent;
        }

        .checkbox-row {
            display: block;
            line-height: 16px;
            white-space: nowrap;
        }

        .radio-row {
            white-space: nowrap;
        }

        /* ========================================
    PAGE 2 TABLE
    ======================================== */
        .tabel-obat td {
            height: 25px;
        }

        .tabel-obat .header-tabel {
            font-weight: bold;
            text-align: center;
            background-color: #f3f4f6;
        }

        .tempat-waktu {
            font-size: 11px;
            line-height: 16px;
            margin-top: 5px;
        }

        .ttd-area {
            display: flex;
            width: 100%;
            margin-top: 15px;
        }

        .ttd-kolom {
            width: 50%;
            text-align: center;
            font-size: 10px;
        }

        .ttd-jabatan {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .ttd-ruang {
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ttd-ruang img {
            max-height: 60px;
            width: auto;
        }

        .ttd-garis {
            font-size: 10px;
            font-weight: bold;
        }

        /* ========================================
    FOOTER
    ======================================== */
        .footer-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            margin-top: 5px;
        }

        .catatan {
            font-size: 11px;
            line-height: 15px;
            margin: 0;
        }

        .catatan-indent {
            margin-left: 48px;
        }

        .footer-dokumen {
            font-size: 8px;
            line-height: 10px;
            text-align: right;
            margin: 0;
        }

        .kode-dokumen {
            border: 1px solid #000;
            padding: 1px 4px;
            display: inline-block;
        }

        /* ========================================
    PRINT MEDIA
    ======================================== */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page {
                width: 99%;
                max-width: none;
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <!-- TOP CONTROL BAR (HIDDEN IN PRINT) -->
    <div class="no-print no-print-bar">
        <div style="font-size: 13px; font-weight: bold; color: #1e293b;">
            Mode Pratinjau Dokumen Medis
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('dashboard') }}"
                style="text-decoration: none; padding: 6px 14px; background: #fff; border: 1px solid #cbd5e1; border-radius: 6px; color: #475569; font-weight: 600; font-size: 12px;">
                &larr; Kembali
            </a>
            <a href="{{ route('assessments.pdf', $assessment->id) }}" target="_blank"
                style="text-decoration: none; padding: 6px 14px; background: #0f766e; border: none; border-radius: 6px; color: #fff; font-weight: 600; font-size: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Buka PDF
            </a>
            <button onclick="window.print()"
                style="cursor: pointer; padding: 6px 14px; background: #2563eb; border: none; border-radius: 6px; color: #fff; font-weight: 600; font-size: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Cetak Dokumen (Print)
            </button>
        </div>
    </div>

    <!-- PAGE 1 OF 2 -->
    <div class="page page-break">

        <div class="header">
            <div class="logo-area">
                {{-- <span class="logo-text">RS AWAL BROS</span>
                <span class="logo-subtext">Pekanbaru</span> --}}
                <img src="{{ asset('login.png') }}" alt="" srcset="" style="height: 40px">
            </div>
            <div class="judul">
                ASESMEN TINDAKAN RADIOLOGI KONTRAS
            </div>
            <div style="width: 100px;"></div>
        </div>

        <table class="identitas">
            <tr>
                <td rowspan="3" class="label bold center">
                    Identitas Pasien
                </td>
                <td rowspan="3" class="stiker">
                    <div style="font-size: 12px; font-weight: bold; line-height: 16px;">
                        {{ $assessment->patient->name }}<br>
                        {{ $assessment->patient->medical_record_number }}<br>
                        {{ $assessment->patient->date_of_birth ? $assessment->patient->date_of_birth->format('d-m-Y') : '-' }} 
                        @if($assessment->patient->date_of_birth)
                            @php
                                $diff = $assessment->patient->date_of_birth->diff(now());
                                $ageStr = $diff->y . 'Th ' . $diff->m . 'Bln';
                            @endphp
                            ({{ $ageStr }})
                        @endif
                    </div>
                </td>
                <td class="label-kanan bold">
                    Tanggal Tindakan
                </td>
                <td class="isi-kanan right bold">
                    {{ $assessment->procedure_date ? $assessment->procedure_date->format('d/m/Y') : '-' }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Jam: {{ $assessment->procedure_time ? substr($assessment->procedure_time, 0, 5) : '-' }} WIB
                </td>
            </tr>
            <tr>
                <td class="label-kanan bold">
                    Dokter Pengirim
                </td>
                <td class="isi-kanan">
                    {{ $assessment->referringDoctor ? $assessment->referringDoctor->name : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label-kanan bold">
                    Perawat Radiologi
                </td>
                <td class="isi-kanan">
                    {{ $assessment->radiologyNurse ? $assessment->radiologyNurse->name : '-' }}
                </td>
            </tr>
            <tr>
                <td class="bold">
                    Diagnosis Pasien
                </td>
                <td>
                    {{ $assessment->diagnosis ?: '-' }}
                </td>
                <td class="label-kanan bold">
                    Jenis Pemeriksaan
                </td>
                <td class="isi-kanan">
                    {{ $assessment->examination_type ?: '-' }}
                </td>
            </tr>
        </table>

        <table class="tindakan">
            <!-- HEADER -->
            <tr>
                <td colspan="2" class="section-title">
                    Sebelum Tindakan
                </td>
                <td colspan="2" class="section-title">
                    Di Saat Tindakan
                </td>
                <td colspan="2" class="section-title">
                    Setelah Tindakan
                </td>
            </tr>

            <!-- 1 -->
            <tr>
                <td class="label">Keadaan Umum</td>
                <td class="isi">{!! $assessment->general_condition ? nl2br(e($assessment->general_condition)) : '-' !!}</td>
                <td class="label">Keluhan</td>
                <td class="isi">{!! $assessment->during_complaint ? nl2br(e($assessment->during_complaint)) : '-' !!}</td>
                <td class="label">Keluhan</td>
                <td class="isi">{!! $assessment->post_procedure_complaint ? nl2br(e($assessment->post_procedure_complaint)) : '-' !!}</td>
            </tr>

            <!-- 2 -->
            <tr>
                <td class="label">Tingkat Kesadaran</td>
                <td class="isi">{!! $assessment->consciousness_level ? nl2br(e($assessment->consciousness_level)) : '-' !!}</td>
                <td class="label">Tanda-tanda Alergi</td>
                <td class="isi">{!! $assessment->allergy_sign_during ? nl2br(e($assessment->allergy_sign_during)) : '-' !!}</td>
                <td class="label">Tanda-tanda Alergi</td>
                <td class="isi">{!! $assessment->allergy_sign_after ? nl2br(e($assessment->allergy_sign_after)) : '-' !!}</td>
            </tr>

            <!-- 3 -->
            <tr>
                <td class="label">Nilai eGFR</td>
                <td class="isi right bold">{{ $assessment->egfr ?: '-' }} <span
                        style="font-weight:normal; font-size:10px;">ml/menit/1,73m²</span></td>
                <td class="label">Gatal-gatal</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->itching_during)> Tidak
                    <input type="radio" @checked($assessment->itching_during)> Ya
                </td>
                <td class="label">Gatal-gatal</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->itching_after)> Tidak
                    <input type="radio" @checked($assessment->itching_after)> Ya
                </td>
            </tr>

            <!-- 4 -->
            <tr>
                <td class="label">Makan Terakhir</td>
                <td class="isi right">Jam:
                    {{ $assessment->last_meal_time ? substr($assessment->last_meal_time, 0, 5) : '-' }} WIB</td>
                <td class="label">Mual</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->nausea_during)> Tidak
                    <input type="radio" @checked($assessment->nausea_during)> Ya
                </td>
                <td class="label">Mual</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->nausea_after)> Tidak
                    <input type="radio" @checked($assessment->nausea_after)> Ya
                </td>
            </tr>

            <!-- 5 -->
            <tr>
                <td class="label">Berat Badan</td>
                <td class="isi right">{{ $assessment->body_weight ?: '-' }} Kg</td>
                <td class="label">Pusing</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->dizziness_during)> Tidak
                    <input type="radio" @checked($assessment->dizziness_during)> Ya
                </td>
                <td class="label">Pusing</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->dizziness_after)> Tidak
                    <input type="radio" @checked($assessment->dizziness_after)> Ya
                </td>
            </tr>

            <!-- 6 -->
            <tr>
                <td class="label">Tekanan Darah</td>
                <td class="isi right">{{ $assessment->blood_pressure ?: '-' }} mmHg</td>
                <td class="label">Sesak Nafas</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->shortness_of_breath_during)> Tidak
                    <input type="radio" @checked($assessment->shortness_of_breath_during)> Ya
                </td>
                <td class="label">Sesak Nafas</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->shortness_of_breath_after)> Tidak
                    <input type="radio" @checked($assessment->shortness_of_breath_after)> Ya
                </td>
            </tr>

            <!-- 7 -->
            <tr>
                <td class="label">Nadi</td>
                <td class="isi right">{{ $assessment->pulse ?: '-' }} x/menit</td>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label">Mata Bengkak</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->swollen_eyes_during)> Tidak
                    <input type="radio" @checked($assessment->swollen_eyes_during)> Ya
                </td>
            </tr>

            <!-- 8 -->
            <tr>
                <td class="label">Suhu</td>
                <td class="isi right">{{ $assessment->temperature ?: '-' }} °C</td>
                <td class="label">Pemasangan Infus</td>
                <td class="isi right">Jam:
                    {{ $assessment->iv_insertion_time ? substr($assessment->iv_insertion_time, 0, 5) : '-' }} WIB</td>
                <td class="label">Bentol-bentol</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->bentol_after)> Tidak
                    <input type="radio" @checked($assessment->bentol_after)> Ya
                </td>
            </tr>

            <!-- 9 -->
            <tr>
                <td class="label">Pernafasan</td>
                <td class="isi right">{{ $assessment->respiratory_rate ?: '-' }} x/menit</td>
                <td class="label">Regio</td>
                <td class="isi">{{ $assessment->region ?: '-' }}</td>
                <td class="label">Tekanan Darah</td>
                <td class="isi right">{{ $assessment->post_blood_pressure ?: '-' }} mmHg</td>
            </tr>

            <!-- 10 -->
            <tr>
                <td class="label">Saturasi O2</td>
                <td class="isi right">{{ $assessment->oxygen_saturation ?: '-' }} %</td>
                <td class="label">Ukuran IV <i>Cath</i></td>
                <td class="isi">{{ $assessment->iv_cath_size ?: '-' }}</td>
                <td class="label">Nadi</td>
                <td class="isi right">{{ $assessment->post_pulse ?: '-' }} x/menit</td>
            </tr>

            <!-- 11 -->
            <tr>
                <td rowspan="2" class="label">Keluhan</td>
                <td rowspan="2" class="isi">{{ $assessment->pre_procedure_complaint ?: '-' }}</td>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label">Suhu</td>
                <td class="isi right">{{ $assessment->post_temperature ?: '-' }} °C</td>
            </tr>

            <!-- 12 -->
            <tr>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label">Pernafasan</td>
                <td class="isi right">{{ $assessment->post_respiratory_rate ?: '-' }} x/menit</td>
            </tr>

            <!-- 13 -->
            <tr>
                <td class="label">Riwayat Alergi</td>
                <td class="isi left">
                    <input type="radio" @checked(!$assessment->has_allergy_history)> Tidak &nbsp;
                    <input type="radio" @checked($assessment->has_allergy_history)> Ada:
                    <span
                        style="font-weight: bold; text-decoration: underline;">{{ $assessment->allergy_description ?: '-' }}</span>
                </td>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label">Saturasi O2</td>
                <td class="isi right">{{ $assessment->post_oxygen_saturation ?: '-' }} %</td>
            </tr>

            <!-- 14 -->
            <tr>
                <td class="label">Obat Media Kontras</td>
                <td class="isi left">
                    Batch: <span
                        style="font-weight: bold; text-decoration: underline;">{{ $assessment->contrast_batch ?: '-' }}</span>
                </td>
                <td class="label">Tanda-tanda Ekstravasasi</td>
                <td class="isi">{!! $assessment->extravasation_sign_during ? nl2br(e($assessment->extravasation_sign_during)) : '-' !!}</td>
                <td class="label"></td>
                <td class="isi"></td>
            </tr>

            <!-- 15 -->
            <tr>
                <td class="label">Konsentrasi</td>
                <td class="isi">{{ $assessment->contrast_concentration ?: '-' }}</td>
                <td class="label">Bengkak</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->swelling_during)> Tidak
                    <input type="radio" @checked($assessment->swelling_during)> Ya
                </td>
                <td class="label">Pelepasan Infus</td>
                <td class="isi right">Jam:
                    {{ $assessment->iv_removal_time ? substr($assessment->iv_removal_time, 0, 5) : '-' }} WIB</td>
            </tr>

            <!-- 16 -->
            <tr>
                <td class="label">Dosis</td>
                <td class="isi right">{{ $assessment->contrast_dose_ml ?: '-' }} ml</td>
                <td class="label">Nyeri</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->pain_during)> Tidak
                    <input type="radio" @checked($assessment->pain_during)> Ya
                </td>
                <td class="label">Tanda-tanda Ekstravasasi</td>
                <td class="isi">{!! $assessment->extravasation_sign_after ? nl2br(e($assessment->extravasation_sign_after)) : '-' !!}</td>
            </tr>

            <!-- 17 -->
            <tr>
                <td class="label">Dobel Cek Obat Kontras</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->contrast_double_check)> Tidak
                    <input type="radio" @checked($assessment->contrast_double_check)> Ya
                </td>
                <td class="label">Kemerahan</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->redness_during)> Tidak
                    <input type="radio" @checked($assessment->redness_during)> Ya
                </td>
                <td class="label">Bengkak</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->swelling_after)> Tidak
                    <input type="radio" @checked($assessment->swelling_after)> Ya
                </td>
            </tr>

            <!-- 18 -->
            <tr>
                <td class="label">Test Alergi</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->allergy_test)> Tidak
                    <input type="radio" @checked($assessment->allergy_test)> Ya
                </td>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label">Nyeri</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->pain_after)> Tidak
                    <input type="radio" @checked($assessment->pain_after)> Ya
                </td>
            </tr>

            <!-- 19 -->
            <tr>
                <td class="label">Hasil Test Alergi*</td>
                <td class="isi">
                    <input type="radio" @checked($assessment->allergy_test_result === 'tidak_alergi')> Tidak Alergi
                    <input type="radio" @checked($assessment->allergy_test_result === 'alergi')> Alergi
                </td>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label">Kemerahan</td>
                <td class="isi">
                    <input type="radio" @checked(!$assessment->redness_after)> Tidak
                    <input type="radio" @checked($assessment->redness_after)> Ya
                </td>
            </tr>

            <!-- 20 -->
            <tr>
                <td class="label">Riwayat penyakit pasien</td>
                <td class="isi left">
                    @php
                        $hist = $assessment->medical_history ?: [];
                    @endphp
                    <input type="checkbox" @checked(in_array('Kemo/Radioterapi', $hist))> Kemo/Radioterapi<br>
                    <input type="checkbox" @checked(in_array('Diabetes', $hist))> Diabetes
                </td>
                <td class="label"></td>
                <td class="isi"></td>
                <td class="label"></td>
                <td class="isi"></td>
            </tr>
        </table>

        <div class="footer-area">
            <div class="catatan">
                <span class="bold">Catatan:</span>
                Bubuhkan ceklis (✓) pada ☐
                <br>
                <span class="catatan-indent">
                    *15 menit pasca tes alergi
                </span>
            </div>
            <div class="footer-dokumen">
                <div class="kode-dokumen">
                    RSAB-AY/Rad/007/AKR/2025/Rev.00
                </div>
                <div>
                    Halaman 1 dari 2
                </div>
            </div>
        </div>

    </div>

    <!-- PAGE 2 OF 2 -->
    <div class="page">

        <div class="header" style="margin-top: 15px;">
            <div class="logo-area">
                {{-- <span class="logo-text">RS AWAL BROS</span>
                <span class="logo-subtext">Pekanbaru</span> --}}
                <img src="{{ asset('login.png') }}" alt="" srcset="" style="height: 40px">
            </div>
            <div class="judul">
                CATATAN PEMBERIAN OBAT KONTRAS
            </div>
            <div style="width: 100px;"></div>
        </div>

        <table class="tabel-obat">
            <tr class="header-tabel">
                <td>Nama Obat</td>
                <td>Dosis</td>
                <td>Rute Pemberian</td>
                <td>Kecepatan</td>
                <td>Tekanan</td>
                <td>Jam</td>
                <td>Reaksi</td>
                <td>Keterangan</td>
                <td>Paraf Perawat</td>
            </tr>
            @forelse($assessment->medications as $med)
                <tr>
                    <td>{{ $med->medication_name }}</td>
                    <td class="center">{{ $med->dose }}</td>
                    <td class="center">{{ $med->administration_route }}</td>
                    <td class="center">{{ $med->speed }}</td>
                    <td class="center">{{ $med->pressure }}</td>
                    <td class="center">{{ $med->administered_at ? substr($med->administered_at, 0, 5) : '-' }} WIB
                    </td>
                    <td>{{ $med->reaction }}</td>
                    <td>{{ $med->notes }}</td>
                    <td class="center" style="font-size: 9px; font-weight: bold;">
                        {{ $med->nurse_initials ?: ($assessment->radiologyNurse ? $assessment->radiologyNurse->name : '') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endforelse
        </table>

        <!-- TEMPAT & WAKTU -->
        <div class="tempat-waktu">
            <div>
                Pekanbaru,
                <span id="current-print-date" class="bold" style="text-decoration: underline;">
                    {{ $assessment->procedure_date ? $assessment->procedure_date->format('d M Y') : date('d M Y') }}
                </span>
            </div>
            <div>
                Jam:
                <span id="current-print-time" class="bold" style="text-decoration: underline;">
                    {{ $assessment->procedure_time ? substr($assessment->procedure_time, 0, 5) : date('H:i') }}
                </span> WIB
            </div>
        </div>

        <!-- TANDA TANGAN -->
        <div class="ttd-area">
            <div class="ttd-kolom">
                <div class="ttd-jabatan">
                    Perawat Radiologi
                </div>
                <div class="ttd-ruang">
                    @if ($assessment->nurse_signature)
                        <img src="{{ $assessment->nurse_signature }}" alt="Ttd Perawat">
                    @else
                        <span style="color: #64748b; font-style: italic;">Belum ditandatangani</span>
                    @endif
                </div>
                <div class="ttd-garis">
                    (
                    {{ $assessment->radiologyNurse ? $assessment->radiologyNurse->name : '................................' }}
                    )
                </div>
            </div>

            <div class="ttd-kolom">
                <div class="ttd-jabatan">
                    Dokter Spesialis Radiologi
                </div>
                <div class="ttd-ruang">
                    @if ($assessment->doctor_signature)
                        <img src="{{ $assessment->doctor_signature }}" alt="Ttd Dokter">
                    @else
                        <span style="color: #64748b; font-style: italic;">Belum ditandatangani</span>
                    @endif
                </div>
                <div class="ttd-garis">
                    (
                    {{ $assessment->radiologyDoctor ? $assessment->radiologyDoctor->name : '................................' }}
                    )
                </div>
            </div>
        </div>

        <!-- FOOTER DOKUMEN -->
        <div class="footer-area" style="margin-top: 15px;">
            <div></div>
            <div class="footer-dokumen">
                <div class="kode-dokumen">
                    RSAB-AY/Rad/007/AKR/2025/Rev.00
                </div>
                <div>
                    Halaman 2 dari 2
                </div>
            </div>
        </div>

    </div>

    <script>
        function updatePrintTime() {
            const now = new Date();

            // Format Date: d M Y (e.g. 16 Aug 2026)
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const dateStr = now.getDate().toString().padStart(2, '0') + ' ' + months[now.getMonth()] + ' ' + now
                .getFullYear();

            // Format Time: H:i (e.g. 15:56)
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            const dateEl = document.getElementById('current-print-date');
            const timeEl = document.getElementById('current-print-time');

            if (dateEl) dateEl.textContent = dateStr;
            if (timeEl) timeEl.textContent = timeStr;
        }

        // Run immediately on DOMContentLoaded
        window.addEventListener('DOMContentLoaded', () => {
            updatePrintTime();

            // Disable all radio buttons and checkboxes in show view so they cannot be edited on screen
            document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(el => {
                el.disabled = true;
            });

            if (window.location.search.includes('download=1')) {
                setTimeout(() => {
                    window.print();
                }, 500);
            }
        });

        // Ensure it is fresh right before the print dialog opens
        window.addEventListener('beforeprint', updatePrintTime);
    </script>
</body>

</html>
