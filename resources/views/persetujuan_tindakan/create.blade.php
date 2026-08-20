@extends('layouts.app')

@section('title', 'Persetujuan Medis')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker@v2.0.0/dist/mdtimepicker.css">
@endsection

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">

        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between no-print">
            <div>
                <a href="{{ route('dashboard') }}"
                    class="mb-1 flex items-center text-xs font-semibold text-slate-500 transition hover:text-slate-900">
                    &larr; Kembali ke Dashboard
                </a>

                <h1 class="text-xl font-bold text-slate-900">
                    Isi Form Persetujuan Medis
                </h1>
            </div>

            <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-2 text-right">
                <span class="block text-xs text-blue-600">
                    Nama Pasien
                </span>

                <span class="text-sm font-bold text-blue-900">
                    <span id="header_patient_name">{{ $patient->name ?? 'N/A' }}</span>
                    (RM: <span id="header_patient_rm">{{ $patient->medical_record_number ?? 'N/A' }}</span>)
                </span>
            </div>
        </div>

        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800 shadow-sm">
                <div class="mb-1 text-sm font-bold">
                    Gagal menyimpan! Harap periksa inputan berikut:
                </div>

                <ul class="list-disc space-y-0.5 pl-5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('persetujuan-tindakan.store') }}">
            @csrf

            <div class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm">

                {{-- ================= HEADER DOKUMEN ================= --}}
                <div class="border-b border-gray-300 px-4 py-4 text-center">
                    <h2 class="text-md font-bold text-slate-900">
                        INFORMASI TINDAKAN ATAU PENGOBATAN MEDIS
                    </h2>

                    <h3 class="text-md font-bold text-slate-900">
                        MRI KEPALA / LEHER / SINUS
                    </h3>

                    <div class="mt-1 text-md font-bold text-slate-900">
                        <i>
                            INFORMATION REGARDING MEDICAL PROCEDURE OR TREATMENT
                            <br>
                            OF BRAIN / NECK / SINUSES
                        </i>
                    </div>
                </div>

                {{-- ================= TABLE ================= --}}
                <table class="w-full border-collapse border border-gray-300">
                    <tbody>

                        {{-- ===================================================== --}}
                        {{-- PASIEN --}}
                        {{-- ===================================================== --}}
                        <tr>
                            <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                <div class="font-bold text-slate-900">
                                    PILIH PASIEN
                                </div>
                                <div class="text-sm italic text-gray-600">
                                    Select Patient
                                </div>
                            </td>
                            <td class="w-2/3 border border-gray-300 px-4 py-3 align-middle" colspan="2">
                                <select id="patient_id" name="patient_id" required
                                    class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm
                                    focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach ($patients as $p)
                                        <option value="{{ $p->id }}" data-name="{{ $p->name }}"
                                            data-rm="{{ $p->medical_record_number }}" data-dob="{{ $p->date_of_birth?->format('d/m/Y') }}"
                                            data-jk="{{ $p->gender }}"
                                            {{ isset($patient) && $patient->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} (RM: {{ $p->medical_record_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        {{-- ===================================================== --}}
                        {{-- DOKTER PEMBERI INFORMASI --}}
                        {{-- ===================================================== --}}
                        <tr>
                            <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                <div class="font-bold text-slate-900">
                                    NAMA DOKTER PEMBERI INFORMASI
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Name of Informing Doctor
                                </div>
                            </td>

                            <td class="w-2/3 border border-gray-300 px-4 py-3 align-middle" colspan="2">

                                <select id="doctor" name="doctor"
                                    class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm
                                    focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                    <option value="">
                                        Pilih Dokter
                                    </option>

                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" data-signature="{{ $doctor->signature }}" @selected(old('doctor') == $doctor->id)>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach

                                </select>

                            </td>
                        </tr>


                        {{-- ===================================================== --}}
                        {{-- NAMA PENERIMA INFORMASI --}}
                        {{-- ===================================================== --}}
                        <tr>
                            <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                <div class="font-bold text-slate-900">
                                    NAMA PENERIMA INFORMASI
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Name of Information Recipient
                                </div>
                            </td>

                            <td class="w-2/3 border border-gray-300 px-4 py-3 align-middle" colspan="2">

                                <input type="text" name="recipient_name" value="{{ old('recipient_name') }}"
                                    placeholder="Masukkan nama penerima informasi"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                    focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            </td>
                        </tr>


                        {{-- ===================================================== --}}
                        {{-- HUBUNGAN DENGAN PASIEN --}}
                        {{-- ===================================================== --}}
                        <tr>
                            <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">

                                <div class="font-bold text-slate-900">
                                    HUBUNGAN DENGAN PASIEN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Relationship to Patient
                                </div>

                            </td>

                            <td class="w-2/3 border border-gray-300 px-4 py-3 align-middle" colspan="2">

                                <select id="relationship" name="relationship"
                                    class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm
                                    focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                    <option value="">
                                        Pilih Hubungan
                                    </option>

                                    <option value="pasien" @selected(old('relationship') === 'pasien')}>
                                        Pasien / Patient
                                    </option>

                                    <option value="suami" @selected(old('relationship') === 'suami')}>
                                        Suami / Husband
                                    </option>

                                    <option value="istri" @selected(old('relationship') === 'istri')}>
                                        Istri / Wife
                                    </option>

                                    <option value="ayah" @selected(old('relationship') === 'ayah')}>
                                        Ayah / Father
                                    </option>

                                    <option value="ibu" @selected(old('relationship') === 'ibu')}>
                                        Ibu / Mother
                                    </option>

                                    <option value="lainnya" @selected(old('relationship') === 'lainnya')}>
                                        Lainnya / Other
                                    </option>

                                </select>


                                {{-- Input hubungan lainnya --}}
                                <div id="otherRelationship"
                                    class="{{ old('relationship') === 'lainnya' ? '' : 'hidden' }} mt-3">

                                    <label for="other_relationship" class="mb-1 block text-sm font-medium text-gray-700">

                                        Hubungan dengan Pasien /
                                        <span class="italic">
                                            Relationship with Patient
                                        </span>

                                    </label>

                                    <input type="text" id="other_relationship" name="other_relationship"
                                        value="{{ old('other_relationship') }}"
                                        placeholder="Tuliskan hubungan dengan pasien..."
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                </div>

                            </td>
                        </tr>


                        {{-- ===================================================== --}}
                        {{-- HEADER PENJELASAN --}}
                        {{-- 3 KOLOM --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="w-1/2 border border-gray-300 bg-gray-50 px-4 py-3 text-center align-middle">

                                <div class="font-bold text-slate-900">
                                    PENJELASAN YANG DISAMPAIKAN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Explanation Provided
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="w-1/4 border border-gray-300 bg-gray-50 px-4 py-3 text-center align-middle">

                                <div class="font-bold text-slate-900">
                                    ISI PENJELASAN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Explanation
                                </div>

                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="w-1/4 border border-gray-300 bg-gray-50 px-4 py-3 text-center align-middle">

                                <div class="font-bold text-slate-900">
                                    PARAF PENERIMA INFORMASI
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Recipient's Initials
                                </div>

                            </td>

                        </tr>


                        {{-- ===================================================== --}}
                        {{-- DIAGNOSIS --}}
                        {{-- 3 KOLOM --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    DIAGNOSIS
                                </div>

                                <div class="font-bold text-slate-900">
                                    (DIAGNOSA KERJA DAN
                                    DIAGNOSA BANDING)
                                </div>

                                <div class="mt-1 text-sm italic text-gray-600">
                                    Diagnosis
                                    <br>
                                    (Primary Diagnosis and
                                    Differential Diagnosis)
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                <textarea name="diagnosis" rows="4" placeholder="Tuliskan diagnosis kerja dan diagnosis banding..."
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                    focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('diagnosis') }}</textarea>

                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                <div class="flex min-h-[80px] items-center justify-center">


                                    {{-- input checkbox untuk paraf penerima informasi --}}
                                    <input type="checkbox" name="diagnosis_initial" value="1"
                                        class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                                </div>

                            </td>

                        </tr>


                        {{-- ===================================================== --}}
                        {{-- KONDISI PASIEN SAAT INI --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    KONDISI PASIEN SAAT INI
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Current Patient Condition
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                <textarea name="planned_procedure" rows="4" placeholder="Tuliskan kondisi pasien saat ini..."
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                    focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('planned_procedure') }}</textarea>

                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>


                        {{-- ===================================================== --}}
                        {{-- NAMA TINDAKAN (PROSEDUR) ATAU  PENGOBATAN MEDIS --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    NAMA TINDAKAN
                                    (PROSEDUR) ATAU
                                    PENGOBATAN MEDIS
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Name of Procedure or Medical Treatment
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                <p><b>MRI Kepala/Leher/Sinus tanpa Kontras, adalah
                                        pemeriksaan radiologi dengan modalitas MRI pada organ
                                        Kepala/Leher/Sinus tanpa menggunakan zat kontras
                                        intravena. </b></p>

                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>




                        {{-- ===================================================== --}}
                        {{-- TUJUAN DAN MANFAAT TINDAKAN --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    TUJUAN DAN MANFAAT TINDAKAN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Purpose and Benefits of the Procedure
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                <ol class="list-[lower-alpha] list-outside pl-6">
                                    <li>Mengetahui struktur anatomi objek yang diperiksa.</li>
                                    <li>
                                        Mengetahui dugaan adanya massa, infeksi, sumbatan,
                                        keganasan, dan kelainan anatomis maupun fisiologis lainnya.
                                    </li>
                                </ol>



                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>




                        {{-- ===================================================== --}}
                        {{-- TATA CARA TINDAKAN/ PROSEDUR  --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    TATA CARA TINDAKAN/PROSEDUR
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Procedure Method
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                <ol class="list-[lower-alpha] list-outside pl-6">
                                    <li>Pasien berganti baju dengan baju pemeriksaan yang telah dipersiapkan.</li>
                                    <li>
                                        Pasien melepas semua atribut yang berpotensi
                                        mengganggu pemeriksaan.
                                    </li>
                                    <li>
                                        Petugas melakukan MRI polos.
                                    </li>
                                    <li>
                                        Pasien berganti baju.
                                    </li>
                                    <li>
                                        Pemeriksaan selesai, pasien diberikan hasil gambar dalam
                                        bentuk CD atau dikirim melalui <i>Whatsapp/Email</i>.
                                    </li>
                                </ol>



                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>





                        {{-- ===================================================== --}}
                        {{--  RISIKO DAN KOMPLIKASI
                                    TINDAKAN ATAU
                                    PENGOBATAN MEDIS  --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    RISIKO DAN KOMPLIKASI
                                    TINDAKAN ATAU
                                    PENGOBATAN MEDIS
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Risks and Complications of the
                                    Procedure or Medical Treatment
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">
                                Tidak ada
                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>



                        {{-- ===================================================== --}}
                        {{--  ALTERNATIF TINDAKAN/PENGOBATAN LAIN  --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    ALTERNATIF TINDAKAN/
                                    PENGOBATAN LAIN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Risks and Complications of the
                                    Procedure or Medical Treatment
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                {{-- TIDAK ADA --}}
                                <label class="flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="none"
                                        {{ old('alternative_treatment') == 'none' ? 'checked' : '' }}
                                        class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500" />

                                    <div class=leading-[1.25]">
                                        <div>Tidak ada</div>
                                        <div class="italic">None</div>
                                    </div>

                                </label>


                                {{-- ADA --}}
                                <label class="mt-4 flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="yes"
                                        {{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}
                                        class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500"
                                        onclick="toggleAlternativeInput(true)" />

                                    <div class="flex-1 leading-[1.25]">

                                        <div class="flex items-center gap-1">
                                            <span>Ada, yaitu</span>

                                            <input type="text" name="alternative_treatment_detail"
                                                id="alternative_treatment_detail"
                                                value="{{ old('alternative_treatment_detail') }}" maxlength="255"
                                                class="w-full max-w-[300px] border-0 border-b border-black
                               bg-transparent px-1 py-0
                               focus:border-blue-500 focus:outline-none focus:ring-0"
                                                placeholder="" />
                                        </div>

                                        <div class="italic">
                                            Yes, namely
                                        </div>

                                    </div>

                                </label>


                                {{-- PILIHAN ALTERNATIF --}}
                                <div class="mt-5 ml-[38px] leading-[1.4]">

                                    {{-- A --}}
                                    <div class="flex">

                                        <div class="w-7 shrink-0">
                                            a.
                                        </div>

                                        <div>
                                            <span class="italic">Rontgen</span>
                                            polos, dengan konsekuensi ketidakjelasan
                                            <br />
                                            struktur anatomi.
                                        </div>

                                    </div>


                                    {{-- B --}}
                                    <div class="mt-2 flex">

                                        <div class="w-7 shrink-0">
                                            b.
                                        </div>

                                        <div>
                                            CT <span class="italic">Scan</span>
                                            objek yang diperiksa tanpa dan dengan zat
                                            <br />
                                            kontras, dengan konsekuensi pengurangan visualisasi
                                            <br />
                                            objek yang diperiksa.
                                        </div>

                                    </div>

                                </div>


                                {{-- CATATAN --}}
                                <div class="mt-4 leading-[1.45]">

                                    Pemilihan alternatif tindakan harap dikonsultasikan kembali
                                    <br />

                                    dengan dokter yang merujuk.

                                </div>

                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- PARAF PENERIMA INFORMASI --}}
                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>




                        {{-- ===================================================== --}}
                        {{--  PROGNOSIS  --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    PROGNOSIS
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Prognosis
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">
                                Tingkat keberhasilan pemeriksaan ini tinggi, kecuali ada
                                penyulit.
                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>




                        {{-- ===================================================== --}}
                        {{--  KEMUNGKINAN MASALAH  TERKAIT DENGAN PROSES PEMULIHAN  --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    KEMUNGKINAN MASALAH TERKAIT DENGAN PROSES PEMULIHAN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Potential Issues Related to
                                    Recovery Process
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">
                                Tidak ada
                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>




                        {{-- ===================================================== --}}
                        {{--  KEMUNGKINAN RISIKO 
                        BILA TINDAKAN / 
                        PENGOBATAN TIDAK 
                        DILAKUKAN --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    ALTERNATIF TINDAKAN/
                                    PENGOBATAN LAIN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Potential Risks if the Procedure/
                                    Treatment is Not Performed
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                {{-- TIDAK ADA --}}
                                <label class="flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="none"
                                        {{ old('alternative_treatment') == 'none' ? 'checked' : '' }}
                                        class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500" />

                                    <div class=leading-[1.25]">
                                        <div>Tidak ada</div>
                                        <div class="italic">None</div>
                                    </div>

                                </label>


                                {{-- ADA --}}
                                <label class="mt-4 flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="yes"
                                        {{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}
                                        class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500"
                                        onclick="toggleAlternativeInput(true)" />

                                    <div class="flex-1 leading-[1.25]">

                                        <div class="flex items-center gap-1">
                                            <span>Ada, yaitu</span>

                                            <input type="text" name="alternative_treatment_detail"
                                                id="alternative_treatment_detail"
                                                value="{{ old('alternative_treatment_detail') }}" maxlength="255"
                                                class="w-full max-w-[300px] border-0 border-b border-black
                               bg-transparent px-1 py-0
                               focus:border-blue-500 focus:outline-none focus:ring-0"
                                                placeholder="" />
                                        </div>

                                        <div class="italic">
                                            Yes, namely
                                        </div>

                                    </div>

                                </label>


                                {{-- PILIHAN ALTERNATIF --}}
                                <div class="mt-5 ml-[38px] leading-[1.4]">

                                    {{-- A --}}
                                    <div class="flex">

                                        <div class="w-7 shrink-0">
                                            a.
                                        </div>

                                        <div>
                                            Upaya penegakan diagnosis tidak efektif.
                                        </div>

                                    </div>


                                    {{-- B --}}
                                    <div class="mt-2 flex">

                                        <div class="w-7 shrink-0">
                                            b.
                                        </div>

                                        <div>
                                            Tindakan/terapi selanjutnya dimungkinkan akan tidak
                                            efektif dan atau terlambat.
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- PARAF PENERIMA INFORMASI --}}
                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>





                        {{-- ===================================================== --}}
                        {{--  PERKIRAAN LAMA RAWAT --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    PERKIRAAN LAMA RAWAT
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Estimated Length of
                                    Hospitalization
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">

                                {{-- TIDAK ADA --}}
                                <label class="flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="none"
                                        {{ old('alternative_treatment') == 'none' ? 'checked' : '' }}
                                        class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500" />

                                    <div class=leading-[1.25]">
                                        <div>Tidak dirawat inap</div>
                                        <div class="italic">Not hospitalized </div>
                                    </div>

                                </label>


                                {{-- ADA --}}
                                <label class="mt-4 flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="yes"
                                        {{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}
                                        class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500"
                                        onclick="toggleAlternativeInput(true)" />

                                    <div class="flex-1 leading-[1.25]">

                                        <div class="flex items-center gap-1">
                                            <span>Rawat inap:</span>

                                            <input type="text" name="alternative_treatment_detail"
                                                id="alternative_treatment_detail"
                                                value="{{ old('alternative_treatment_detail') }}" maxlength="255"
                                                class="w-full max-w-[300px] border-0 border-b border-black
                               bg-transparent px-1 py-0
                               focus:border-blue-500 focus:outline-none focus:ring-0"
                                                placeholder="" />

                                            <span>hari</span>
                                        </div>

                                        <div class="italic">
                                            Hospitalized
                                        </div>

                                    </div>

                                </label>


                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                {{-- PARAF PENERIMA INFORMASI --}}
                                {{-- input checkbox untuk paraf penerima informasi --}}
                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>



                        {{-- ===================================================== --}}
                        {{--  PEMBIAYAAN  --}}
                        {{-- ===================================================== --}}
                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="border border-gray-300 bg-gray-50 px-4 py-4 align-top">

                                <div class="font-bold text-slate-900">
                                    PEMBIAYAAN
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    Cost
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="border border-gray-300 px-4 py-4 align-top">
                                <p>Sesuai dengan obat dan alat yang digunakan serta jasa
                                    Petugas/Dokter.</p>
                                <i>According to the medication, equipment used, and the services of
                                    the staff/doctor.</i>
                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                <input type="checkbox" name="diagnosis_initial" value="1"
                                    class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            </td>

                        </tr>




                    </tbody>
                </table>

                <div class="pt-3 pb-3 pl-3">
                    <p>Pekanbaru, 20 Juni 2024</p>
                    <p>Jam : 10.00 WIB</p>
                </div>


                <table class="w-full border-collapse border border-gray-300">
                    <tbody>

                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">

                                <div class="font-bold text-slate-900">
                                    Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas
                                    secara benar dan jujur dan memberikan kesempatan untuk bertanya
                                    dan/atau berdiskusi.
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    I hereby state that I have explained the above matters accurately and honestly and have
                                    provided the opportunity for questions and/or discussion.
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="w-1/4 border border-gray-300 px-4 py-3 align-top text-center">
                                <div class="font-bold leading-tight">
                                    Tanda Tangan Dokter<br>

                                </div>

                                <div class="mt-1 text-sm italic leading-tight">
                                    Doctor's Signature
                                </div>

                                <div
                                    class="mt-3 flex h-24 w-full cursor-crosshair items-center justify-center rounded-md border border-dashed border-gray-400 bg-gray-50">

                                    <div class="relative w-full h-full flex items-center justify-center">
                                        <canvas id="doctor_signature_canvas" class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>
                                        <span class="text-sm text-gray-400 pointer-events-none">Area Tanda Tangan</span>
                                        <button type="button" id="doctor_signature_clear_btn"
                                            class="absolute top-1 right-1 text-[10px] text-gray-500 hover:text-red-500 bg-white border rounded px-1"
                                            onclick="clearSignature(this)">Clear</button>
                                        <input type="hidden" name="signature[]" id="doctor_signature_input" class="signature-input">
                                    </div>

                                </div>
                            </td>
                        </tr>



                        <tr>

                            {{-- KOLOM 1 --}}
                            <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">

                                <div class="font-bold text-slate-900">
                                    Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana
                                    di
                                    atas yang saya beri tanda/paraf di kolom kanannya, dan telah
                                    memahaminya
                                </div>

                                <div class="text-sm italic text-gray-600">
                                    I hereby state that I have received the above information, which I have marked/initialed
                                    in
                                    the respective column, and I have understood it.
                                </div>

                            </td>


                            {{-- KOLOM 2 --}}
                            <td class="w-1/4 border border-gray-300 px-4 py-3 align-top text-center">
                                <div class="font-bold leading-tight">
                                    Tanda Tangan<br>
                                    Penerima Informasi
                                </div>

                                <div class="mt-1 text-sm italic leading-tight">
                                    Recipient's Signature:
                                </div>

                                <div
                                    class="mt-3 flex h-24 w-full cursor-crosshair items-center justify-center rounded-md border border-dashed border-gray-400 bg-gray-50">

                                    <div class="relative w-full h-full flex items-center justify-center">
                                        <canvas
                                            class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>
                                        <span class="text-sm text-gray-400 pointer-events-none">Area Tanda Tangan</span>
                                        <button type="button"
                                            class="absolute top-1 right-1 text-[10px] text-gray-500 hover:text-red-500 bg-white border rounded px-1"
                                            onclick="clearSignature(this)">Clear</button>
                                        <input type="hidden" name="signature[]" class="signature-input">
                                    </div>

                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <br>
            <br>
            <div class="border-t border-dashed border-gray-400"></div>

            <div class="pt-5">
                <div class="heading text-center font-bold">
                    <p>PERSETUJUAN TINDAKAN ATAU PENGOBATAN MEDIS </p>
                    <i>CONSENT FOR MEDICAL PROCEDURE OR TREATMENT </i>
                </div>

                <div>
                    <p>
                        Yang bertandatangan di bawah ini
                    </p>
                    <i>
                        The undersigned below:
                    </i>
                </div>

                <div class="pt-3 ml-7">
                    <table class="w-full border-collapse border border-gray-300">
                        <tbody>
                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    <div class="font-bold text-slate-900">Nama</div>
                                    <div class="text-sm italic text-gray-600">Name</div>
                                </td>
                                <td class="w-2/3 border border-gray-300 px-4 py-3 align-top">
                                    <input type="text" name="wali_nama"
                                        class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                        placeholder="Masukkan nama">
                                </td>
                            </tr>

                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    <div class="font-bold text-slate-900">Umur</div>
                                    <div class="text-sm italic text-gray-600">Age</div>
                                </td>
                                <td class="w-2/3 border border-gray-300 px-4 py-3 align-top">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="wali_umur"
                                                class="w-20 rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <span>tahun <i class="text-gray-600">/ years</i></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span>Jenis Kelamin <i class="text-gray-600">/ Gender</i>:</span>
                                            <select name="wali_jk"
                                                class="rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <option value="">Pilih... / Select...</option>
                                                <option value="L">Laki-laki / Male</option>
                                                <option value="P">Perempuan / Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    <div class="font-bold text-slate-900">Alamat</div>
                                    <div class="text-sm italic text-gray-600">Address</div>
                                </td>
                                <td class="w-2/3 border border-gray-300 px-4 py-3 align-top">
                                    <textarea name="wali_alamat" rows="2"
                                        class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                        placeholder="Masukkan alamat lengkap"></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    <div class="font-bold text-slate-900">No Kartu Identitas</div>
                                    <div class="text-sm italic text-gray-600">ID Card Number</div>
                                </td>
                                <td class="w-2/3 border border-gray-300 px-4 py-3 align-top">
                                    <div class="flex items-center gap-2">
                                        <select name="wali_jenis_identitas"
                                            class="rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <option value="KTP">KTP</option>
                                            <option value="SIM">SIM</option>
                                            <option value="Paspor">Paspor / Passport</option>
                                        </select>
                                        <input type="text" name="wali_identitas"
                                            class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                            placeholder="Masukkan nomor identitas">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pt-4 flex items-center gap-2">
                    <div class="flex flex-col">
                        <p class="font-bold text-slate-900">Hubungan dengan pasien:</p>
                        <i class="text-sm text-gray-600">Relationship to patient:</i>
                    </div>
                    <select id="wali_hubungan" name="wali_hubungan"
                        class="rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        onchange="document.getElementById('wali_hubungan_lainnya').classList.toggle('hidden', this.value !== 'lainnya')">
                        <option value="">Pilih... / Select...</option>
                        <option value="diri_sendiri">Diri sendiri / Self</option>
                        <option value="suami">Suami / Husband</option>
                        <option value="istri">Istri / Wife</option>
                        <option value="ayah">Ayah / Father</option>
                        <option value="ibu">Ibu / Mother</option>
                        <option value="anak">Anak / Child</option>
                        <option value="lainnya">Lainnya / Other</option>
                    </select>
                    <input type="text" id="wali_hubungan_lainnya" name="wali_hubungan_lainnya"
                        class="hidden w-48 rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Tuliskan hubungan...">
                </div>

                <div class="pt-4 flex items-center gap-2 flex-wrap">
                    <div class="flex flex-col">
                        <p class="font-bold text-slate-900">Dengan ini menyatakan</p>
                        <i class="text-sm text-gray-600">Hereby states</i>
                    </div>
                    <select name="pernyataan_tindakan"
                        class="rounded-md border border-gray-300 font-bold px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="SETUJU">SETUJU / AGREE</option>
                        <option value="TIDAK SETUJU">TIDAK SETUJU / DISAGREE</option>
                    </select>
                    <div class="flex flex-col">
                        <p class="font-bold text-slate-900">untuk dilakukan tindakan atau pengobatan medis tersebut
                            terhadap pasien:</p>
                        <i class="text-sm text-gray-600">for the medical procedure or treatment to be performed on the
                            patient:</i>
                    </div>
                </div>

                <div class="mt-4 flex justify-center">
                    <div class="inline-block w-fit border border-gray-300 px-3 py-2 text-left text-xs leading-5">
                        Nama : <span
                            id="sticker_patient_name">{{ $patient->name ?? '.......................' }}</span><br>
                        Tgl Lahir: <span
                            id="sticker_patient_dob">{{ $patient?->date_of_birth?->format('d/m/Y') ?? '.......................' }}</span><br>
                        RM : <span id="sticker_patient_rm">{{ $patient->medical_record_number ?? '.......' }}</span>
                        &nbsp; JK :
                        <span id="sticker_patient_jk">{{ $patient->gender ?? '.......' }}</span><br>
                        <span class="font-semibold">*Tempel Stiker Pasien</span>
                    </div>
                </div>


                <div class="pt-3">
                    <p class="font-bold text-slate-900">Dengan ini menyatakan: </p>
                    <i class="text-sm text-gray-600">Hereby states:</i>
                    <div class="ml-7 mt-2 space-y-3">

                        {{-- checkbox 1 --}}
                        <label class="flex items-start">
                            <input type="checkbox" name="check_realize_not_exact_science"
                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                            <div class="ml-2 flex flex-col">
                                <span class="text-slate-900">Saya mengakui telah menerima informasi penjelasan mengenai
                                    tindakan yang akan dilakukan.</span>
                                <i class="text-sm text-gray-600">I acknowledge that I have received an explanation
                                    regarding the procedure to be performed.</i>
                            </div>
                        </label>

                        {{-- checkbox 2 --}}
                        <label class="flex items-start">
                            <input type="checkbox"
                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                            <div class="ml-2 flex flex-col">
                                <span class="text-slate-900">Saya memahami perlunya dan manfaat tindakan tersebut
                                    sebagaimana telah dijelaskan seperti sebelumnya kepada saya, termasuk risiko dan
                                    komplikasi yang mungkin timbul bila tindakan dilakukan atau tidak dilakukan.</span>
                                <i class="text-sm text-gray-600">I understand the necessity and benefits of the procedure
                                    as previously explained to me, including the risks and complications that may arise if
                                    the procedure is performed or not performed.</i>
                            </div>
                        </label>

                        {{-- checkbox 3 --}}
                        <label class="flex items-start">
                            <input type="checkbox"
                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                            <div class="ml-2 flex flex-col">
                                <span class="text-slate-900">Saya mengakui bahwa saya telah diberikan kesempatan untuk
                                    bertanya informasi lebih banyak tentang prosedur ini.</span>
                                <i class="text-sm text-gray-600">I acknowledge that I have been given the opportunity to
                                    ask for more information about this procedure.</i>
                            </div>
                        </label>

                        {{-- checkbox 4 --}}
                        <label class="flex items-start">
                            <input type="checkbox"
                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                            <div class="ml-2 flex flex-col">
                                <span class="text-slate-900">Saya juga menyadari tidak ada jaminan yang diberikan bahwa
                                    Dokter ataupun petugas yang melaksanakan tindakan dengan hasil yang sesuai dengan yang
                                    dijelaskan.</span>
                                <i class="text-sm text-gray-600">I also realize that no guarantee is given that the Doctor
                                    or the staff performing the procedure will achieve the results exactly as explained.</i>
                            </div>
                        </label>

                        {{-- checkbox 5 --}}
                        <label class="flex items-start">
                            <input type="checkbox"
                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                            <div class="ml-2 flex flex-col">
                                <span class="text-slate-900">Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah
                                    ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat
                                    bergantung kepada izin Tuhan Yang Maha Esa.</span>
                                <i class="text-sm text-gray-600">I also realize that because medical science is not an
                                    exact science, the success of a medical procedure is not a certainty, but highly depends
                                    on the permission of God Almighty.</i>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <span>Pekanbaru, Tanggal</span>
                        <input type="date" name="tanggal_persetujuan"
                            class="rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Jam :</span>
                        <input type="text" name="jam_persetujuan"
                            class="w-24 cursor-pointer rounded-md border border-gray-300 px-3 py-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            placeholder="00:00" readonly>
                        <span>WIB</span>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="text-center">
                        <p class="mb-2 font-bold text-slate-900">Yang Menyatakan</p>
                        <div
                            class="mb-2 flex h-32 w-full cursor-crosshair items-center justify-center rounded-md border border-dashed border-gray-400 bg-gray-50">

                            <div class="relative w-full h-full flex items-center justify-center">
                                <canvas class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>
                                <span class="text-sm text-gray-400 pointer-events-none">Area Tanda Tangan</span>
                                <button type="button"
                                    class="absolute top-1 right-1 text-[10px] text-gray-500 hover:text-red-500 bg-white border rounded px-1"
                                    onclick="clearSignature(this)">Clear</button>
                                <input type="hidden" name="signature[]" class="signature-input">
                            </div>

                        </div>
                        <input type="text" name="yang_menyatakan_nama" placeholder="Nama Lengkap"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-center text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="text-center">
                        <p class="mb-2 font-bold text-slate-900">Saksi I</p>
                        <div
                            class="mb-2 flex h-32 w-full cursor-crosshair items-center justify-center rounded-md border border-dashed border-gray-400 bg-gray-50">

                            <div class="relative w-full h-full flex items-center justify-center">
                                <canvas class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>
                                <span class="text-sm text-gray-400 pointer-events-none">Area Tanda Tangan</span>
                                <button type="button"
                                    class="absolute top-1 right-1 text-[10px] text-gray-500 hover:text-red-500 bg-white border rounded px-1"
                                    onclick="clearSignature(this)">Clear</button>
                                <input type="hidden" name="signature[]" class="signature-input">
                            </div>

                        </div>
                        <input type="text" name="saksi_1_nama" placeholder="Nama Lengkap"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-center text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="text-center">
                        <p class="mb-2 font-bold text-slate-900">Saksi II</p>
                        <div
                            class="mb-2 flex h-32 w-full cursor-crosshair items-center justify-center rounded-md border border-dashed border-gray-400 bg-gray-50">

                            <div class="relative w-full h-full flex items-center justify-center">
                                <canvas class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>
                                <span class="text-sm text-gray-400 pointer-events-none">Area Tanda Tangan</span>
                                <button type="button"
                                    class="absolute top-1 right-1 text-[10px] text-gray-500 hover:text-red-500 bg-white border rounded px-1"
                                    onclick="clearSignature(this)">Clear</button>
                                <input type="hidden" name="signature[]" class="signature-input">
                            </div>

                        </div>
                        <input type="text" name="saksi_2_nama" placeholder="Nama Lengkap"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-center text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

            </div>


            {{-- ================= ACTION ================= --}}
            <div class="mt-6 flex justify-end gap-3">

                <a href="{{ route('dashboard') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700
                    transition hover:bg-gray-50">
                    Batal
                </a>

                <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                    transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan Persetujuan
                </button>

            </div>

        </form>

    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker@v2.0.0/dist/mdtimepicker.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Analog 24-hour time picker
            mdtimepicker('input[name="jam_persetujuan"]', {
                is24hour: true,
                format: 'hh:mm',
                clearBtn: true
            });
            // Signature pad logic
            const canvases = document.querySelectorAll('canvas.signature-pad');
            canvases.forEach(canvas => {
                const ctx = canvas.getContext('2d');
                let isDrawing = false;

                // Resize canvas correctly
                function resizeCanvas() {
                    const rect = canvas.parentElement.getBoundingClientRect();
                    canvas.width = rect.width;
                    canvas.height = rect.height;
                }
                window.addEventListener('resize', resizeCanvas);
                resizeCanvas(); // initial sizing

                function getCoordinates(e) {
                    const rect = canvas.getBoundingClientRect();
                    let x, y;
                    if (e.touches && e.touches.length > 0) {
                        x = e.touches[0].clientX - rect.left;
                        y = e.touches[0].clientY - rect.top;
                    } else {
                        x = e.clientX - rect.left;
                        y = e.clientY - rect.top;
                    }
                    return {
                        x,
                        y
                    };
                }

                function startDrawing(e) {
                    isDrawing = true;
                    const {
                        x,
                        y
                    } = getCoordinates(e);
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                    e.preventDefault();
                }

                function draw(e) {
                    if (!isDrawing) return;
                    const {
                        x,
                        y
                    } = getCoordinates(e);
                    ctx.lineTo(x, y);
                    ctx.stroke();
                    e.preventDefault();
                }

                function stopDrawing() {
                    if (isDrawing) {
                        isDrawing = false;
                        ctx.closePath();
                        // Save signature data
                        const dataUrl = canvas.toDataURL();
                        canvas.parentElement.querySelector('.signature-input').value = dataUrl;
                    }
                }

                canvas.addEventListener('mousedown', startDrawing);
                canvas.addEventListener('mousemove', draw);
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mouseout', stopDrawing);

                canvas.addEventListener('touchstart', startDrawing, {
                    passive: false
                });
                canvas.addEventListener('touchmove', draw, {
                    passive: false
                });
                canvas.addEventListener('touchend', stopDrawing);
            });

            window.clearSignature = function(btn) {
                const container = btn.closest('.relative');
                const canvas = container.querySelector('canvas.signature-pad');
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                container.querySelector('.signature-input').value = '';
            };

            const waliRelationship = document.getElementById('wali_hubungan');
            const waliOtherInput = document.getElementById('wali_hubungan_lainnya');

            if (waliRelationship && waliOtherInput) {
                waliRelationship.addEventListener('change', function() {
                    if (this.value === 'lainnya') {
                        waliOtherInput.classList.remove('hidden');
                        waliOtherInput.required = true;
                    } else {
                        waliOtherInput.classList.add('hidden');
                        waliOtherInput.required = false;
                        waliOtherInput.value = '';
                    }
                });
            }

            const relationship = document.getElementById('relationship');
            const otherRelationshipDiv = document.getElementById('otherRelationship');
            const otherInput = document.getElementById('other_relationship');

            if (relationship && otherRelationshipDiv && otherInput) {
                relationship.addEventListener('change', function() {
                    if (this.value === 'lainnya') {
                        otherRelationshipDiv.classList.remove('hidden');
                        otherInput.required = true;
                    } else {
                        otherRelationshipDiv.classList.add('hidden');
                        otherInput.required = false;
                        otherInput.value = '';
                    }
                });
            }

            const patientSelect = document.getElementById('patient_id');
            if (patientSelect) {
                patientSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const name = selected.value ? selected.getAttribute('data-name') :
                        '.......................';
                    const rm = selected.value ? selected.getAttribute('data-rm') : '.......';
                    const dob = selected.value ? selected.getAttribute('data-dob') :
                        '.......................';
                    const jk = selected.value ? selected.getAttribute('data-jk') : '.......';

                    document.getElementById('header_patient_name').textContent = selected.value ? name :
                        'N/A';
                    document.getElementById('header_patient_rm').textContent = selected.value ? rm : 'N/A';

                    document.getElementById('sticker_patient_name').textContent = name;
                    document.getElementById('sticker_patient_rm').textContent = rm;
                    document.getElementById('sticker_patient_dob').textContent = dob;
                    document.getElementById('sticker_patient_jk').textContent = jk;
                });
            }

            const doctorSelect = document.getElementById('doctor');
            if(doctorSelect) {
                doctorSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const signatureData = selected.value ? selected.getAttribute('data-signature') : null;
                    const canvas = document.getElementById('doctor_signature_canvas');
                    const input = document.getElementById('doctor_signature_input');
                    
                    if(canvas && input) {
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        input.value = '';
                        const clearBtn = document.getElementById('doctor_signature_clear_btn');
                        
                        if(signatureData && signatureData !== '') {
                            const img = new Image();
                            img.onload = function() {
                                // Draw centered and scaled to fit if necessary
                                const hRatio = canvas.width / img.width;
                                const vRatio = canvas.height / img.height;
                                const ratio  = Math.min(hRatio, vRatio);
                                const centerShift_x = (canvas.width - img.width*ratio) / 2;
                                const centerShift_y = (canvas.height - img.height*ratio) / 2;
                                ctx.drawImage(img, 0,0, img.width, img.height, centerShift_x, centerShift_y, img.width*ratio, img.height*ratio);
                                input.value = signatureData;
                                if(clearBtn) clearBtn.style.display = 'none';
                            }
                            img.src = signatureData;
                        } else {
                            if(clearBtn) clearBtn.style.display = 'block';
                        }
                    }
                });
            }

            // Initial trigger if there is a preset value
            if (waliRelationship && waliRelationship.value === 'lainnya') {
                waliRelationship.dispatchEvent(new Event('change'));
            }
            if (relationship && relationship.value === 'lainnya') {
                relationship.dispatchEvent(new Event('change'));
            }
            if (patientSelect && patientSelect.value) {
                patientSelect.dispatchEvent(new Event('change'));
            }
            if (doctorSelect && doctorSelect.value) {
                doctorSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
