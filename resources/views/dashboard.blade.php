@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
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
                        Sistem Informasi Radiologi
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Selamat Datang 👋
                    </h1>

                    <p class="mt-1 text-sm text-blue-100">
                        Halo,
                        <span class="font-semibold text-white">
                            {{ Auth::user()->name }}
                        </span>.
                        Semoga aktivitas Anda hari ini berjalan lancar.
                    </p>
                </div>

                @if (Auth::user()->role !== 'dokter')
                    <a href="{{ route('patients.index') }}"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50 hover:shadow-md">

                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>

                        Buat Asesmen Baru
                    </a>
                @endif

            </div>
        </div>


        {{-- =========================================================
            QUICK STATS
        ========================================================== --}}
        @if (Auth::user()->role !== 'dokter')
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Total --}}
                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Total Asesmen
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                                {{ count($assessments) }}
                            </p>

                            <p class="mt-2 text-xs text-slate-400">
                                Seluruh dokumen asesmen
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white">

                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>

                        </div>
                    </div>

                    <div class="mt-4 h-1 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full w-full rounded-full bg-blue-500"></div>
                    </div>
                </div>


                {{-- Selesai --}}
                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Selesai & TTD
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                                {{ $assessments->whereNotNull('doctor_signature')->count() }}
                            </p>

                            <p class="mt-2 text-xs text-emerald-600">
                                Dokumen telah selesai
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">

                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>
                    </div>

                    <div class="mt-4 h-1 overflow-hidden rounded-full bg-slate-100">
                        @php
                            $total = count($assessments);
                            $completed = $assessments->whereNotNull('doctor_signature')->count();
                            $completedPercentage = $total > 0 ? min(100, ($completed / $total) * 100) : 0;
                        @endphp

                        <div class="h-full rounded-full bg-emerald-500" style="width: {{ $completedPercentage }}%">
                        </div>
                    </div>
                </div>


                {{-- Menunggu --}}
                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Menunggu Dokter
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                                {{ $assessments->whereNull('doctor_signature')->whereNotNull('nurse_signature')->count() }}
                            </p>

                            <p class="mt-2 text-xs text-amber-600">
                                Menunggu tanda tangan
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-500 group-hover:text-white">

                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>
                    </div>

                    <div class="mt-4 h-1 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full w-1/2 rounded-full bg-amber-500"></div>
                    </div>
                </div>


                {{-- Draft --}}
                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Draft
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                                {{ $assessments->whereNull('doctor_signature')->whereNull('nurse_signature')->count() }}
                            </p>

                            <p class="mt-2 text-xs text-slate-400">
                                Belum ditandatangani
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition group-hover:bg-slate-700 group-hover:text-white">

                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>

                        </div>
                    </div>

                    <div class="mt-4 h-1 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full w-1/4 rounded-full bg-slate-400"></div>
                    </div>
                </div>

            </div>
        @endif


        {{-- =========================================================
            DOCUMENT LIST
        ========================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Header --}}
            <div class="border-b border-slate-200 bg-gradient-to-r from-white to-slate-50 px-5 py-5">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <div class="flex items-center gap-2">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">

                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>

                            </div>

                            <div>
                                <h2 class="text-base font-bold text-slate-900">
                                    @if (Auth::user()->role === 'dokter')
                                        Dokumen Menunggu TTD Dokter
                                    @else
                                        Daftar Dokumen Asesmen Radiologi Kontras
                                    @endif
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Kelola dan pantau dokumen asesmen pasien
                                </p>
                            </div>

                        </div>
                    </div>


                    {{-- Search --}}
                    <div class="relative w-full lg:max-w-sm">

                        <input type="text" id="assessmentSearch" onkeyup="filterAssessmentTable()"
                            placeholder="Cari No. RM, nama, pemeriksaan..."
                            class="block w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-10 text-sm placeholder-slate-400 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">

                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                        </div>

                        <button type="button" onclick="clearAssessmentSearch()" id="clearSearch"
                            class="absolute inset-y-0 right-0 hidden items-center pr-3 text-slate-400 hover:text-slate-600">

                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>

                        </button>

                    </div>

                </div>
            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table id="assessmentTable" class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                No. RM
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Nama Pasien
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Tanggal Tindakan
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Jenis Pemeriksaan
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th
                                class="whitespace-nowrap px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse($assessments as $ast)
                            <tr class="group transition hover:bg-blue-50/30">

                                {{-- RM --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span
                                        class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">

                                        {{ $ast->patient->medical_record_number }}

                                    </span>

                                </td>


                                {{-- Patient --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-600">

                                            {{ strtoupper(substr($ast->patient->name, 0, 1)) }}

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-900">
                                                {{ $ast->patient->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                Pasien
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Date --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                    <div class="font-medium">
                                        {{ $ast->procedure_date ? $ast->procedure_date->format('d/m/Y') : '-' }}
                                    </div>

                                    @if ($ast->procedure_time)
                                        <div class="text-xs text-slate-400">
                                            {{ substr($ast->procedure_time, 0, 5) }} WIB
                                        </div>
                                    @endif

                                </td>


                                {{-- Examination --}}
                                <td class="px-6 py-4">

                                    <span class="text-sm text-slate-700">
                                        {{ $ast->examination_type ?: 'Belum ditentukan' }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($ast->doctor_signature)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Selesai & Ditandatangani
                                        </span>
                                    @elseif($ast->nurse_signature)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                            Menunggu TTD Dokter
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                            Draft / Belum Lengkap
                                        </span>
                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <div class="inline-flex items-center justify-end gap-1.5">

                                        @if (Auth::user()->role === 'dokter')
                                            <a href="{{ route('assessments.show', $ast->id) }}" title="Review & TTD"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-purple-200 bg-purple-50 px-2.5 py-1.5 text-xs font-semibold text-purple-700 transition hover:bg-purple-100">

                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />

                                                </svg>

                                                Review & TTD

                                            </a>
                                        @else
                                            <a href="{{ route('assessments.pdf', ['assessment' => $ast->id, 'download' => 1]) }}"
                                                title="Download PDF"
                                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white p-1.5 text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">

                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />

                                                </svg>

                                            </a>


                                            <a href="{{ route('assessments.pdf', $ast->id) }}" target="_blank"
                                                title="Lihat PDF"
                                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white p-1.5 text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">

                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                                </svg>

                                            </a>


                                            <a href="{{ route('assessments.edit', $ast->id) }}" title="Edit"
                                                class="inline-flex items-center justify-center rounded-lg border border-blue-200 bg-blue-50 p-1.5 text-blue-600 transition hover:bg-blue-100">

                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />

                                                </svg>

                                            </a>


                                            <form id="delete-form-{{ $ast->id }}"
                                                action="{{ route('assessments.destroy', $ast->id) }}" method="POST"
                                                class="m-0 inline-flex">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button" title="Hapus"
                                                    onclick="confirmDelete('{{ $ast->id }}', 'Apakah Anda yakin ingin menghapus dokumen asesmen ini?')"
                                                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 p-1.5 text-red-600 transition hover:bg-red-100">

                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">

                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 0h14M10 11v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />

                                                    </svg>

                                                </button>

                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16">

                                    <div class="flex flex-col items-center justify-center text-center">

                                        <div
                                            class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                            </svg>

                                        </div>

                                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                                            Belum ada data asesmen
                                        </h3>

                                        <p class="mt-1 max-w-sm text-xs text-slate-500">
                                            Belum terdapat dokumen asesmen radiologi kontras yang dapat ditampilkan.
                                        </p>

                                        @if (Auth::user()->role !== 'dokter')
                                            <a href="{{ route('patients.index') }}"
                                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">

                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />

                                                </svg>

                                                Buat Asesmen

                                            </a>
                                        @endif

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Footer --}}
            @if (count($assessments) > 0)
                <div class="border-t border-slate-200 bg-slate-50 px-5 py-3">

                    <div class="flex items-center justify-between">

                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">
                                {{ count($assessments) }}
                            </span>
                            dokumen asesmen
                        </p>

                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-400">

                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                            Sistem aktif

                        </span>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection


@section('scripts')
    <script>
        function filterAssessmentTable() {
            const input = document.getElementById("assessmentSearch");
            const clearButton = document.getElementById("clearSearch");
            const filter = input.value.toLowerCase().trim();

            if (filter.length > 0) {
                clearButton.classList.remove("hidden");
                clearButton.classList.add("flex");
            } else {
                clearButton.classList.add("hidden");
                clearButton.classList.remove("flex");
            }

            const tbody = document.querySelector("#assessmentTable tbody");
            const rows = tbody.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {

                const row = rows[i];
                const cells = row.getElementsByTagName("td");

                if (cells.length < 5) {
                    continue;
                }

                const rowText = row.textContent.toLowerCase();

                if (rowText.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }


        function clearAssessmentSearch() {
            const input = document.getElementById("assessmentSearch");

            input.value = "";

            filterAssessmentTable();

            input.focus();
        }


        function confirmDelete(id, message) {
            showConfirm(
                'Konfirmasi Hapus',
                message,
                () => {
                    document.getElementById('delete-form-' + id).submit();
                }
            );
        }
    </script>
@endsection
