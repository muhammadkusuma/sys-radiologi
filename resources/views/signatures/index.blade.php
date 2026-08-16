@extends('layouts.app')

@section('title', 'Master Tanda Tangan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Master Tanda Tangan (TTD)</h1>
        <p class="text-sm text-slate-500">Unggah tanda tangan transparan Anda (.png) untuk digunakan secara otomatis pada dokumen asesmen.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm p-6 space-y-6">
        <div>
            <h2 class="text-base font-bold text-slate-900 mb-2">Tanda Tangan Anda Saat Ini</h2>
            <div class="border border-dashed border-slate-300 rounded-xl p-4 bg-slate-50 flex items-center justify-center min-h-[150px]">
                @if($user->signature)
                    <div class="text-center">
                        <img src="{{ $user->signature }}" alt="Tanda Tangan Anda" class="max-h-28 mx-auto bg-white p-2 border border-slate-200 rounded shadow-sm">
                        <span class="mt-2 block text-xs text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full border border-green-200 inline-block">Aktif</span>
                    </div>
                @else
                    <div class="text-center text-slate-500 text-sm">
                        <svg class="mx-auto h-12 w-12 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Tanda tangan belum diunggah.
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('signatures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700">Unggah Gambar TTD Baru (PNG transparan disarankan)</label>
                <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <label for="signature_file" class="relative cursor-pointer bg-white rounded-md font-semibold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Pilih file gambar</span>
                                <input id="signature_file" name="signature_file" type="file" accept="image/png" class="sr-only" required>
                            </label>
                        </div>
                        <p class="text-xs text-slate-500">Format PNG saja hingga ukuran 1MB</p>
                    </div>
                </div>
                <div id="file-name-preview" class="text-sm font-semibold text-blue-600 mt-2 text-center hidden"></div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">
                    Simpan Tanda Tangan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('signature_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('file-name-preview');
        if (file) {
            preview.textContent = 'File terpilih: ' + file.name;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    });
</script>
@endsection
