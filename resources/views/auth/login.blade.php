@extends('layouts.app')

@section('title', 'Login')

@section('styles')
    <style>
        /* Force light mode on login body background override */
        body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }
    </style>
@endsection

@section('content')
    <div class="flex-grow flex flex-col justify-center py-6 sm:px-6 lg:px-8 bg-slate-50 relative overflow-hidden">
        <!-- Decorative background elements (soft/light colored) -->
        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div class="absolute -bottom-10 right-0 w-80 h-80 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="sm:mx-auto w-full max-w-md z-10 text-center">
            <img src="login.png" alt="" srcset="" class="mx-auto h-14 w-auto">
            <h2 class="mt-3 text-xl font-extrabold text-slate-900 tracking-tight">
                Asesmen Radiologi Kontras
            </h2>
        </div>

        <div class="mt-6 sm:mx-auto w-full max-w-md z-10">
            <div class="bg-white py-6 px-4 shadow-lg border border-slate-200 sm:rounded-2xl sm:px-8">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-semibold text-slate-700">
                            Username
                        </label>
                        <div class="mt-1">
                            <input id="username" name="username" type="text" autocomplete="username" required
                                value="{{ old('username') }}"
                                class="appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700">
                            Kata Sandi
                        </label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
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
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 cursor-pointer">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-6 border-t border-slate-200 pt-4">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Akun Demo Cepat:</h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <button type="button" onclick="fillCreds('perawat')"
                            class="p-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-left hover:bg-slate-100 transition cursor-pointer">
                            <div class="font-bold text-green-600">PERAWAT</div>
                            <div class="truncate">perawat</div>
                            <div class="text-[10px] text-slate-400">pass: password</div>
                        </button>
                        <button type="button" onclick="fillCreds('dokter')"
                            class="p-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-left hover:bg-slate-100 transition cursor-pointer">
                            <div class="font-bold text-purple-600">DOKTER</div>
                            <div class="truncate">dokter</div>
                            <div class="text-[10px] text-slate-400">pass: password</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillCreds(username) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = 'password';
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
@endsection
