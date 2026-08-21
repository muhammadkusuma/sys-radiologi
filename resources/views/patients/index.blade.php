@extends('layouts.app')

@section('title', 'Master Pasien')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 px-6 py-6 shadow-lg">

            {{-- Decorative --}}
            <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-20 right-20 h-40 w-40 rounded-full bg-white/5"></div>

            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div
                        class="mb-2 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-blue-50 backdrop-blur-sm">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>

                        Master Data Pasien
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Master Pasien
                    </h1>

                    <p class="mt-1 text-sm text-blue-100">
                        Daftar pasien yang terdaftar di sistem radiologi.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="togglePatientModal()"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50 hover:shadow-md">

                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    Daftar Pasien Baru
                </button>

            </div>
        </div>


        {{-- Patient List --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div
                class="border-b border-slate-200 bg-gradient-to-r from-white to-slate-50 px-5 py-5">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Title --}}
                    <div>
                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                                <svg class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-10a4 4 0 110 8 4 4 0 010-8zm6 4a3 3 0 11-6 0 3 3 0 016 0z" />

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-base font-bold text-slate-900">
                                    Daftar Pasien Terdaftar
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Kelola data pasien dan buat asesmen radiologi
                                </p>

                            </div>

                        </div>
                    </div>


                    {{-- Search --}}
                    <div class="relative w-full lg:max-w-sm">

                        <input
                            type="text"
                            id="patientSearch"
                            onkeyup="filterPatientTable()"
                            placeholder="Cari No. RM, nama, telepon..."
                            class="block w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-10 text-sm placeholder-slate-400 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                        {{-- Search Icon --}}
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">

                            <svg class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />

                            </svg>

                        </div>

                        {{-- Clear --}}
                        <button
                            type="button"
                            id="clearPatientSearch"
                            onclick="clearPatientSearch()"
                            class="absolute inset-y-0 right-0 hidden items-center pr-3 text-slate-400 hover:text-slate-600">

                            <svg class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />

                            </svg>

                        </button>

                    </div>

                </div>
            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table id="patientTable"
                    class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                No. Rekam Medis
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Nama Pasien
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                                L/P
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Tanggal Lahir
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Telepon
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Alamat
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse($patients as $patient)

                            <tr class="group transition hover:bg-blue-50/30">

                                {{-- No RM --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span
                                        class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">

                                        {{ $patient->medical_record_number }}

                                    </span>

                                </td>


                                {{-- Nama --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-sm font-bold text-blue-700">

                                            {{ strtoupper(substr($patient->name, 0, 1)) }}

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-900">
                                                {{ $patient->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                Pasien
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Gender --}}
                                <td class="whitespace-nowrap px-6 py-4 text-center">

                                    @if ($patient->gender === 'L')

                                        <span
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-600">
                                            L
                                        </span>

                                    @elseif ($patient->gender === 'P')

                                        <span
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-pink-50 text-xs font-bold text-pink-600">
                                            P
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-500">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- Tanggal Lahir --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                    @if ($patient->date_of_birth)

                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') }}

                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- Telepon --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($patient->phone)

                                        <div class="flex items-center gap-2 text-sm text-slate-600">

                                            <svg class="h-4 w-4 text-slate-400"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.57 1.95l-1.2 1.2a16.02 16.02 0 006.36 6.36l1.2-1.2a2 2 0 011.95-.57l2.8.7A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1C9.716 23 3 16.284 3 8V5z" />

                                            </svg>

                                            {{ $patient->phone }}

                                        </div>

                                    @else

                                        <span class="text-sm text-slate-400">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- Alamat --}}
                                <td class="max-w-xs px-6 py-4">

                                    <p
                                        class="truncate text-sm text-slate-600"
                                        title="{{ $patient->address ?? '' }}">

                                        {{ $patient->address ?? '-' }}

                                    </p>

                                </td>


                                {{-- Action --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <div
                                        class="inline-flex items-center justify-end gap-1.5">

                                        {{-- Assessment --}}
                                        @if ($patient->radiologyContrastAssessments->count() > 0)

                                            @php
                                                $latestAssessment = $patient->radiologyContrastAssessments->first();
                                            @endphp

                                            <a
                                                href="{{ route('assessments.edit', $latestAssessment->id) }}"
                                                title="Edit Asesmen"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 transition hover:bg-amber-100">

                                                <svg class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />

                                                </svg>

                                            </a>

                                        @else

                                            <a
                                                href="{{ route('assessments.create', $patient->id) }}"
                                                title="Buat Asesmen"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-600 transition hover:bg-emerald-100">

                                                <svg class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 4v16m8-8H4" />

                                                </svg>

                                            </a>

                                        @endif


                                        {{-- Edit Pasien --}}
                                        <a
                                            href="{{ route('patients.edit', $patient->id) }}"
                                            title="Edit Pasien"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 transition hover:bg-blue-100">

                                            <svg class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />

                                            </svg>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            id="delete-form-{{ $patient->id }}"
                                            action="{{ route('patients.destroy', $patient->id) }}"
                                            method="POST"
                                            class="m-0 inline-flex">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="button"
                                                title="Hapus Pasien"
                                                onclick="confirmDelete('{{ $patient->id }}', 'Apakah Anda yakin ingin menghapus data pasien ini?')"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100">

                                                <svg class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 0h14M10 11v6m4-6v6m1-10V4a1 1 0 00-1 1v3" />

                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-16">

                                    <div
                                        class="flex flex-col items-center justify-center text-center">

                                        <div
                                            class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                            <svg class="h-8 w-8"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-10a4 4 0 110 8 4 4 0 010-8zm6 4a3 3 0 11-6 0 3 3 0 016 0z" />

                                            </svg>

                                        </div>

                                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                                            Belum ada data pasien
                                        </h3>

                                        <p class="mt-1 text-xs text-slate-500">
                                            Silakan daftarkan pasien baru untuk memulai.
                                        </p>

                                        <button
                                            type="button"
                                            onclick="togglePatientModal()"
                                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">

                                            <svg class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 4v16m8-8H4" />

                                            </svg>

                                            Daftar Pasien

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Footer --}}
            @if ($patients->count() > 0)

                <div
                    class="flex items-center justify-between border-t border-slate-200 bg-slate-50 px-5 py-3">

                    <p class="text-xs text-slate-500">

                        Menampilkan
                        <span class="font-semibold text-slate-700">
                            {{ $patients->count() }}
                        </span>
                        pasien

                    </p>

                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-400">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Data pasien

                    </span>

                </div>

            @endif

        </div>

    </div>


    {{-- =============================================================
        MODAL
    ============================================================= --}}
    <div
        id="patientModal"
        class="fixed inset-0 z-50 hidden overflow-y-auto">

        <div class="flex min-h-full items-center justify-center p-4">

            {{-- Overlay --}}
            <div
                class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
                onclick="togglePatientModal()">
            </div>


            {{-- Modal Content --}}
            <div
                class="relative z-10 w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">

                {{-- Modal Header --}}
                <div
                    class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 px-6 py-5">

                    <div
                        class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10">
                    </div>

                    <div class="relative flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-white">

                                <svg class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18 9a3 3 0 10-6 0 3 3 0 006 0zM6 21v-2a4 4 0 014-4h2a4 4 0 014 4v2M6 9a3 3 0 116 0 3 3 0 01-6 0z" />

                                </svg>

                            </div>

                            <div>

                                <h3 class="text-lg font-bold text-white">
                                    Daftarkan Pasien Baru
                                </h3>

                                <p class="text-xs text-blue-100">
                                    Lengkapi data pasien di bawah ini.
                                </p>

                            </div>

                        </div>


                        <button
                            type="button"
                            onclick="togglePatientModal()"
                            class="rounded-lg p-2 text-white/70 transition hover:bg-white/10 hover:text-white">

                            <svg class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />

                            </svg>

                        </button>

                    </div>

                </div>


                <form action="{{ route('patients.store') }}" method="POST">

                    @csrf

                    {{-- Form --}}
                    <div class="max-h-[70vh] overflow-y-auto px-6 py-6">

                        <div class="space-y-5">

                            {{-- RM --}}
                            <div>

                                <label
                                    for="medical_record_number"
                                    class="block text-sm font-semibold text-slate-700">

                                    No. Rekam Medis
                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="medical_record_number"
                                    id="medical_record_number"
                                    required
                                    placeholder="Contoh: 00286727"
                                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                            </div>


                            {{-- Nama --}}
                            <div>

                                <label
                                    for="name"
                                    class="block text-sm font-semibold text-slate-700">

                                    Nama Lengkap
                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    required
                                    placeholder="Masukkan nama lengkap pasien"
                                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                            </div>


                            {{-- Gender + DOB --}}
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                <div>

                                    <label
                                        for="gender"
                                        class="block text-sm font-semibold text-slate-700">

                                        Jenis Kelamin
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <select
                                        name="gender"
                                        id="gender"
                                        required
                                        class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                                        <option value="L">
                                            Laki-laki
                                        </option>

                                        <option value="P">
                                            Perempuan
                                        </option>

                                    </select>

                                </div>


                                <div>

                                    <label
                                        for="date_of_birth"
                                        class="block text-sm font-semibold text-slate-700">

                                        Tanggal Lahir

                                    </label>

                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        id="date_of_birth"
                                        class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                                </div>

                            </div>


                            {{-- Phone --}}
                            <div>

                                <label
                                    for="phone"
                                    class="block text-sm font-semibold text-slate-700">

                                    No. Telepon / HP

                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    placeholder="Contoh: 081234567890"
                                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                            </div>


                            {{-- Address --}}
                            <div>

                                <label
                                    for="address"
                                    class="block text-sm font-semibold text-slate-700">

                                    Alamat Lengkap

                                </label>

                                <textarea
                                    name="address"
                                    id="address"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap pasien"
                                    class="mt-1.5 block w-full resize-none rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"></textarea>

                            </div>

                        </div>

                    </div>


                    {{-- Modal Footer --}}
                    <div
                        class="flex flex-col-reverse gap-2 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">

                        <button
                            type="button"
                            onclick="togglePatientModal()"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md">

                            <svg class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                            Simpan Pasien

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@section('scripts')
<script>

    // ============================================================
    // MODAL
    // ============================================================

    function togglePatientModal() {

        const modal = document.getElementById('patientModal');

        modal.classList.toggle('hidden');

        if (!modal.classList.contains('hidden')) {

            document.body.classList.add('overflow-hidden');

            setTimeout(() => {
                document.getElementById('medical_record_number')?.focus();
            }, 100);

        } else {

            document.body.classList.remove('overflow-hidden');

        }
    }


    // ============================================================
    // SEARCH
    // ============================================================

    function filterPatientTable() {

        const input = document.getElementById('patientSearch');
        const clearButton = document.getElementById('clearPatientSearch');

        const filter = input.value.toLowerCase().trim();

        if (filter.length > 0) {

            clearButton.classList.remove('hidden');
            clearButton.classList.add('flex');

        } else {

            clearButton.classList.add('hidden');
            clearButton.classList.remove('flex');

        }

        const tbody = document.querySelector('#patientTable tbody');
        const rows = tbody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {

            const row = rows[i];
            const cells = row.getElementsByTagName('td');

            if (cells.length < 7) {
                continue;
            }

            const rowText = row.textContent.toLowerCase();

            row.style.display = rowText.includes(filter)
                ? ''
                : 'none';
        }
    }


    function clearPatientSearch() {

        const input = document.getElementById('patientSearch');

        input.value = '';

        filterPatientTable();

        input.focus();
    }


    // ============================================================
    // DELETE
    // ============================================================

    function confirmDelete(id, message) {

        showConfirm(
            'Konfirmasi Hapus',
            message,
            () => {
                document
                    .getElementById('delete-form-' + id)
                    .submit();
            }
        );
    }


    // ============================================================
    // FORMAT NO RM
    // ============================================================

    document
        .getElementById('medical_record_number')
        ?.addEventListener('blur', function(e) {

            let val = e.target.value.trim();

            if (val && /^\d+$/.test(val)) {
                e.target.value = val.padStart(8, '0');
            }

        });


    // ============================================================
    // ESC CLOSE MODAL
    // ============================================================

    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {

            const modal = document.getElementById('patientModal');

            if (modal && !modal.classList.contains('hidden')) {
                togglePatientModal();
            }

        }

    });

</script>
@endsection