@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center shadow-sm">
            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar / Patient Registration -->
        <div class="space-y-8">
            <!-- Register New Patient Form -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-1">Daftarkan Pasien Baru</h2>
                <p class="text-xs text-slate-500 mb-4">Tambahkan pasien untuk memulai asesmen tindakan radiologi.</p>

                <form action="{{ route('patients.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="medical_record_number" class="block text-xs font-semibold text-slate-700">No. Rekam Medis (RM)</label>
                        <input type="text" name="medical_record_number" id="medical_record_number" required placeholder="Contoh: 12-34-56" 
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('medical_record_number')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700">Nama Lengkap Pasien</label>
                        <input type="text" name="name" id="name" required placeholder="Nama lengkap sesuai KTP" 
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="gender" class="block text-xs font-semibold text-slate-700">Jenis Kelamin</label>
                            <select name="gender" id="gender" required class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-xs font-semibold text-slate-700">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-700">No. Telepon / HP</label>
                        <input type="text" name="phone" id="phone" placeholder="Contoh: 0812..." 
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-semibold text-slate-700">Alamat</label>
                        <textarea name="address" id="address" rows="3" placeholder="Alamat lengkap" 
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-750 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition cursor-pointer">
                        Simpan Pasien
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Area: Patients & Assessments -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Patients List -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Daftar Pasien Terdaftar</h2>
                        <p class="text-xs text-slate-500">Pilih pasien untuk membuat asesmen tindakan radiologi baru.</p>
                    </div>
                </div>

                <div class="overflow-x-auto max-h-[300px] overflow-y-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. RM</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">JK</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Lahir</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($patients as $patient)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">{{ $patient->medical_record_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $patient->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $patient->gender }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $patient->date_of_birth ? $patient->date_of_birth->format('d/m/Y') : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                        <a href="{{ route('assessments.create', $patient->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-750 shadow-sm transition">
                                            + Buat Asesmen
                                        </a>
                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasien dan semua histori asesmennya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2 py-1.5 border border-red-200 text-xs font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada data pasien terdaftar. Silakan tambahkan pasien terlebih dahulu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Assessments List -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-900">Daftar Asesmen Kontras Radiologi</h2>
                    <p class="text-xs text-slate-500">Histori asesmen medis, persetujuan tindakan, dan tanda tangan medis.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Tindakan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemeriksaan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($assessments as $ast)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900">{{ $ast->patient->name }}</div>
                                        <div class="text-xs text-slate-500">No. RM: {{ $ast->patient->medical_record_number }}</div>
                                    </td>
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
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                Selesai & Ditandatangani
                                            </span>
                                        @elseif($ast->nurse_signature)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                Menunggu TTD Dokter
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                                Draft / Belum Lengkap
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                        <a href="{{ route('assessments.show', $ast->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-slate-300 text-xs font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition">
                                            Lihat / Cetak
                                        </a>
                                        
                                        <a href="{{ route('assessments.show', $ast->id) }}?download=1" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-red-650 hover:bg-red-750 shadow-sm transition">
                                            Download PDF
                                        </a>
                                        
                                        @if(!$ast->doctor_signature || Auth::user()->role === 'dokter')
                                            <a href="{{ route('assessments.edit', $ast->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-slate-300 text-xs font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition">
                                                Edit
                                            </a>
                                        @endif
                                        
                                        <form action="{{ route('assessments.destroy', $ast->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen asesmen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2 py-1.5 border border-red-200 text-xs font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada data asesmen radiologi kontras.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
