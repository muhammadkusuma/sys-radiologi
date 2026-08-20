@extends('layouts.app')

@section('title', 'Persetujuan Medis')

@section('styles')
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
                    {{ $patient->name ?? 'N/A' }}
                    (RM: {{ $patient->medical_record_number ?? 'N/A' }})
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
        <form method="POST" action="">
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
                                        <option value="{{ $doctor->id }}" @selected(old('doctor') == $doctor->id)>
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
                                    <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                        placeholder="Paraf" maxlength="10"
                                        class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                        class="mt-1 shrink-0 border-gray-500 text-blue-600
                       focus:ring-2 focus:ring-blue-500" />

                                    <div class=leading-[1.25]">
                                        <div>Tidak ada</div>
                                        <div class="italic">None</div>
                                    </div>

                                </label>


                                {{-- ADA --}}
                                <label class="mt-4 flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="yes"
                                        {{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}
                                        class="mt-1 h-[18px] w-[18px] shrink-0 border-gray-500 text-blue-600
                       focus:ring-2 focus:ring-blue-500"
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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                        class="mt-1 shrink-0 border-gray-500 text-blue-600
                       focus:ring-2 focus:ring-blue-500" />

                                    <div class=leading-[1.25]">
                                        <div>Tidak ada</div>
                                        <div class="italic">None</div>
                                    </div>

                                </label>


                                {{-- ADA --}}
                                <label class="mt-4 flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="yes"
                                        {{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}
                                        class="mt-1 h-[18px] w-[18px] shrink-0 border-gray-500 text-blue-600
                       focus:ring-2 focus:ring-blue-500"
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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                        class="mt-1 shrink-0 border-gray-500 text-blue-600
                       focus:ring-2 focus:ring-blue-500" />

                                    <div class=leading-[1.25]">
                                        <div>Tidak dirawat inap</div>
                                        <div class="italic">Not hospitalized </div>
                                    </div>

                                </label>


                                {{-- ADA --}}
                                <label class="mt-4 flex cursor-pointer items-start gap-3">

                                    <input type="radio" name="alternative_treatment" value="yes"
                                        {{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}
                                        class="mt-1 shrink-0 border-gray-500 text-blue-600
                       focus:ring-2 focus:ring-blue-500"
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
                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                    the staff/doctor./i>
                            </td>


                            {{-- KOLOM 3 --}}
                            <td class="border border-gray-300 px-4 py-4 text-center align-middle">

                                <input type="checkbox" name="diagnosis_initial" value="{{ old('diagnosis_initial') }}"
                                    placeholder="Paraf" maxlength="10"
                                    class="w-24 rounded-md border border-gray-300 px-3 py-2 text-center text-sm
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

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
                                    Nama
                                </td>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">

                                </td>
                            </tr>

                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    Umur :
                                </td>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    .... tahun Jenis Kelamin
                                </td>
                            </tr>

                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    Alamat
                                </td>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">

                                </td>
                            </tr>


                            <tr>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    No Kartu Identitas
                                </td>
                                <td class="w-1/3 border border-gray-300 bg-gray-50 px-4 py-3 align-top">
                                    ..... KTP/SIM/Pasport
                                </td>
                            </tr>
                        </tbody>

                    </table>


                </div>

                <div class="pt-3">
                    <p>Hubungan dengan pasien: Diri sendiri/suami/istri/ayah/ibu/anak/ _________________________</p>
                </div>
                <div class="pt-3">
                    <p>Dengan ini menyatakan _______________________________ untuk dilakukan tindakan atau pengobatan medis
                        tersebut terhadap pasien:</p>
                </div>

                <div class="flex justify-center">
                    <div class="inline-block w-fit border border-gray-300 px-3 py-2 text-left text-xs leading-5">
                        Nama : <br>
                        Tgl Lahir: <br>
                        RM : JK : <br>
                        <span class="font-semibold">*Tempel Stiker Pasien</span>
                    </div>
                </div>


                <div class="pt-3">
                    <p>Dengan ini menyatakan: </p>
                    <div class="ml-7">

                        {{-- checkbox --}}
                        <label class="flex items-center">
                            <input type="checkbox"
                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" required>
                            <span class="ml-2"> Saya mengakui telah menerima informasi penjelasan mengenai tindakan yang
                                akan dilakukan.</span>
                        </label>

                        {{-- checkbox --}}
                        <label class="flex items-center">
                            <input type="checkbox"
                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" required>
                            <span class="ml-2"> Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah
                                dijelaskan seperti sebelumnya kepada
                                saya, termasuk risiko dan komplikasi yang mungkin timbul bila tindakan dilakukan atau tidak
                                dilakukan.</span>
                        </label>

                        {{-- checkbox --}}
                        <label class="flex items-center">
                            <input type="checkbox"
                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" required>
                            <span class="ml-2"> Saya mengakui bahwa saya telah diberikan kesempatan untuk bertanya
                                informasi lebih banyak tentang prosedur ini. </span>
                        </label>

                        {{-- checkbox --}}
                        <label class="flex items-center">
                            <input type="checkbox"
                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" required>
                            <span class="ml-2"> Saya juga menyadari tidak ada jaminan yang diberikan bahwa Dokter ataupun
                                petugas yang melaksanakan tindakan
                                dengan hasil yang sesuai dengan yang dijelaskan </span>
                        </label>

                        {{-- checkbox --}}
                        <label class="flex items-center">
                            <input type="checkbox"
                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" required>
                            <span class="ml-2"> Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu
                                pasti, maka keberhasilan tindakan
                                kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha
                                Esa. </span>
                        </label>
                    </div>
                </div>

                <div class="pt-3">
                    Pekanbaru, Tanggal
                    <br>
                    Jam : ..... WIB
                </div>

                <div class="row">
                    <div class="col">Yang Menyatakan

                        <br>
                        {{-- input nama lengkap sama ttd --}}
                    </div>
                     <div class="col">Saksi I

                        <br>
                        {{-- input nama lengkap sama ttd --}}
                    </div>

                     <div class="col">Saksi II

                        <br>
                        {{-- input nama lengkap sama ttd --}}
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const relationship = document.getElementById('relationship');
            const otherRelationship = document.getElementById('otherRelationship');
            const otherInput = document.getElementById('other_relationship');

            if (!relationship || !otherRelationship || !otherInput) {
                return;
            }

            function toggleOtherRelationship() {

                const isOther = relationship.value === 'lainnya';

                if (isOther) {

                    otherRelationship.classList.remove('hidden');

                    otherInput.required = true;

                } else {

                    otherRelationship.classList.add('hidden');

                    otherInput.required = false;

                    otherInput.value = '';
                }
            }

            relationship.addEventListener('change', toggleOtherRelationship);

            // Jalankan saat halaman pertama kali dibuka
            toggleOtherRelationship();

        });
    </script>
@endsection
