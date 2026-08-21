@extends('layouts.app')

@section('title', 'Daftar Persetujuan Tindakan Medis')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Persetujuan Medis</h1>
                <p class="text-sm text-slate-500">Daftar Persetujuan Tindakan Medis</p>
            </div>
            <a href="{{ route('persetujuan-tindakan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">
                <svg class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Persetujuan
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-sm font-semibold text-slate-700">
                            <th class="py-3 px-4">Nama Pasien</th>
                            <th class="py-3 px-4">No RM</th>
                            <th class="py-3 px-4">Tindakan</th>
                            <th class="py-3 px-4">Waktu Persetujuan</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-sm">
                        @forelse($persetujuan as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4">{{ $item->patient->name ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $item->patient->medical_record_number ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $item->planned_procedure }}</td>
                                <td class="py-3 px-4">{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('persetujuan-tindakan.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <a href="{{ route('persetujuan-tindakan.edit', ['persetujuan_tindakan' => $item->id, 'mode' => 'patient']) }}" class="text-green-600 hover:text-green-800">Isi Pasien</a>
                                        <a href="{{ route('persetujuan-tindakan.destroy', $item->id) }}" class="text-red-600 hover:text-red-800" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus persetujuan tindakan ini?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">Hapus</a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('persetujuan-tindakan.destroy', $item->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 px-4 text-center text-slate-500">
                                    Belum ada data persetujuan tindakan medis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($persetujuan->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $persetujuan->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
