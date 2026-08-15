@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-900 relative overflow-hidden" style="min-height: calc(100vh - 64px - 53px)">
    <!-- Decorative background elements -->
    <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
    <div class="absolute -bottom-10 right-0 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="sm:mx-auto w-full max-w-md z-10">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-white tracking-tight">
            Asesmen Radiologi Kontras
        </h2>
        <p class="mt-2 text-center text-sm text-slate-400">
            RS Awal Bros
        </p>
    </div>

    <div class="mt-8 sm:mx-auto w-full max-w-md z-10">
        <div class="bg-white/10 backdrop-blur-md py-8 px-4 shadow-2xl border border-white/10 sm:rounded-2xl sm:px-10">
            @if($errors->any())
                <div class="mb-4 bg-red-900/30 border border-red-500 text-red-200 text-sm rounded-lg p-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-200">
                        Alamat Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="appearance-none block w-full px-3 py-2 border border-slate-700 rounded-lg bg-slate-800 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-200">
                        Kata Sandi
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-slate-700 rounded-lg bg-slate-800 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-750 bg-slate-800 rounded">
                        <label for="remember" class="ml-2 block text-sm text-slate-350">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 cursor-pointer">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-8 border-t border-slate-700/60 pt-6">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Akun Demo Cepat:</h3>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <button type="button" onclick="fillCreds('perawat@example.com')" class="p-2.5 bg-slate-800/80 border border-slate-700/65 text-slate-300 rounded-lg text-left hover:bg-slate-750 hover:text-white transition cursor-pointer">
                        <div class="font-bold text-green-400">PERAWAT</div>
                        <div>perawat@example.com</div>
                        <div class="text-[10px] text-slate-500">pass: password</div>
                    </button>
                    <button type="button" onclick="fillCreds('dokter@example.com')" class="p-2.5 bg-slate-800/80 border border-slate-700/65 text-slate-300 rounded-lg text-left hover:bg-slate-750 hover:text-white transition cursor-pointer">
                        <div class="font-bold text-purple-400">DOKTER</div>
                        <div>dokter@example.com</div>
                        <div class="text-[10px] text-slate-500">pass: password</div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fillCreds(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';
    }
</script>
@endsection
