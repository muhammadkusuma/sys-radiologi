@extends('layouts.app')

@section('title', 'Login')

@section('styles')
    <style>
        /* Force light mode on login body background override */
        body {
            background-color: #f8fafc !important;
            /* slate-50 */
            color: #0f172a !important;
            /* slate-900 */
        }
    </style>
@endsection

@section('content')
    <div class="flex-grow flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-50 relative overflow-hidden">
        <!-- Decorative background elements (soft/light colored) -->
        <div
            class="absolute top-0 -left-4 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute -bottom-10 right-0 w-80 h-80 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000">
        </div>

        <div class="sm:mx-auto w-full max-w-md z-10">
            <img src="login.png" alt="" srcset="" class="mx-auto h-16 w-auto">
            <h2 class="mt-6 text-center text-2xl font-extrabold text-slate-900 tracking-tight">
                Asesmen Radiologi Kontras
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto w-full max-w-md z-10">
            <div class="bg-white py-8 px-4 shadow-xl border border-slate-200 sm:rounded-2xl sm:px-10">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">
                            Alamat Email
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="appearance-none block w-full px-3 py-2 border border-slate-350 rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700">
                            Kata Sandi
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none block w-full px-3 py-2 border border-slate-350 rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-slate-600">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 cursor-pointer">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-8 border-t border-slate-200 pt-6">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Akun Demo Cepat:</h3>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <button type="button" onclick="fillCreds('perawat@example.com')"
                            class="p-2.5 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-left hover:bg-slate-100 transition cursor-pointer">
                            <div class="font-bold text-green-600">PERAWAT</div>
                            <div>perawat@example.com</div>
                            <div class="text-[10px] text-slate-400">pass: password</div>
                        </button>
                        <button type="button" onclick="fillCreds('dokter@example.com')"
                            class="p-2.5 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-left hover:bg-slate-100 transition cursor-pointer">
                            <div class="font-bold text-purple-600">DOKTER</div>
                            <div>dokter@example.com</div>
                            <div class="text-[10px] text-slate-400">pass: password</div>
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
