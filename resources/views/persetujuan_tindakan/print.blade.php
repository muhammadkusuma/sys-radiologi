<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Persetujuan - {{ $patient->name ?? '' }}</title>
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            line-height: 1.3;
            color: #000;
            background: #e5e7eb;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            height: 297mm;
            margin: 12px auto;
            padding: 10mm 10mm 8mm;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.18);
            overflow: hidden;
            page-break-after: always;
        }
        .page:last-of-type { page-break-after: auto; }

        .hospital-header { width: 100%; display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .hospital-logo { flex: 1; padding-top: 16px; padding-left: 6px; }
        .logo-text { font-size: 26px; font-weight: 900; letter-spacing: -1.5px; white-space: nowrap; }
        .patient-box { width: 255px; min-height: 110px; border: 1px solid #000; padding: 7px 9px; font-size: 9.5px; line-height: 1.1; }
        .patient-row { display: flex; align-items: flex-start; width: 100%; margin-bottom: 2px; }
        .patient-label { width: 95px; line-height: 1.1; }
        .patient-label i { display: block; font-size: 8.5px; font-weight: normal; }
        .patient-colon { width: 14px; text-align: center; }
        .patient-value { flex: 1; min-height: 9px; }
        .patient-note { margin-top: 8px; text-align: center; font-size: 8.5px; line-height: 1.15; }

        .document-title { width: 100%; text-align: center; margin-bottom: 12px; }
        .doc-title { margin: 0; font-size: 15px; font-weight: bold; line-height: 1.3; }
        .doc-subtitle { margin: 2px 0 0; font-size: 11px; font-weight: bold; font-style: italic; line-height: 1.3; }

        .main-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .col-label { width: 30%; }
        .col-content { width: 60%; }
        .col-signature { width: 10%; }
        .main-table td { border: 1px solid #000; padding: 5px 6px; vertical-align: middle; word-wrap: break-word; }
        .field-title { font-weight: bold; line-height: 1.2; }
        .field-title i { font-weight: normal; line-height: 1.15; }
        .t-center { text-align: center; }
        ol { margin: 2px 0; padding-left: 20px; }
        ol li { padding-left: 2px; margin-bottom: 3px; }
        .cb-row { display: flex; align-items: center; margin: 0; line-height: 1.2; }
        .cb-box { display: inline-flex; align-items: center; justify-content: center; width: 10px; height: 10px; min-width: 10px; border: 1px solid #000; margin-right: 6px; font-size: 9px; line-height: 1; }
        .indent { margin-left: 16px; font-style: italic; }
        .line { display: inline-block; min-width: 90px; max-width: 40%; border-bottom: 1px solid #000; margin-left: 3px; vertical-align: middle; padding: 0 4px; }
        .line-sm { width: 40px; min-width: 40px; max-width: none; }
        .alt-list { margin-top: 6px; padding-left: 22px; }
        .alt-list li { margin-bottom: 4px; }
        .p-note { margin-top: 8px !important; }
        .sig-cell { text-align: center; vertical-align: middle; font-size: 14px; }

        .sig-table-1 { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .sig-info { width: 75%; }
        .sig-doc-col { width: 25%; }
        .sig-table-1 td { border: 1px solid #000; padding: 6px; vertical-align: top; }
        .stmt { line-height: 1.25; text-align: justify; }
        .sig-box { text-align: center; line-height: 1.2; vertical-align: top !important; }
        .sig-space { height: 60px; display: flex; align-items: center; justify-content: center; }
        .sig-img { max-width: 100%; max-height: 60px; object-fit: contain; }
        .sig-date { width: 100%; margin-top: 8px; margin-bottom: 8px; padding-left: 6px; font-size: 12px; line-height: 1.6; }
        .doc-notes { width: 100%; padding: 2px 6px 0; font-size: 10px; line-height: 1.35; }
        .doc-notes > div { margin-bottom: 1px; }

        .cons-header { width: 100%; display: flex; align-items: flex-start; margin-bottom: 8mm; }
        .cons-logo { width: 48mm; flex-shrink: 0; padding-top: 1mm; font-size: 22px; font-weight: 900; letter-spacing: -1.5px; line-height: 1; white-space: nowrap; }
        .cons-title-area { flex: 1; text-align: center; padding-right: 48mm; }
        .cons-title { margin: 0; font-size: 14px; font-weight: bold; line-height: 1.2; }
        .cons-title-en { margin-top: 1px; font-size: 11px; font-weight: bold; font-style: italic; line-height: 1.2; }
        .intro { margin-bottom: 4mm; }
        .intro-title { font-size: 12px; font-weight: bold; margin-bottom: 3mm; }
        .party-section { width: 100%; margin-bottom: 2mm; }
        .party-row { display: flex; align-items: baseline; min-height: 7mm; width: 100%; font-size: 12px; }
        .party-label { width: 40mm; padding-left: 5mm; flex-shrink: 0; }
        .party-colon { width: 4mm; flex-shrink: 0; text-align: center; }
        .party-value { flex: 1; border-bottom: 1px solid #000; min-height: 4mm; padding-bottom: 1px; }
        .party-extra { width: 62mm; margin-left: 4mm; flex-shrink: 0; font-size: 11px; }
        .relationship { margin-top: 3mm; font-size: 12px; line-height: 1.4; }
        .rel-line { display: inline-block; min-width: 55mm; border-bottom: 1px solid #000; vertical-align: bottom; }
        .consent-text { margin-top: 4mm; font-size: 12px; text-align: justify; line-height: 1.4; }
        .fill-line { display: inline-block; min-width: 42mm; border-bottom: 1px solid #000; vertical-align: bottom; text-align: center; padding: 0 4px; font-weight: bold; }
        .pat-info-box { width: 70mm; min-height: 38mm; border: 1px solid #000; margin: 8mm auto 0; padding: 3mm; font-size: 10px; line-height: 1.15; }
        .pi-row { display: flex; margin-bottom: 1.5mm; }
        .pi-label { width: 27mm; flex-shrink: 0; }
        .pi-colon { width: 4mm; flex-shrink: 0; text-align: center; }
        .pi-value { flex: 1; }
        .pat-note { text-align: center; margin-top: 3mm; font-style: italic; font-size: 9px; }

        .stmt-title { margin-top: 2mm; margin-bottom: 4mm; font-size: 12px; font-weight: bold; line-height: 1.25; }
        .check-item { display: flex; align-items: flex-start; margin-bottom: 3.5mm; font-size: 12px; line-height: 1.3; }
        .check-box { width: 4mm; height: 4mm; min-width: 4mm; border: 1px solid #000; margin-right: 2.5mm; margin-top: 0.5mm; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; }
        .check-text { flex: 1; text-align: justify; }
        .check-text i { display: block; margin-top: 0.7mm; font-size: 11px; line-height: 1.25; }
        .date-time { margin-top: 4mm; margin-bottom: 6mm; font-size: 12px; line-height: 1.8; }
        .date-line, .time-line { display: inline-block; border-bottom: 1px solid #000; vertical-align: bottom; min-width: 32mm; padding: 0 4px; }
        .date-line { min-width: 43mm; }
        .sig-table-3 { width: 100%; border-collapse: collapse; table-layout: fixed; margin-top: 4mm; }
        .sig-table-3 td { width: 33.333%; border: 0; text-align: center; vertical-align: top; padding: 0 3mm; }
        .sig-role { font-size: 12px; font-weight: bold; line-height: 1.2; min-height: 12mm; }
        .sig-space-3 { height: 22mm; display: flex; align-items: center; justify-content: center; }
        .sig-line-3 { width: 45mm; max-width: 100%; margin: 0 auto 1.5mm; border-bottom: 1px solid #000; }
        .sig-name { font-size: 12px; font-weight: bold; line-height: 1.2; }
        .sig-name-en { font-size: 10px; font-style: italic; line-height: 1.2; }
        .footer-note { margin-top: 6mm; font-size: 10px; line-height: 1.35; }
        .footer-note div { margin-bottom: 1mm; }

        .print-btn, .back-btn {
            position: fixed; z-index: 9999; border-radius: 8px; padding: 10px 18px; font-size: 14px; font-weight: bold; cursor: pointer;
        }
        .print-btn { top: 16px; right: 16px; background: #2563eb; color: #fff; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.22); }
        .print-btn:hover { background: #1d4ed8; }
        .back-btn { top: 16px; left: 16px; background: #fff; color: #374151; border: 1px solid #d1d5db; text-decoration: none; box-shadow: 0 1px 4px rgba(0,0,0,0.10); }
        .back-btn:hover { background: #f9fafb; }

        @media print {
            @page { size: A4 portrait; margin: 0; }
            html, body { width: 210mm; margin: 0; padding: 0; background: #fff !important; }
            .print-btn, .back-btn { display: none !important; }
            .page {
                width: 210mm;
                height: 297mm;
                min-height: 297mm;
                margin: 0 !important;
                padding: 10mm 10mm 8mm;
                background: #fff !important;
                box-shadow: none !important;
                overflow: hidden;
                page-break-after: always;
                break-after: page;
            }
            .page:last-of-type { page-break-after: auto; break-after: auto; }
        }
    </style>
</head>
<body>
@php
    $initials    = $persetujuan->diagnosis_initial ?? [];
    $altChoices  = $persetujuan->alternative_treatment_choices ?? [];
    $riskChoices = $persetujuan->risk_if_not_treated_choices ?? [];
    $signatures  = $persetujuan->signature ?? [];
    $sigDokter     = $signatures[0] ?? null;
    $sigPenerima   = $signatures[1] ?? null;
    $sigMenyatakan = $signatures[2] ?? null;
    $sigSaksi1     = $signatures[3] ?? null;
    $sigSaksi2     = $signatures[4] ?? null;
    $idx = 0;
    $mark = fn ($i) => !empty($initials[$i]) ? '✓' : '';
    $patientGender = match ($patient->gender ?? '') {
        'L' => 'L',
        'P' => 'P',
        default => '(L/P)*',
    };
    $relLabels = [
        'pasien' => 'PASIEN',
        'suami' => 'SUAMI',
        'istri' => 'ISTRI',
        'ayah' => 'AYAH',
        'ibu' => 'IBU',
        'anak' => 'ANAK',
        'lainnya' => $persetujuan->other_relationship ?? '',
    ];
    $relDisplay = $relLabels[$persetujuan->relationship ?? ''] ?? ($persetujuan->relationship ?? '');
    $waliHubLabels = [
        'diri_sendiri' => 'DIRI SENDIRI',
        'pasien' => 'DIRI SENDIRI',
        'suami' => 'SUAMI',
        'istri' => 'ISTRI',
        'ayah' => 'AYAH',
        'ibu' => 'IBU',
        'anak' => 'ANAK',
        'lainnya' => $persetujuan->wali_hubungan_lainnya ?? '',
    ];
    $waliHub = $waliHubLabels[$persetujuan->wali_hubungan ?? ''] ?? ($persetujuan->wali_hubungan ?? '');
    $tanggal = $persetujuan->tanggal_persetujuan?->format('d/m/Y') ?? '';
    $jam = $persetujuan->jam_persetujuan ?? '';
    $umurPasien = $patient?->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->age . ' tahun' : '';
@endphp

<a href="{{ route('persetujuan-tindakan.index') }}" class="back-btn">&larr; Kembali</a>
<button class="print-btn" onclick="window.print()">Cetak / Print PDF</button>

{{-- ========================= HALAMAN 1: INFORMASI (test.html) ========================= --}}
<div class="page">
    <div class="hospital-header">
        <div class="hospital-logo"><div class="logo-text">RS AWAL BROS</div></div>
        <div class="patient-box">
            <div class="patient-row"><span class="patient-label">Nama Lengkap<i>Full Name</i></span><span class="patient-colon">:</span><span class="patient-value">{{ $patient->name ?? '' }}</span></div>
            <div class="patient-row"><span class="patient-label">Jenis Kelamin<i>Sex</i></span><span class="patient-colon">:</span><span class="patient-value">{{ $patientGender }}</span></div>
            <div class="patient-row"><span class="patient-label">Tanggal Lahir<i>Date of Birth</i></span><span class="patient-colon">:</span><span class="patient-value">{{ $patient->date_of_birth?->format('d/m/Y') ?? '' }}</span></div>
            <div class="patient-row"><span class="patient-label">No. Rekam Medis<i>Medical Record Number</i></span><span class="patient-colon">:</span><span class="patient-value">{{ $patient->medical_record_number ?? '' }}</span></div>
            <div class="patient-note"><i>(mohon diisi atau tempelkan stiker pasien)<br>(Please fill in or attach the patient sticker)</i></div>
        </div>
    </div>

    <div class="document-title">
        <div class="doc-title">INFORMASI TINDAKAN ATAU PENGOBATAN MEDIS<br>MRI KEPALA/LEHER/SINUS</div>
        <div class="doc-subtitle">INFORMATION REGARDING MEDICAL PROCEDURE OR TREATMENT<br>OF BRAIN/NECK/SINUSES</div>
    </div>

    <table class="main-table">
        <colgroup><col class="col-label"><col class="col-content"><col class="col-signature"></colgroup>
        <tbody>
            <tr>
                <td><div class="field-title">NAMA DOKTER PEMBERI INFORMASI<br><i>Name of Informing Doctor</i></div></td>
                <td colspan="2">{{ $doctorName }}</td>
            </tr>
            <tr>
                <td><div class="field-title">NAMA PENERIMA INFORMASI<br><i>Name of Recipient of Information</i></div></td>
                <td colspan="2">{{ $persetujuan->recipient_name ?? '' }}</td>
            </tr>
            <tr>
                <td><div class="field-title">HUBUNGAN DENGAN PASIEN<br><i>Relationship to Patient</i></div></td>
                <td colspan="2">
                    <b>*(PASIEN/SUAMI/ISTRI/AYAH/IBU/ANAK/_________________)</b><br>
                    <i>*(Patient/Husband/Wife/Father/Mother/Child/_______________)</i>
                    @if($relDisplay)<br><strong>&rarr; {{ $relDisplay }}</strong>@endif
                </td>
            </tr>
            <tr>
                <td colspan="2" class="t-center"><b>PENJELASAN YANG DISAMPAIKAN</b><br><i>Explanation Provided</i></td>
                <td class="t-center"><b>PARAF PENERIMA INFORMASI</b><br><i>Recipient's Initials</i></td>
            </tr>
            <tr>
                <td><div class="field-title">DIAGNOSIS<br>(DIAGNOSA KERJA DAN DIAGNOSA BANDING)<br><i>Diagnosis (Primary Diagnosis and Differential Diagnosis)</i></div></td>
                <td>{{ $persetujuan->diagnosis ?? '' }}</td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">KONDISI PASIEN SAAT INI<br><i>Current Condition of the Patient</i></div></td>
                <td>{{ $persetujuan->planned_procedure ?? '' }}</td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">NAMA TINDAKAN (PROSEDUR) ATAU PENGOBATAN MEDIS<br><i>Name of Procedure or Medical Treatment</i></div></td>
                <td><b>MRI Kepala/Leher/Sinus tanpa Kontras, adalah pemeriksaan radiologi dengan modalitas MRI pada organ Kepala/Leher/Sinus tanpa menggunakan zat kontras intravena.</b></td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">TUJUAN DAN MANFAAT TINDAKAN<br><i>Purpose and Benefits of the Procedure</i></div></td>
                <td>
                    <ol type="a">
                        <li>Mengetahui struktur anatomi objek yang diperiksa.</li>
                        <li>Mengetahui dugaan adanya massa, infeksi, sumbatan, keganasan, dan kelainan anatomis maupun fisiologis lainnya.</li>
                    </ol>
                </td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">TATA CARA TINDAKAN/PROSEDUR<br><i>Procedure Method</i></div></td>
                <td>
                    <ol type="a">
                        <li>Pasien berganti baju dengan baju pemeriksaan yang telah dipersiapkan.</li>
                        <li>Pasien melepas semua atribut yang berpotensi mengganggu pemeriksaan.</li>
                        <li>Petugas melakukan MRI polos.</li>
                        <li>Pasien berganti baju.</li>
                        <li>Pemeriksaan selesai, pasien diberikan hasil gambar dalam bentuk CD atau dikirim melalui Whatsapp/Email.</li>
                    </ol>
                </td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- ========================= HALAMAN 2: INFORMASI (lanjutan test.html) ========================= --}}
<div class="page">
    <table class="main-table">
        <colgroup><col class="col-label"><col class="col-content"><col class="col-signature"></colgroup>
        <tbody>
            <tr>
                <td><div class="field-title">RISIKO DAN KOMPLIKASI TINDAKAN ATAU PENGOBATAN MEDIS<br><i>Risks and Complications of the Procedure or Medical Treatment</i></div></td>
                <td>Tidak Ada</td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">ALTERNATIF TINDAKAN/PENGOBATAN LAIN<br><i>Alternative Procedure/Other Treatment</i></div></td>
                <td>
                    <div class="cb-row"><span class="cb-box">{{ $persetujuan->alternative_treatment == 'none' ? '✓' : '' }}</span><span>Tidak ada</span></div>
                    <div class="indent">None</div>
                    <div class="cb-row" style="margin-top:4px">
                        <span class="cb-box">{{ $persetujuan->alternative_treatment == 'yes' ? '✓' : '' }}</span>
                        <span>Ada, yaitu</span>
                        <span class="line">{{ $persetujuan->alternative_treatment_detail ?? '' }}</span>
                    </div>
                    <div class="indent">Yes, namely <span class="line"></span></div>
                    <ol type="a" class="alt-list">
                        <li><i>Rontgen</i> polos, dengan konsekuensi ketidakjelasan struktur anatomi.@if(in_array('rontgen_polos', $altChoices)) <b>✓</b>@endif</li>
                        <li><i>CT Scan</i> objek yang diperiksa tanpa dan dengan zat kontras, dengan konsekuensi pengurangan visualisasi objek yang diperiksa.@if(in_array('ct_scan_tanpa_dan_dengan_kontras', $altChoices)) <b>✓</b>@endif</li>
                    </ol>
                    <p class="p-note">Pemilihan alternatif tindakan harap dikonsultasikan kembali dengan dokter yang merujuk.</p>
                </td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">PROGNOSIS<br><i>Prognosis</i></div></td>
                <td>Tingkat keberhasilan pemeriksaan ini tinggi, kecuali ada penyulit.</td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">KEMUNGKINAN MASALAH TERKAIT DENGAN PROSES PEMULIHAN<br><i>Potential Issues Related to Recovery Process</i></div></td>
                <td>Tidak ada</td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">KEMUNGKINAN RISIKO BILA TINDAKAN / PENGOBATAN TIDAK DILAKUKAN<br><i>Potential Risks if the Procedure/Treatment is Not Performed</i></div></td>
                <td>
                    <div class="cb-row"><span class="cb-box">{{ $persetujuan->risk_if_not_treated_option == 'none' ? '✓' : '' }}</span><span>Tidak ada</span></div>
                    <div class="indent">None</div>
                    <div class="cb-row" style="margin-top:4px">
                        <span class="cb-box">{{ $persetujuan->risk_if_not_treated_option == 'yes' ? '✓' : '' }}</span>
                        <span>Ada, yaitu</span>
                        <span class="line">{{ $persetujuan->risk_if_not_treated_detail ?? '' }}</span>
                    </div>
                    <div class="indent">Yes, namely <span class="line"></span></div>
                    <ol type="a" style="margin-top:4px">
                        <li>Upaya penegakan diagnosis tidak efektif.@if(in_array('upaya_diagnosis_tidak_efektif', $riskChoices)) <b>✓</b>@endif</li>
                        <li>Tindakan/terapi selanjutnya dimungkinkan akan tidak efektif dan atau terlambat.@if(in_array('terapi_lanjutan_tidak_efektif_atau_terlambat', $riskChoices)) <b>✓</b>@endif</li>
                    </ol>
                </td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">PERKIRAAN LAMA RAWAT<br><i>Estimated Length of Hospitalization</i></div></td>
                <td>
                    <div class="cb-row"><span class="cb-box">{{ $persetujuan->hospitalization_option == 'not_hospitalized' ? '✓' : '' }}</span><span>Tidak dirawat inap</span></div>
                    <div class="indent">Not hospitalized</div>
                    <div class="cb-row" style="margin-top:4px">
                        <span class="cb-box">{{ $persetujuan->hospitalization_option == 'hospitalized' ? '✓' : '' }}</span>
                        <span>Rawat inap:</span>
                        <span class="line line-sm">{{ $persetujuan->hospitalization_days ?? '' }}</span>
                        <span>&nbsp;hari</span>
                    </div>
                    <div class="indent">Hospitalized: <span class="line line-sm">{{ $persetujuan->hospitalization_days ?? '' }}</span>&nbsp;days</div>
                </td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
            <tr>
                <td><div class="field-title">PEMBIAYAAN<br><i>Cost</i></div></td>
                <td>Sesuai dengan obat dan alat yang digunakan serta jasa Petugas/Dokter.<br><i>According to the medication, equipment used, and the services of the staff/doctor.</i></td>
                <td class="sig-cell">{{ $mark($idx++) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="sig-date">
        <div>Pekanbaru, {{ $tanggal ?: '______________________________' }}</div>
        <div>Jam&nbsp;&nbsp;&nbsp;&nbsp;: {{ $jam ?: '______________________________' }} WIB</div>
    </div>

    <table class="sig-table-1">
        <colgroup><col class="sig-info"><col class="sig-doc-col"></colgroup>
        <tr>
            <td>
                <div class="stmt">
                    <b>Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jujur dan memberikan kesempatan untuk bertanya dan/atau berdiskusi.</b><br>
                    <i>I hereby state that I have explained the above matters accurately and honestly and have provided the opportunity for questions and/or discussion.</i>
                </div>
            </td>
            <td class="sig-box">
                <b>Tanda Tangan Dokter</b><br><i>Doctor's Signature</i>
                <div class="sig-space">@if($sigDokter)<img src="{{ $sigDokter }}" class="sig-img" alt="TTD Dokter">@endif</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="stmt">
                    <b>Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya beri tanda/paraf di kolom kanannya, dan telah memahaminya.</b><br>
                    <i>I hereby state that I have received the above information, which I have marked/initialed in the respective column, and I have understood it.</i>
                </div>
            </td>
            <td class="sig-box">
                <b>Tanda Tangan<br>Penerima Informasi</b><br><i>Recipient's Signature:</i>
                <div class="sig-space">@if($sigPenerima)<img src="{{ $sigPenerima }}" class="sig-img" alt="TTD Penerima">@endif</div>
            </td>
        </tr>
    </table>

    <div class="doc-notes">
        <div><b>*)</b> Coret yang tidak perlu/ <i>Cross out what is not necessary</i></div>
        <div>□ Beri tanda (✓) pada kolom yang sesuai/ <i>Check (✓) the appropriate column</i></div>
    </div>
</div>

{{-- ========================= HALAMAN 3: PERSETUJUAN (test_1.html) ========================= --}}
<div class="page">
    <div class="cons-header">
        <div class="cons-logo">RS AWAL BROS</div>
        <div class="cons-title-area">
            <div class="cons-title">PERSETUJUAN TINDAKAN ATAU PENGOBATAN MEDIS</div>
            <div class="cons-title-en">CONSENT FOR MEDICAL PROCEDURE OR TREATMENT</div>
        </div>
    </div>

    <div class="intro">
        <div class="intro-title">Yang bertanda tangan di bawah ini:<br><i>The undersigned below:</i></div>
        <div class="party-section">
            <div class="party-row">
                <div class="party-label">Nama<br><i>Name</i></div>
                <div class="party-colon">:</div>
                <div class="party-value">{{ $persetujuan->wali_nama ?? '' }}</div>
            </div>
            <div class="party-row">
                <div class="party-label">Umur<br><i>Age</i></div>
                <div class="party-colon">:</div>
                <div class="party-value">{{ $persetujuan->wali_umur ?? '' }}</div>
                <div class="party-extra">
                    tahun &nbsp;&nbsp;&nbsp; Jenis Kelamin :
                    @if($persetujuan->wali_jk == 'L') Laki-laki
                    @elseif($persetujuan->wali_jk == 'P') Perempuan
                    @else Laki-laki/Perempuan*)
                    @endif
                    <br><i>Gender: Male/Female*)</i>
                </div>
            </div>
            <div class="party-row">
                <div class="party-label">Alamat<br><i>Address</i></div>
                <div class="party-colon">:</div>
                <div class="party-value">{{ $persetujuan->wali_alamat ?? '' }}</div>
            </div>
            <div class="party-row">
                <div class="party-label">No. Kartu Identitas<br><i>ID Card Number</i></div>
                <div class="party-colon">:</div>
                <div class="party-value">{{ $persetujuan->wali_identitas ?? '' }}</div>
                <div class="party-extra">{{ $persetujuan->wali_jenis_identitas ?: 'KTP/SIM/Paspor*)' }}</div>
            </div>
        </div>

        <div class="relationship">
            Hubungan dengan pasien*): Dari sendiri/suami/istri/ayah/ibu/anak/
            <span class="rel-line">{{ $waliHub }}</span>
            <br>
            <i>Relationship to the patient: Self/Husband/Wife/Father/Mother/Child/</i>
        </div>

        <div class="consent-text">
            Dengan ini menyatakan
            <span class="fill-line">{{ $persetujuan->pernyataan_tindakan ?? '' }}</span>
            untuk dilakukan tindakan atau pengobatan medis tersebut terhadap pasien:
            <span class="fill-line">{{ $patient->name ?? '' }}</span>
            <br>
            <i>
                Hereby state the consent for
                <span class="fill-line">{{ $persetujuan->pernyataan_tindakan ?? '' }}</span>
                to perform the procedure or medical treatment on the patient:
            </i>
        </div>

        <div class="pat-info-box">
            <div class="pi-row"><div class="pi-label">Nama Lengkap</div><div class="pi-colon">:</div><div class="pi-value">{{ $patient->name ?? '' }}</div></div>
            <div class="pi-row"><div class="pi-label">Jenis Kelamin</div><div class="pi-colon">:</div><div class="pi-value">{{ $patientGender }}</div></div>
            <div class="pi-row"><div class="pi-label">Tanggal Lahir</div><div class="pi-colon">:</div><div class="pi-value">{{ $patient->date_of_birth?->format('d/m/Y') ?? '' }}</div></div>
            <div class="pi-row"><div class="pi-label">Umur</div><div class="pi-colon">:</div><div class="pi-value">{{ $umurPasien }}</div></div>
            <div class="pi-row"><div class="pi-label">No. Rekam Medis</div><div class="pi-colon">:</div><div class="pi-value">{{ $patient->medical_record_number ?? '' }}</div></div>
            <div class="pat-note">(mohon diisi atau tempelkan stiker pasien)<br>(Please fill in or attach the patient sticker)</div>
        </div>
    </div>
</div>

{{-- ========================= HALAMAN 4: PERSETUJUAN (lanjutan test_1.html) ========================= --}}
<div class="page">
    <div class="stmt-title">
        Dengan ini menyatakan:<br>
        <i>Hereby declare:</i>
    </div>

    <div class="check-item">
        <span class="check-box">{{ $persetujuan->check_received_info ? '✓' : '' }}</span>
        <div class="check-text">
            Saya mengetahui telah menerima informasi penjelasan mengenai tindakan yang akan dilakukan.
            <i>I acknowledge that I have received explanation regarding the procedure to be performed.</i>
        </div>
    </div>
    <div class="check-item">
        <span class="check-box">{{ $persetujuan->check_understand_necessity ? '✓' : '' }}</span>
        <div class="check-text">
            Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti sebelumnya kepada saya, termasuk risiko dan komplikasi yang mungkin timbul dari tindakan dilakukan atau tidak dilakukan.
            <i>I understand the necessity and benefits of the procedure as explained previously, including the possible risks and complications if the procedure is performed or not performed.</i>
        </div>
    </div>
    <div class="check-item">
        <span class="check-box">{{ $persetujuan->check_given_opportunity ? '✓' : '' }}</span>
        <div class="check-text">
            Saya mengetahui bahwa saya telah diberikan kesempatan untuk bertanya informasi lebih banyak tentang prosedur ini.
            <i>I acknowledge that I have been given the opportunity to ask for more information about this procedure.</i>
        </div>
    </div>
    <div class="check-item">
        <span class="check-box">{{ $persetujuan->check_realize_no_guarantee ? '✓' : '' }}</span>
        <div class="check-text">
            Saya juga menyadari tidak ada jaminan yang diberikan bahwa Dokter ataupun petugas yang melakukan tindakan dengan hasil yang sesuai dengan yang diharapkan.
            <i>I also realize that no guarantee has been given that the doctor or staff performing the procedure will achieve the expected result.</i>
        </div>
    </div>
    <div class="check-item">
        <span class="check-box">{{ $persetujuan->check_realize_not_exact_science ? '✓' : '' }}</span>
        <div class="check-text">
            Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan bukanlah sesuatu yang pasti.
            <i>I also realize that because medical science is not an exact science, the success of medical procedures is not guaranteed and highly dependent on the will of Almighty God.</i>
        </div>
    </div>

    <div class="date-time">
        <div>Pekanbaru, <span class="date-line">{{ $tanggal }}</span></div>
        <div>Jam : <span class="time-line">{{ $jam }}</span> WIB</div>
    </div>

    <table class="sig-table-3">
        <tr>
            <td>
                <div class="sig-role">Yang Menyatakan,<br><i>Declarant</i></div>
                <div class="sig-space-3">@if($sigMenyatakan)<img src="{{ $sigMenyatakan }}" style="max-width:100%;max-height:20mm;object-fit:contain;" alt="TTD">@endif</div>
                <div class="sig-line-3"></div>
                <div class="sig-name">{{ $persetujuan->yang_menyatakan_nama ?: 'Nama Lengkap dan Tanda Tangan' }}</div>
                <div class="sig-name-en">Full Name and Signature</div>
            </td>
            <td>
                <div class="sig-role">Saksi I,<br><i>Witness I</i></div>
                <div class="sig-space-3">@if($sigSaksi1)<img src="{{ $sigSaksi1 }}" style="max-width:100%;max-height:20mm;object-fit:contain;" alt="TTD Saksi I">@endif</div>
                <div class="sig-line-3"></div>
                <div class="sig-name">{{ $persetujuan->saksi_1_nama ?: 'Nama Lengkap dan Tanda Tangan' }}</div>
                <div class="sig-name-en">Full Name and Signature</div>
            </td>
            <td>
                <div class="sig-role">Saksi II,<br><i>Witness II</i></div>
                <div class="sig-space-3">@if($sigSaksi2)<img src="{{ $sigSaksi2 }}" style="max-width:100%;max-height:20mm;object-fit:contain;" alt="TTD Saksi II">@endif</div>
                <div class="sig-line-3"></div>
                <div class="sig-name">{{ $persetujuan->saksi_2_nama ?: 'Nama Lengkap dan Tanda Tangan' }}</div>
                <div class="sig-name-en">Full Name and Signature</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        <div>*) Coret yang tidak perlu/ <i>Cross out what is not necessary</i></div>
        <div>□ Beri tanda (✓) pada kolom yang sesuai/ <i>Check (✓) the appropriate column</i></div>
    </div>
</div>
</body>
</html>
