@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('patients.index') }}" class="text-slate-500 hover:text-slate-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Data Pasien</h1>
            <p class="text-sm text-slate-500">Perbarui informasi pasien terdaftar</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm p-6">
        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="medical_record_number" class="block text-sm font-semibold text-slate-700">No. Rekam Medis</label>
                    <input type="text" name="medical_record_number" id="medical_record_number" required value="{{ old('medical_record_number', $patient->medical_record_number) }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $patient->name) }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="gender" class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                    <select name="gender" id="gender" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        <option value="L" {{ old('gender', $patient->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender', $patient->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-semibold text-slate-700">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700">No. Telepon / HP</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">{{ old('address', $patient->address) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('medical_record_number').addEventListener('blur', function(e) {
        let val = e.target.value.trim();
        if (val && /^\d+$/.test(val)) {
            e.target.value = val.padStart(8, '0');
        }
    });
</script>
@endsection
