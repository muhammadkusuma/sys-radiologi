@extends('layouts.app')

@section('title', 'Master Pasien')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Master Pasien</h1>
            <p class="text-sm text-slate-500">Daftar Pasien Terdaftar di Sistem Radiologi</p>
        </div>
        <button onclick="togglePatientModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">
            <svg class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Daftar Pasien Baru
        </button>
    </div>



    <!-- Patient Table/Cards -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="p-5 border-b border-slate-200 bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-base font-bold text-slate-900">Daftar Pasien Terdaftar</h2>
            <div class="relative max-w-xs w-full">
                <input type="text" id="patientSearch" onkeyup="filterPatientTable()" placeholder="Cari pasien..." class="block w-full pl-9 pr-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Rekam Medis</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">L/P</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($patients as $patient)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">{{ $patient->medical_record_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $patient->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $patient->gender }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $patient->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $patient->address ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold space-x-2">
                                @if($patient->radiologyContrastAssessments->count() > 0)
                                    @php
                                        $latestAssessment = $patient->radiologyContrastAssessments->first();
                                    @endphp
                                    <a href="{{ route('assessments.edit', $latestAssessment->id) }}" class="inline-flex items-center px-2.5 py-1 bg-yellow-55 text-yellow-800 hover:bg-yellow-100 rounded text-xs border border-yellow-200">
                                        Edit Asesmen
                                    </a>
                                @else
                                    <a href="{{ route('assessments.create', $patient->id) }}" class="inline-flex items-center px-2.5 py-1 bg-green-50 text-green-700 hover:bg-green-100 rounded text-xs border border-green-200">
                                        + Asesmen
                                    </a>
                                @endif
                                <a href="{{ route('patients.edit', $patient->id) }}" class="text-blue-600 hover:text-blue-900 cursor-pointer">Edit</a>
                                <form id="delete-form-{{ $patient->id }}" action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $patient->id }}', 'Apakah Anda yakin ingin menghapus data pasien ini?')" class="text-red-600 hover:text-red-900 cursor-pointer">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">Belum ada data pasien terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Register Patient -->
<div id="patientModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/30 backdrop-blur-sm" onclick="togglePatientModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 relative z-10">
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                <div class="bg-white px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-slate-900">Daftarkan Pasien Baru</h3>
                    
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="medical_record_number" class="block text-sm font-semibold text-slate-700">No. Rekam Medis</label>
                            <input type="text" name="medical_record_number" id="medical_record_number" required placeholder="Contoh: 00286727" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                            <select name="gender" id="gender" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-semibold text-slate-700">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700">No. Telepon / HP</label>
                            <input type="text" name="phone" id="phone" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                            <textarea name="address" id="address" rows="3" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-200">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto cursor-pointer">Simpan</button>
                    <button type="button" onclick="togglePatientModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto cursor-pointer">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePatientModal() {
        const modal = document.getElementById('patientModal');
        modal.classList.toggle('hidden');
    }

    function filterPatientTable() {
        const input = document.getElementById("patientSearch");
        const filter = input.value.toLowerCase();
        const tbody = document.querySelector("table tbody");
        const rows = tbody.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName("td");
            if (cells.length < 5) continue;
            
            const rm = cells[0].textContent.toLowerCase();
            const nama = cells[1].textContent.toLowerCase();
            const phone = cells[4].textContent.toLowerCase();
            const address = cells[5].textContent.toLowerCase();

            if (rm.includes(filter) || nama.includes(filter) || phone.includes(filter) || address.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
    function confirmDelete(id, message) {
        showConfirm('Konfirmasi Hapus', message, () => {
            document.getElementById('delete-form-' + id).submit();
        });
    }
    document.getElementById('medical_record_number').addEventListener('blur', function(e) {
        let val = e.target.value.trim();
        if (val && /^\d+$/.test(val)) {
            e.target.value = val.padStart(8, '0');
        }
    });
</script>
@endsection
