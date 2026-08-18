<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Asesmen Tindakan Radiologi Kontras</title>

    <style>
        /* =========================================================
           PAGE SETTING
        ========================================================= */

        @page {
            size: A4 landscape;
            /* margin: 8mm; */
            /* width: 100%; */

        }

        * {
            box-sizing: border-box;
            /* padding: ; */
        }

        html,
        body {
            margin: 0;
            padding: -10px 20px 20px 20px;
            background: #fff;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .page {
            width: 100%;
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            width: 100%;
            margin-bottom: 0px;
            border: none;
        }

        .header td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 18%;
        }

        .logo img {
            height: 30px;
            width: auto;
        }

        .judul {
            width: 35%;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            line-height: 20px;
        }

        .header-spacer {
            width: 25%;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: middle;
            line-height: 13px;
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

        /* =========================================================
           IDENTITAS PASIEN
        ========================================================= */

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

        /* =========================================================
           TABEL TINDAKAN
        ========================================================= */

        .tindakan {
            margin-top: 3px;
        }

        .tindakan td {
            height: 18px;
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
            font-size: 11px;
            padding: 4px;
            height: 23px;
            line-height: 15px;
            background: #f3f4f6;
        }

        /* =========================================================
           CHECKBOX / RADIO STATIC
        ========================================================= */

        .check {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            white-space: nowrap;
        }

        .check-space {
            display: inline-block;
            width: 5px;
        }

        /* =========================================================
           PAGE 2 - OBAT
        ========================================================= */

        .tabel-obat {
            width: 100%;
        }

        .tabel-obat td {
            height: 25px;
        }

        .tabel-obat .header-tabel td {
            font-weight: bold;
            text-align: center;
            background: #f3f4f6;
        }

        /* =========================================================
           TEMPAT & WAKTU
        ========================================================= */

        .tempat-waktu {
            font-size: 10px;
            line-height: 16px;
            margin-top: 6px;
        }

        /* =========================================================
           TANDA TANGAN
        ========================================================= */

        .ttd-area {
            width: 100%;
            margin-top: 15px;
        }

        .ttd-area table {
            border: none;
        }

        .ttd-area td {
            width: 50%;
            border: none;
            text-align: center;
            vertical-align: top;
        }

        .ttd-jabatan {
            font-weight: bold;
            font-size: 10px;
        }

        .ttd-ruang {
            height: 65px;
            text-align: center;
            vertical-align: middle;
        }

        .ttd-ruang img {
            max-height: 60px;
            max-width: 160px;
        }

        .ttd-garis {
            font-size: 10px;
            font-weight: bold;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer-area {
            width: 100%;
            margin-top: 5px;
        }

        .footer-area table {
            border: none;
        }

        .footer-area td {
            border: none;
            padding: 0;
            vertical-align: bottom;
        }

        .catatan {
            width: 70%;
            font-size: 10px;
            line-height: 14px;
        }

        .catatan-indent {
            margin-left: 42px;
        }

        .footer-dokumen {
            width: 30%;
            text-align: right;
            font-size: 8px;
            line-height: 10px;
        }

        .kode-dokumen {
            border: 1px solid #000;
            padding: 1px 4px;
            display: inline-block;
        }

        /* =========================================================
           DOMPDF
        ========================================================= */

        tr {
            page-break-inside: avoid;
        }

        img {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <!-- =========================================================
         HALAMAN 1
    ========================================================= -->

    <div class="page page-break">

        <!-- HEADER -->
        <table class="header">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('login.png') }}" alt="Logo">
                </td>

                <td class="judul">
                    ASESMEN TINDAKAN RADIOLOGI KONTRAS
                </td>

                <td class="header-spacer"></td>
            </tr>
        </table>

        <!-- =====================================================
             IDENTITAS PASIEN
        ===================================================== -->

        <table class="identitas">

            <tr>
                <td rowspan="3" class="label bold">
                    Identitas Pasien
                </td>

                <td rowspan="3" class="stiker">
                    <div style="font-size: 12px; font-weight: bold; line-height: 16px;">

                        {{ $assessment->patient->name }}

                        <br>

                        {{ $assessment->patient->medical_record_number }}

                        <br>

                        {{ $assessment->patient->date_of_birth ? $assessment->patient->date_of_birth->format('d-m-Y') : '-' }}

                        @if ($assessment->patient->date_of_birth)
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

                    &nbsp;&nbsp;&nbsp;&nbsp;

                    Jam:

                    {{ $assessment->procedure_time ? substr($assessment->procedure_time, 0, 5) : '-' }}

                    WIB

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


        <!-- =====================================================
             TABEL ASESMEN
        ===================================================== -->

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

                <td class="label">
                    Keadaan Umum
                </td>

                <td class="isi">
                    {!! $assessment->general_condition ? nl2br(e($assessment->general_condition)) : '-' !!}
                </td>

                <td class="label">
                    Keluhan
                </td>

                <td class="isi">
                    {!! $assessment->during_complaint ? nl2br(e($assessment->during_complaint)) : '-' !!}
                </td>

                <td class="label">
                    Keluhan
                </td>

                <td class="isi">
                    {!! $assessment->post_procedure_complaint ? nl2br(e($assessment->post_procedure_complaint)) : '-' !!}
                </td>

            </tr>


            <!-- 2 -->
            <tr>

                <td class="label">
                    Tingkat Kesadaran
                </td>

                <td class="isi">
                    {!! $assessment->consciousness_level ? nl2br(e($assessment->consciousness_level)) : '-' !!}
                </td>

                <td class="label">
                    Tanda-tanda Alergi
                </td>

                <td class="isi">
                    {!! $assessment->allergy_sign_during ? nl2br(e($assessment->allergy_sign_during)) : '-' !!}
                </td>

                <td class="label">
                    Tanda-tanda Alergi
                </td>

                <td class="isi">
                    {!! $assessment->allergy_sign_after ? nl2br(e($assessment->allergy_sign_after)) : '-' !!}
                </td>

            </tr>


            <!-- 3 -->
            <tr>

                <td class="label">
                    Nilai eGFR
                </td>

                <td class="isi right bold">
                    {{ $assessment->egfr ?: '-' }}
                    <span style="font-weight:normal;font-size:9px;">
                        ml/menit/1,73m²
                    </span>
                </td>

                <td class="label">
                    Gatal-gatal
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->itching_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->itching_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

                <td class="label">
                    Gatal-gatal
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->itching_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->itching_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

            </tr>


            <!-- 4 -->
            <tr>

                <td class="label">
                    Makan Terakhir
                </td>

                <td class="isi right">
                    Jam:
                    {{ $assessment->last_meal_time ? substr($assessment->last_meal_time, 0, 5) : '-' }}
                    WIB
                </td>

                <td class="label">
                    Mual
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->nausea_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->nausea_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

                <td class="label">
                    Mual
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->nausea_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->nausea_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

            </tr>


            <!-- 5 -->
            <tr>

                <td class="label">
                    Berat Badan
                </td>

                <td class="isi right">
                    {{ $assessment->body_weight ?: '-' }} Kg
                </td>

                <td class="label">
                    Pusing
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->dizziness_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->dizziness_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

                <td class="label">
                    Pusing
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->dizziness_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->dizziness_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

            </tr>


            <!-- 6 -->
            <tr>

                <td class="label">
                    Tekanan Darah
                </td>

                <td class="isi right">
                    {{ $assessment->blood_pressure ?: '-' }} mmHg
                </td>

                <td class="label">
                    Sesak Nafas
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->shortness_of_breath_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->shortness_of_breath_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

                <td class="label">
                    Sesak Nafas
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->shortness_of_breath_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->shortness_of_breath_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

            </tr>


            <!-- 7 -->
            <tr>

                <td class="label">
                    Nadi
                </td>

                <td class="isi right">
                    {{ $assessment->pulse ?: '-' }} x/menit
                </td>

                <td class="label"></td>
                <td class="isi"></td>

                <td class="label">
                    Mata Bengkak
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->swollen_eyes_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->swollen_eyes_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

            </tr>


            <!-- 8 -->
            <tr>

                <td class="label">
                    Suhu
                </td>

                <td class="isi right">
                    {{ $assessment->temperature ?: '-' }} °C
                </td>

                <td class="label">
                    Pemasangan Infus
                </td>

                <td class="isi right">
                    Jam:
                    {{ $assessment->iv_insertion_time ? substr($assessment->iv_insertion_time, 0, 5) : '-' }}
                    WIB
                </td>

                <td class="label">
                    Bentol-bentol
                </td>

                <td class="isi">
                    <span class="check">
                        {{ !$assessment->bentol_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    <span class="check-space"></span>

                    <span class="check">
                        {{ $assessment->bentol_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya
                </td>

            </tr>


            <!-- 9 -->
            <tr>

                <td class="label">
                    Pernafasan
                </td>

                <td class="isi right">
                    {{ $assessment->respiratory_rate ?: '-' }} x/menit
                </td>

                <td class="label">
                    Regio
                </td>

                <td class="isi">
                    {{ $assessment->region ?: '-' }}
                </td>

                <td class="label">
                    Tekanan Darah
                </td>

                <td class="isi right">
                    {{ $assessment->post_blood_pressure ?: '-' }} mmHg
                </td>

            </tr>


            <!-- 10 -->
            <tr>

                <td class="label">
                    Saturasi O2
                </td>

                <td class="isi right">
                    {{ $assessment->oxygen_saturation ?: '-' }} %
                </td>

                <td class="label">
                    Ukuran IV <i>Cath</i>
                </td>

                <td class="isi">
                    {{ $assessment->iv_cath_size ?: '-' }}
                </td>

                <td class="label">
                    Nadi
                </td>

                <td class="isi right">
                    {{ $assessment->post_pulse ?: '-' }} x/menit
                </td>

            </tr>


            <!-- 11 -->
            <tr>

                <td rowspan="2" class="label">
                    Keluhan
                </td>

                <td rowspan="2" class="isi">
                    {{ $assessment->pre_procedure_complaint ?: '-' }}
                </td>

                <td class="label"></td>
                <td class="isi"></td>

                <td class="label">
                    Suhu
                </td>

                <td class="isi right">
                    {{ $assessment->post_temperature ?: '-' }} °C
                </td>

            </tr>


            <!-- 12 -->
            <tr>

                <td class="label"></td>
                <td class="isi"></td>

                <td class="label">
                    Pernafasan
                </td>

                <td class="isi right">
                    {{ $assessment->post_respiratory_rate ?: '-' }} x/menit
                </td>

            </tr>


            <!-- 13 -->
            <tr>

                <td class="label">
                    Riwayat Alergi
                </td>

                <td class="isi left">

                    <span class="check">
                        {{ !$assessment->has_allergy_history ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->has_allergy_history ? '[X]' : '[ ]' }}
                    </span>
                    Ada:

                    <strong>
                        <u>
                            {{ $assessment->allergy_description ?: '-' }}
                        </u>
                    </strong>

                </td>

                <td class="label"></td>
                <td class="isi"></td>

                <td class="label">
                    Saturasi O2
                </td>

                <td class="isi right">
                    {{ $assessment->post_oxygen_saturation ?: '-' }} %
                </td>

            </tr>


            <!-- 14 -->
            <tr>

                <td class="label">
                    Obat Media Kontras
                </td>

                <td class="isi left">

                    Batch:

                    <strong>
                        <u>
                            {{ $assessment->contrast_batch ?: '-' }}
                        </u>
                    </strong>

                </td>

                <td class="label">
                    Tanda-tanda Ekstravasasi
                </td>

                <td class="isi">
                    {!! $assessment->extravasation_sign_during ? nl2br(e($assessment->extravasation_sign_during)) : '-' !!}
                </td>

                <td class="label"></td>
                <td class="isi"></td>

            </tr>


            <!-- 15 -->
            <tr>

                <td class="label">
                    Konsentrasi
                </td>

                <td class="isi">
                    {{ $assessment->contrast_concentration ?: '-' }}
                </td>

                <td class="label">
                    Bengkak
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->swelling_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->swelling_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

                <td class="label">
                    Pelepasan Infus
                </td>

                <td class="isi right">

                    Jam:

                    {{ $assessment->iv_removal_time ? substr($assessment->iv_removal_time, 0, 5) : '-' }}

                    WIB

                </td>

            </tr>


            <!-- 16 -->
            <tr>

                <td class="label">
                    Dosis
                </td>

                <td class="isi right">
                    {{ $assessment->contrast_dose_ml ?: '-' }} ml
                </td>

                <td class="label">
                    Nyeri
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->pain_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->pain_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

                <td class="label">
                    Tanda-tanda Ekstravasasi
                </td>

                <td class="isi">

                    {!! $assessment->extravasation_sign_after ? nl2br(e($assessment->extravasation_sign_after)) : '-' !!}

                </td>

            </tr>


            <!-- 17 -->
            <tr>

                <td class="label">
                    Dobel Cek Obat Kontras
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->contrast_double_check ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->contrast_double_check ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

                <td class="label">
                    Kemerahan
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->redness_during ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->redness_during ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

                <td class="label">
                    Bengkak
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->swelling_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->swelling_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

            </tr>


            <!-- 18 -->
            <tr>

                <td class="label">
                    Test Alergi
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->allergy_test ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->allergy_test ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

                <td class="label"></td>
                <td class="isi"></td>

                <td class="label">
                    Nyeri
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->pain_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->pain_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

            </tr>


            <!-- 19 -->
            <tr>

                <td class="label">
                    Hasil Test Alergi*
                </td>

                <td class="isi">

                    <span class="check">
                        {{ $assessment->allergy_test_result === 'tidak_alergi' ? '[X]' : '[ ]' }}
                    </span>

                    Tidak Alergi

                    &nbsp;

                    <span class="check">
                        {{ $assessment->allergy_test_result === 'alergi' ? '[X]' : '[ ]' }}
                    </span>

                    Alergi

                </td>

                <td class="label"></td>
                <td class="isi"></td>

                <td class="label">
                    Kemerahan
                </td>

                <td class="isi">

                    <span class="check">
                        {{ !$assessment->redness_after ? '[X]' : '[ ]' }}
                    </span>
                    Tidak

                    &nbsp;

                    <span class="check">
                        {{ $assessment->redness_after ? '[X]' : '[ ]' }}
                    </span>
                    Ya

                </td>

            </tr>


            <!-- 20 -->
            <tr>

                <td class="label">
                    Riwayat penyakit pasien
                </td>

                <td class="isi left">

                    @php
                        $hist = $assessment->medical_history ?: [];
                    @endphp

                    <span class="check">
                        {{ in_array('Kemo/Radioterapi', $hist) ? '[X]' : '[ ]' }}
                    </span>

                    Kemo/Radioterapi

                    <br>

                    <span class="check">
                        {{ in_array('Diabetes', $hist) ? '[X]' : '[ ]' }}
                    </span>

                    Diabetes

                </td>

                <td class="label"></td>
                <td class="isi"></td>
                <td class="label"></td>
                <td class="isi"></td>

            </tr>

        </table>


        <!-- =====================================================
             FOOTER HALAMAN 1
        ===================================================== -->

        <div class="footer-area">

            <table>
                <tr>

                    <td class="catatan">

                        <strong>Catatan:</strong>
                        Bubuhkan ceklis (✓) pada [ ]

                        <br>

                        <span class="catatan-indent">
                            *15 menit pasca tes alergi
                        </span>

                    </td>

                    <td class="footer-dokumen">

                        <div class="kode-dokumen">
                            RSAB-AY/Rad/007/AKR/2025/Rev.00
                        </div>

                        <div>
                            Halaman 1 dari 2
                        </div>

                    </td>

                </tr>
            </table>

        </div>

    </div>


    <!-- =========================================================
         HALAMAN 2
    ========================================================= -->

    <div class="page">

        <!-- HEADER -->
        <table class="header" style="margin-top: 5px;">

            <tr>

                <td class="logo">
                    <img src="{{ public_path('login.png') }}" alt="Logo">
                </td>

                <td class="judul">
                    CATATAN PEMBERIAN OBAT KONTRAS
                </td>

                <td class="header-spacer"></td>

            </tr>

        </table>


        <!-- =====================================================
             TABEL OBAT KONTRAS
        ===================================================== -->

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

                    <td>
                        {{ $med->medication_name }}
                    </td>

                    <td class="center">
                        {{ $med->dose }}
                    </td>

                    <td class="center">
                        {{ $med->administration_route }}
                    </td>

                    <td class="center">
                        {{ $med->speed }}
                    </td>

                    <td class="center">
                        {{ $med->pressure }}
                    </td>

                    <td class="center">

                        {{ $med->administered_at ? substr($med->administered_at, 0, 5) : '-' }}

                        WIB

                    </td>

                    <td>
                        {{ $med->reaction }}
                    </td>

                    <td>
                        {{ $med->notes }}
                    </td>

                    <td class="center" style="font-size: 9px; font-weight: bold;">

                        {{-- {{ $med->nurse_initials ?: ($assessment->radiologyNurse ? $assessment->radiologyNurse->name : '') }} --}}

                        <div class="ttd-ruang" style="height: 50px; text-align: center; vertical-align: middle;">

                            @if ($assessment->nurse_signature)
                                <img src="{{ $assessment->nurse_signature }}" alt="Tanda Tangan Perawat">
                            @endif

                        </div>

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


        <!-- =====================================================
             TEMPAT DAN WAKTU
        ===================================================== -->

        <div class="tempat-waktu">

            <div>

                Pekanbaru,

                <span class="bold" style="text-decoration: underline;">

                    {{ $assessment->procedure_date ? $assessment->procedure_date->format('d M Y') : '-' }}

                </span>

            </div>

            <div>

                Jam:

                <span class="bold" style="text-decoration: underline;">

                    {{ $assessment->procedure_time ? substr($assessment->procedure_time, 0, 5) : '-' }}

                </span>

                WIB

            </div>

        </div>


        <!-- =====================================================
             TANDA TANGAN
        ===================================================== -->

        <div class="ttd-area">

            <table>

                <tr>

                    <!-- PERAWAT -->
                    <td>

                        <div class="ttd-jabatan">
                            Perawat Radiologi
                        </div>

                        <div class="ttd-ruang">

                            @if ($assessment->nurse_signature)
                                <img src="{{ $assessment->nurse_signature }}" alt="Tanda Tangan Perawat">
                            @endif

                        </div>

                        <div class="ttd-garis">

                            (
                            {{ $assessment->radiologyNurse ? $assessment->radiologyNurse->name : '................................' }}
                            )

                        </div>

                    </td>


                    <!-- DOKTER -->
                    <td>

                        <div class="ttd-jabatan">
                            Dokter Spesialis Radiologi
                        </div>

                        <div class="ttd-ruang">

                            @if ($assessment->doctor_signature)
                                <img src="{{ $assessment->doctor_signature }}" alt="Tanda Tangan Dokter">
                            @endif

                        </div>

                        <div class="ttd-garis">

                            (
                            {{ $assessment->radiologyDoctor ? $assessment->radiologyDoctor->name : '................................' }}
                            )

                        </div>

                    </td>

                </tr>

            </table>

        </div>


        <!-- =====================================================
             FOOTER HALAMAN 2
        ===================================================== -->

        <div class="footer-area" style="margin-top: 15px;">

            <table>

                <tr>

                    <td></td>

                    <td class="footer-dokumen">

                        <div class="kode-dokumen">
                            RSAB-AY/Rad/007/AKR/2025/Rev.00
                        </div>

                        <div>
                            Halaman 2 dari 2
                        </div>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</body>

</html>
