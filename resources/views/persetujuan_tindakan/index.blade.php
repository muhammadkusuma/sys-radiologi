@extends('layouts.app')

@section('title', 'Daftar Persetujuan Tindakan Medis')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Persetujuan Medis
                </h1>
                <p class="text-sm text-slate-500">
                    Daftar Persetujuan Tindakan Medis
                </p>
            </div>

            <a href="{{ route('persetujuan-tindakan.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">

                <svg class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Persetujuan
            </a>
        </div>


        {{-- Table Card --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">

            {{-- Table Header / Search --}}
            <div
                class="p-5 border-b border-slate-200 bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Daftar Persetujuan Tindakan Medis
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Data persetujuan tindakan medis pasien
                    </p>
                </div>

                {{-- Search --}}
                <div class="relative max-w-xs w-full">
                    <input type="text" id="persetujuanSearch" onkeyup="filterPersetujuanTable()"
                        placeholder="Cari pasien, No. RM, tindakan..."
                        class="block w-full pl-9 pr-3 py-2 border border-slate-300 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">

                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">
                <table id="persetujuanTable" class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">
                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                No. RM
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Nama Pasien
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Tindakan
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Waktu Persetujuan
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-slate-200">

                        @forelse($persetujuan as $item)
                            <tr class="hover:bg-slate-50/50 transition">

                                {{-- No RM --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                                    {{ $item->patient->medical_record_number ?? '-' }}
                                </td>

                                {{-- Nama --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                                    {{ $item->patient->name ?? '-' }}
                                </td>

                                {{-- Tindakan --}}
                                <td class="px-6 py-4 text-sm text-slate-700 max-w-md">
                                    <div class="line-clamp-2">
                                        {{ $item->planned_procedure ?? '-' }}
                                    </div>
                                </td>

                                {{-- Waktu --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">

                                    {{ $item->created_at?->format('d/m/Y') ?? '-' }}

                                    @if ($item->created_at)
                                        <span class="text-xs text-slate-400">
                                            ({{ $item->created_at->format('H:i') }} WIB)
                                        </span>
                                    @endif

                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">

                                    <div class="inline-flex items-center justify-end gap-2 flex-wrap">

                                        {{-- Edit --}}
                                        <a href="{{ route('persetujuan-tindakan.edit', $item->id) }}"
                                            class="inline-flex items-center px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded border border-blue-200">

                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />

                                            </svg>

                                            Edit
                                        </a>


                                        {{-- Cetak PDF --}}
                                        <a href="{{ route('persetujuan-tindakan.print', $item->id) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-2.5 py-1 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded border border-slate-200">

                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>

                                            Cetak PDF
                                        </a>

                                        {{-- Isi Pasien --}}
                                        <a href="{{ route('persetujuan-tindakan.edit', [
                                            'persetujuan_tindakan' => $item->id,
                                            'mode' => 'patient',
                                        ]) }}"
                                            class="inline-flex items-center px-2.5 py-1 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-semibold rounded border border-green-200">

                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                                            </svg>

                                            Isi Pasien
                                        </a>


                                        {{-- Hapus --}}
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('persetujuan-tindakan.destroy', $item->id) }}" method="POST"
                                            class="inline-flex items-center m-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                onclick="confirmDelete('{{ $item->id }}', 'Apakah Anda yakin ingin menghapus persetujuan tindakan ini?')"
                                                class="inline-flex items-center px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold rounded border border-red-200 cursor-pointer">

                                                <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />

                                                </svg>

                                                Hapus
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">

                                    Belum ada data persetujuan tindakan medis.

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>


            {{-- Pagination --}}
            @if ($persetujuan->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $persetujuan->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection


@section('scripts')
    <script>
        function filterPersetujuanTable() {
            const input = document.getElementById("persetujuanSearch");
            const filter = input.value.toLowerCase();

            const table = document.getElementById("persetujuanTable");
            const tbody = table.querySelector("tbody");
            const rows = tbody.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName("td");

                // Skip empty state row
                if (cells.length < 5) {
                    continue;
                }

                const rm = cells[0].textContent.toLowerCase();
                const nama = cells[1].textContent.toLowerCase();
                const tindakan = cells[2].textContent.toLowerCase();
                const waktu = cells[3].textContent.toLowerCase();

                if (
                    rm.includes(filter) ||
                    nama.includes(filter) ||
                    tindakan.includes(filter) ||
                    waktu.includes(filter)
                ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
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
