@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-sm text-slate-500">Selamat datang kembali, <span class="font-semibold text-slate-700">{{ Auth::user()->name }}</span>.</p>
        </div>
        <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">
            <svg class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Asesmen Baru
        </a>
    </div>



    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1 -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center space-x-3">
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold">Total Asesmen</div>
                <div class="text-lg font-bold text-slate-900">{{ count($assessments) }}</div>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center space-x-3">
            <div class="p-2.5 bg-green-50 text-green-600 rounded-xl">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold">Selesai & TTD</div>
                <div class="text-lg font-bold text-slate-900">{{ $assessments->whereNotNull('doctor_signature')->count() }}</div>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center space-x-3">
            <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold">Menunggu Dokter</div>
                <div class="text-lg font-bold text-slate-900">{{ $assessments->whereNull('doctor_signature')->whereNotNull('nurse_signature')->count() }}</div>
            </div>
        </div>
        <!-- Stat 4 -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center space-x-3">
            <div class="p-2.5 bg-slate-50 text-slate-600 rounded-xl">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold">Draft / Belum TTD</div>
                <div class="text-lg font-bold text-slate-900">{{ $assessments->whereNull('doctor_signature')->whereNull('nurse_signature')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Assessments List -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="p-5 border-b border-slate-200 bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-base font-bold text-slate-900">Daftar Dokumen Asesmen Radiologi Kontras</h2>
            <div class="relative max-w-xs w-full">
                <input type="text" id="assessmentSearch" onkeyup="filterAssessmentTable()" placeholder="Cari asesmen..." class="block w-full pl-9 pr-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. RM</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Tindakan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Jenis Pemeriksaan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Dokumen</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($assessments as $ast)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">{{ $ast->patient->medical_record_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $ast->patient->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $ast->procedure_date ? $ast->procedure_date->format('d/m/Y') : '-' }} 
                                @if($ast->procedure_time)
                                    <span class="text-xs text-slate-400">({{ substr($ast->procedure_time, 0, 5) }} WIB)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                {{ $ast->examination_type ?: 'Belum ditentukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($ast->doctor_signature)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        Selesai & Ditandatangani
                                    </span>
                                @elseif($ast->nurse_signature)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                        Menunggu TTD Dokter
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                        Draft / Belum Lengkap
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold space-x-2">
                                <a href="{{ route('assessments.show', $ast->id) }}" class="inline-flex items-center px-2.5 py-1 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded border border-slate-300">
                                    Cetak / PDF
                                </a>
                                <a href="{{ route('assessments.edit', $ast->id) }}" class="inline-flex items-center px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded border border-blue-200">
                                    Edit
                                </a>
                                <form action="{{ route('assessments.destroy', $ast->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen asesmen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold rounded border border-red-200 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada data asesmen radiologi kontras.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterAssessmentTable() {
        const input = document.getElementById("assessmentSearch");
        const filter = input.value.toLowerCase();
        const tbody = document.querySelector("table tbody");
        const rows = tbody.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName("td");
            if (cells.length < 5) continue;
            
            const rm = cells[0].textContent.toLowerCase();
            const nama = cells[1].textContent.toLowerCase();
            const type = cells[3].textContent.toLowerCase();
            const status = cells[4].textContent.toLowerCase();

            if (rm.includes(filter) || nama.includes(filter) || type.includes(filter) || status.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
</script>
@endsection
