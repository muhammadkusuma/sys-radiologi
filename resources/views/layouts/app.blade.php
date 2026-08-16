<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asesmen Radiologi Kontras') - RSAB A. Yani</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/clocklet@0.3.0/css/clocklet.min.css">
    <script>
        if (localStorage.getItem("sidebar-collapsed") === "true" && window.innerWidth >= 768) {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* Sidebar Collapse CSS Rules based on html class */
        .sidebar-collapsed #sidebar #sidebar-title { display: none; }
        .sidebar-collapsed #sidebar #sidebar-logo { transform: scale(0.75); }
        .sidebar-collapsed #sidebar .sidebar-text { display: none; }
        .sidebar-collapsed #sidebar { width: 5rem !important; }

        /* Disable transitions on load */
        .preload, .preload * {
            transition: none !important;
        }
    </style>
    @yield('styles')
</head>

<body class="h-full flex flex-col md:flex-row overflow-x-hidden preload">
    @auth
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white border-r border-slate-200 flex flex-col transition-all duration-300 w-64 shrink-0 z-30 fixed inset-y-0 left-0 -translate-x-full md:translate-x-0 md:relative no-print">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 overflow-hidden">
                    <img id="sidebar-logo" src="/login.png" alt="Logo" class="h-8 w-auto flex-shrink-0 transition-all duration-300">
                </a>
                <button onclick="toggleSidebar()" class="text-slate-400 hover:text-slate-600 focus:outline-none hidden md:block">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <!-- Dashboard / Asesmen -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ Route::is('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="sidebar-text truncate">Asesmen Radiologi</span>
                </a>

                <!-- Master Pasien -->
                @if(Auth::user()->role === 'perawat' || Auth::user()->role === 'superadmin')
                <a href="{{ route('patients.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ Route::is('patients.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="sidebar-text truncate">Master Pasien</span>
                </a>
                @endif

                <!-- Master User -->
                @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ Route::is('users.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="sidebar-text truncate">Master User</span>
                </a>
                @endif

                <!-- Master TTD -->
                <a href="{{ route('signatures.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ Route::is('signatures.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span class="sidebar-text truncate">Master TTD</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-200 flex flex-col space-y-3 flex-shrink-0">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="sidebar-text truncate">
                        <div class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-500 uppercase font-semibold">{{ Auth::user()->role }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 border border-slate-200 text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm cursor-pointer">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="sidebar-text">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebar-overlay" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm z-20 hidden"></div>
    @endauth

    <!-- Main Container -->
    <div class="flex-grow flex flex-col min-h-screen min-w-0 bg-white">
        @auth
            <!-- Mobile Header -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 md:hidden flex-shrink-0 no-print">
                <button onclick="toggleMobileSidebar()" class="text-slate-500 hover:text-slate-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center">
                </div>
                <div class="w-6"></div>
            </header>
        @endauth

        <main class="flex-grow p-4 md:p-6 overflow-y-auto">
            @yield('content')
        </main>

        <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 no-print flex-shrink-0">
            <div class="max-w-7xl mx-auto px-4">
                &copy; {{ date('Y') }} IT RS Awal Bros A. Yani - Sistem Asesmen Tindakan Radiologi Kontras
            </div>
        </footer>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2 pointer-events-none no-print"></div>

    <!-- Custom Confirm Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900/30 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 relative z-10 p-6 space-y-4">
                <div class="flex items-center space-x-3 text-red-650">
                    <div class="p-2 bg-red-50 text-red-600 rounded-full">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900" id="confirm-title">Konfirmasi Tindakan</h3>
                </div>
                <div>
                    <p class="text-sm text-slate-500" id="confirm-message">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none cursor-pointer">Batal</button>
                    <button type="button" id="confirm-submit-btn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow focus:outline-none cursor-pointer">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Analog Clock Picker Modal -->
    <div id="analog-clock-picker" class="fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeClockPicker()"></div>
        
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-205 w-72 relative z-10 overflow-hidden flex flex-col items-center p-5 space-y-4 select-none">
            <!-- Time Display Header -->
            <div class="flex items-center justify-between w-full">
                <div class="flex items-baseline space-x-1 text-slate-800 font-bold text-4xl">
                    <span id="clock-display-hours" class="cursor-pointer text-blue-600 hover:text-blue-700">12</span>
                    <span class="text-slate-300 text-3xl">:</span>
                    <span id="clock-display-minutes" class="cursor-pointer text-slate-400 hover:text-blue-600">00</span>
                </div>
                <div class="text-xs font-bold bg-blue-50 text-blue-600 px-2.5 py-1 rounded border border-blue-100 uppercase tracking-wider">24 Jam</div>
            </div>
            
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 self-start" id="clock-mode-title">Pilih Jam</div>
            
            <!-- Clock Face -->
            <div class="relative w-52 h-52 bg-slate-50 rounded-full border border-slate-200 flex items-center justify-center">
                <div class="absolute w-2 h-2 bg-blue-600 rounded-full z-20"></div>
                
                <div id="clock-hand" class="absolute bg-blue-600 origin-bottom z-10 transition-transform duration-200" style="bottom: 50%; left: calc(50% - 1px); width: 2px; height: 72px; transform: rotate(0deg);">
                    <div class="absolute -top-3 -left-3 w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-xs text-white font-bold shadow-sm">
                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                    </div>
                </div>
                
                <div id="clock-numbers" class="absolute inset-0 z-0"></div>
            </div>
            
            <div class="flex justify-end w-full space-x-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeClockPicker()" class="px-3.5 py-1.5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="button" onclick="saveClockPicker()" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow cursor-pointer">OK</button>
            </div>
        </div>
    </div>

    <script>
        let activeConfirmCallback = null;

        function showConfirm(title, message, onConfirm) {
            document.getElementById('confirm-title').textContent = title || 'Konfirmasi Tindakan';
            document.getElementById('confirm-message').textContent = message || 'Apakah Anda yakin?';
            activeConfirmCallback = onConfirm;
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
            activeConfirmCallback = null;
        }

        document.getElementById('confirm-submit-btn').addEventListener('click', () => {
            if (typeof activeConfirmCallback === 'function') {
                activeConfirmCallback();
            }
            closeConfirmModal();
        });

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `flex items-center p-4 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto max-w-sm ${
                type === 'success' 
                    ? 'bg-green-50 text-green-800 border-green-200' 
                    : 'bg-red-50 text-red-800 border-red-200'
            }`;

            const icon = type === 'success' 
                ? `<svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                   </svg>`
                : `<svg class="h-5 w-5 text-red-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                   </svg>`;

            toast.innerHTML = `
                ${icon}
                <span class="flex-grow">${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-3 text-slate-400 hover:text-slate-600 focus:outline-none font-bold text-base cursor-pointer">&times;</button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }

        // Custom Analog Clock Picker JS Logic
        let targetInputEl = null;
        let selectedHour = 12;
        let selectedMinute = 0;
        let currentClockMode = 'hours';

        function openClockPicker(inputEl) {
            targetInputEl = inputEl;
            const currentVal = inputEl.value || '12:00';
            const parts = currentVal.split(':');
            selectedHour = parseInt(parts[0]);
            if (isNaN(selectedHour) || selectedHour < 0 || selectedHour > 23) {
                selectedHour = 12;
            }
            selectedMinute = parseInt(parts[1]);
            if (isNaN(selectedMinute) || selectedMinute < 0 || selectedMinute > 59) {
                selectedMinute = 0;
            }
            
            currentClockMode = 'hours';
            updateClockPickerUI();
            
            document.getElementById('analog-clock-picker').classList.remove('hidden');
        }

        function closeClockPicker() {
            document.getElementById('analog-clock-picker').classList.add('hidden');
            targetInputEl = null;
        }

        function saveClockPicker() {
            if (targetInputEl) {
                const hh = String(selectedHour).padStart(2, '0');
                const mm = String(selectedMinute).padStart(2, '0');
                targetInputEl.value = `${hh}:${mm}`;
                targetInputEl.dispatchEvent(new Event('change'));
            }
            closeClockPicker();
        }

        function updateClockPickerUI() {
            const hoursDisplay = document.getElementById('clock-display-hours');
            const minutesDisplay = document.getElementById('clock-display-minutes');
            const modeTitle = document.getElementById('clock-mode-title');
            
            hoursDisplay.textContent = String(selectedHour).padStart(2, '0');
            minutesDisplay.textContent = String(selectedMinute).padStart(2, '0');

            if (currentClockMode === 'hours') {
                hoursDisplay.className = "cursor-pointer text-blue-600 font-bold";
                minutesDisplay.className = "cursor-pointer text-slate-400 hover:text-blue-500 font-semibold";
                modeTitle.textContent = "Pilih Jam";
                renderClockNumbers(12);
            } else {
                hoursDisplay.className = "cursor-pointer text-slate-400 hover:text-blue-500 font-semibold";
                minutesDisplay.className = "cursor-pointer text-blue-600 font-bold";
                modeTitle.textContent = "Pilih Menit";
                renderClockNumbers(60);
            }
        }

        function renderClockNumbers(mode) {
            const container = document.getElementById('clock-numbers');
            container.innerHTML = '';
            
            const radius = 80;
            const centerX = 100;
            const centerY = 100;
            
            if (mode === 12) {
                // Outer Ring (1 - 12)
                for (let i = 1; i <= 12; i++) {
                    const angle = (i * 30 - 90) * (Math.PI / 180);
                    const x = centerX + radius * Math.cos(angle);
                    const y = centerY + radius * Math.sin(angle);
                    
                    const isSelected = selectedHour === i;
                    const numDiv = document.createElement('div');
                    numDiv.className = `absolute w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold cursor-pointer transition-colors ${
                        isSelected
                            ? 'bg-blue-600 text-white z-20 shadow-sm' 
                            : 'text-slate-700 hover:bg-slate-200 z-10'
                    }`;
                    numDiv.style.left = `${x - 14}px`;
                    numDiv.style.top = `${y - 14}px`;
                    numDiv.textContent = i;
                    
                    numDiv.addEventListener('click', (e) => {
                        e.stopPropagation();
                        selectedHour = i;
                        setHandRotation(i * 30, 72);
                        setTimeout(() => {
                            currentClockMode = 'minutes';
                            updateClockPickerUI();
                        }, 200);
                    });
                    
                    container.appendChild(numDiv);
                }

                // Inner Ring (13 - 24/00)
                const innerRadius = 50;
                for (let i = 13; i <= 24; i++) {
                    const val = i === 24 ? 0 : i;
                    const angle = ((i - 12) * 30 - 90) * (Math.PI / 180);
                    const x = centerX + innerRadius * Math.cos(angle);
                    const y = centerY + innerRadius * Math.sin(angle);
                    
                    const isSelected = selectedHour === val;
                    const numDiv = document.createElement('div');
                    numDiv.className = `absolute w-6.5 h-6.5 rounded-full flex items-center justify-center text-[10px] font-bold cursor-pointer transition-colors ${
                        isSelected
                            ? 'bg-blue-600 text-white z-20 shadow-sm' 
                            : 'text-slate-400 hover:bg-slate-200 z-10'
                    }`;
                    numDiv.style.left = `${x - 13}px`;
                    numDiv.style.top = `${y - 13}px`;
                    numDiv.textContent = i === 24 ? '00' : i;
                    
                    numDiv.addEventListener('click', (e) => {
                        e.stopPropagation();
                        selectedHour = val;
                        setHandRotation((i - 12) * 30, 42);
                        setTimeout(() => {
                            currentClockMode = 'minutes';
                            updateClockPickerUI();
                        }, 200);
                    });
                    
                    container.appendChild(numDiv);
                }

                if (selectedHour >= 13 || selectedHour === 0) {
                    const angleHour = selectedHour === 0 ? 12 : selectedHour - 12;
                    setHandRotation(angleHour * 30, 42);
                } else {
                    setHandRotation(selectedHour * 30, 72);
                }
            } else {
                for (let i = 0; i < 60; i += 5) {
                    const angle = (i * 6 - 90) * (Math.PI / 180);
                    const x = centerX + radius * Math.cos(angle);
                    const y = centerY + radius * Math.sin(angle);
                    
                    const isSelected = Math.round(selectedMinute / 5) * 5 === i;
                    const numDiv = document.createElement('div');
                    numDiv.className = `absolute w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold cursor-pointer transition-colors ${
                        isSelected
                            ? 'bg-blue-600 text-white z-20' 
                            : 'text-slate-700 hover:bg-slate-200 z-10'
                    }`;
                    numDiv.style.left = `${x - 16}px`;
                    numDiv.style.top = `${y - 16}px`;
                    numDiv.textContent = String(i).padStart(2, '0');
                    
                    numDiv.addEventListener('click', (e) => {
                        e.stopPropagation();
                        selectedMinute = i;
                        setHandRotation(i * 6, 72);
                    });
                    
                    container.appendChild(numDiv);
                }
                setHandRotation(selectedMinute * 6, 72);
            }
        }

        function setHandRotation(degrees, length = 72) {
            const hand = document.getElementById('clock-hand');
            hand.style.transform = `rotate(${degrees}deg)`;
            hand.style.height = `${length}px`;
        }

        function toggleSidebar() {
            const isCollapsed = document.documentElement.classList.toggle('sidebar-collapsed');
            localStorage.setItem("sidebar-collapsed", isCollapsed ? "true" : "false");
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            const isOpen = sidebar.classList.contains("translate-x-0");

            if (isOpen) {
                sidebar.classList.remove("translate-x-0");
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
            } else {
                sidebar.classList.remove("-translate-x-full");
                sidebar.classList.add("translate-x-0");
                overlay.classList.remove("hidden");
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.body.classList.remove('preload');
            }, 10);
            
            // Trigger PHP session alerts to toast
            @if(session('success'))
                showToast("{{ session('success') }}", "success");
            @endif
            @if(session('error'))
                showToast("{{ session('error') }}", "error");
            @endif
            @if($errors->any())
                showToast("{{ $errors->first() }}", "error");
            @endif
            
            // Switch clock picker mode on header clicks
            document.getElementById('clock-display-hours').addEventListener('click', () => {
                currentClockMode = 'hours';
                updateClockPickerUI();
            });
            document.getElementById('clock-display-minutes').addEventListener('click', () => {
                currentClockMode = 'minutes';
                updateClockPickerUI();
            });

            // Bind click listener on all data-clocklet elements to trigger our custom analog clock picker instead
            document.addEventListener('focusin', (e) => {
                if (e.target.matches('input[data-clocklet]')) {
                    e.target.blur(); // prevent keyboard focus
                    openClockPicker(e.target);
                }
            });
            document.addEventListener('click', (e) => {
                if (e.target.matches('input[data-clocklet]')) {
                    e.preventDefault();
                    e.stopPropagation();
                    openClockPicker(e.target);
                }
            });

            // Global Input Min/Max Validation Listener
            document.addEventListener('change', function(e) {
                if (e.target.matches('input[type="number"], input[min], input[max]')) {
                    const input = e.target;
                    const val = parseFloat(input.value);
                    if (isNaN(val)) return;

                    const min = parseFloat(input.getAttribute('min'));
                    const max = parseFloat(input.getAttribute('max'));
                    const labelCell = input.closest('tr')?.querySelector('.label-cell');
                    const fieldName = labelCell ? labelCell.textContent.replace(/[*:]/g, '').trim() : input.name;

                    if (!isNaN(min) && val < min) {
                        showToast(`Nilai ${fieldName} tidak boleh kurang dari ${min}`, 'error');
                        input.value = min;
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    } else if (!isNaN(max) && val > max) {
                        showToast(`Nilai ${fieldName} tidak boleh lebih dari ${max}`, 'error');
                        input.value = max;
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/clocklet@0.3.0/js/clocklet.min.js"></script>
    @yield('scripts')
</body>

</html>
