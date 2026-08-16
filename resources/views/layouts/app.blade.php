<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asesmen Radiologi Kontras') - RSAB</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            /* Slate 50 */
            color: #0f172a;
            /* Slate 900 */
        }
    </style>
    @yield('styles')
</head>

<body class="h-full flex flex-col">
    @auth
        <nav class="bg-white border-b border-slate-200 no-print">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span
                                class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                RadiologiKontras
                            </span>
                            <span
                                class="ml-2 px-2 py-0.5 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">
                                RSAB
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-slate-600">
                            Masuk sebagai: <strong class="text-slate-800">{{ Auth::user()->name }}</strong>
                            <span
                                class="ml-1 px-2 py-0.5 text-xs font-medium uppercase rounded {{ Auth::user()->role === 'dokter' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 border border-slate-300 text-xs font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm cursor-pointer">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 no-print">
        <div class="max-w-7xl mx-auto px-4">
            &copy; {{ date('Y') }} IT RS Awal Bros A. Yani -
            Sistem Asesmen Tindakan Radiologi Kontras
        </div>
    </footer>

    @yield('scripts')
</body>

</html>
