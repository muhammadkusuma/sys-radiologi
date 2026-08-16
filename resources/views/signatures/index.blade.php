@extends('layouts.app')

@section('title', 'Master Tanda Tangan')

@section('content')
<div class="max-w-3xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Master Tanda Tangan (TTD)</h1>
        <p class="text-sm text-slate-500">Unggah tanda tangan transparan Anda (.png) untuk digunakan secara otomatis pada dokumen asesmen.</p>
    </div>



    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 p-6 space-y-6">
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

        <!-- Tab Selector -->
        <div class="flex border-b border-slate-200 mb-4 no-print">
            <button type="button" onclick="setMode('upload')" id="tab-upload" class="px-4 py-2 text-sm font-bold border-b-2 border-blue-600 text-blue-600 focus:outline-none transition-all cursor-pointer">Unggah File</button>
            <button type="button" onclick="setMode('draw')" id="tab-draw" class="px-4 py-2 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 focus:outline-none transition-all cursor-pointer">Gambar Manual</button>
        </div>

        <form action="{{ route('signatures.store') }}" method="POST" enctype="multipart/form-data" id="signature-form" class="space-y-4">
            @csrf
            <input type="hidden" name="signature_base64" id="signature_base64">

            <!-- UPLOAD MODE -->
            <div id="container-upload" class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Unggah Gambar TTD Baru (PNG transparan disarankan)</label>
                <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <label for="signature_file" class="relative cursor-pointer bg-white rounded-md font-semibold text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Pilih file gambar</span>
                                <input id="signature_file" name="signature_file" type="file" accept="image/png" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-slate-500">Format PNG saja hingga ukuran 1MB</p>
                    </div>
                </div>
                <div id="file-name-preview" class="text-sm font-semibold text-blue-600 mt-2 text-center hidden"></div>
            </div>

            <!-- DRAW MODE -->
            <div id="container-draw" class="space-y-2 hidden">
                <div class="flex justify-between items-center">
                    <label class="block text-sm font-semibold text-slate-700">Gambar Tanda Tangan Anda pada Kanvas di bawah</label>
                    <button type="button" onclick="clearCanvas()" class="text-xs font-semibold text-red-650 hover:text-red-700 focus:outline-none cursor-pointer">Hapus Coretan</button>
                </div>
                <div class="border border-slate-300 rounded-xl overflow-hidden bg-slate-50">
                    <canvas id="signature-pad" class="w-full h-48 cursor-crosshair touch-none bg-slate-50"></canvas>
                </div>
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
    let activeMode = 'upload';
    
    function setMode(mode) {
        activeMode = mode;
        const tabUpload = document.getElementById('tab-upload');
        const tabDraw = document.getElementById('tab-draw');
        const containerUpload = document.getElementById('container-upload');
        const containerDraw = document.getElementById('container-draw');
        const fileInput = document.getElementById('signature_file');

        if (mode === 'upload') {
            tabUpload.className = "px-4 py-2 text-sm font-bold border-b-2 border-blue-600 text-blue-600 focus:outline-none transition-all cursor-pointer";
            tabDraw.className = "px-4 py-2 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 focus:outline-none transition-all cursor-pointer";
            containerUpload.classList.remove('hidden');
            containerDraw.classList.add('hidden');
            fileInput.required = true;
        } else {
            tabDraw.className = "px-4 py-2 text-sm font-bold border-b-2 border-blue-600 text-blue-600 focus:outline-none transition-all cursor-pointer";
            tabUpload.className = "px-4 py-2 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 focus:outline-none transition-all cursor-pointer";
            containerDraw.classList.remove('hidden');
            containerUpload.classList.add('hidden');
            fileInput.required = false;
            // Initialize canvas size when switching to draw mode
            setTimeout(resizeCanvas, 50);
        }
    }

    // Set initial mode
    document.addEventListener('DOMContentLoaded', () => {
        setMode('upload');
    });

    // File selection preview
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

    // Canvas drawing logic
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;
    let hasDrawn = false;

    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        // Keep drawing content if already drawn
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = canvas.width;
        tempCanvas.height = canvas.height;
        const tempCtx = tempCanvas.getContext('2d');
        tempCtx.drawImage(canvas, 0, 0);

        canvas.width = rect.width;
        canvas.height = rect.height;
        
        // Restore content
        ctx.drawImage(tempCanvas, 0, 0);

        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#1e293b'; // Slate-800
    }

    function getMousePos(canvasDom, event) {
        const rect = canvasDom.getBoundingClientRect();
        const clientX = event.touches ? event.touches[0].clientX : event.clientX;
        const clientY = event.touches ? event.touches[0].clientY : event.clientY;
        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);

    canvas.addEventListener('touchstart', (e) => {
        if (e.target === canvas) e.preventDefault();
        startDrawing(e);
    });
    canvas.addEventListener('touchmove', (e) => {
        if (e.target === canvas) e.preventDefault();
        draw(e);
    });
    canvas.addEventListener('touchend', (e) => {
        if (e.target === canvas) e.preventDefault();
        stopDrawing(e);
    });

    let lastPos = null;

    function startDrawing(e) {
        drawing = true;
        hasDrawn = true;
        lastPos = getMousePos(canvas, e);
        ctx.beginPath();
        ctx.moveTo(lastPos.x, lastPos.y);
    }

    function draw(e) {
        if (!drawing) return;
        const pos = getMousePos(canvas, e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastPos = pos;
    }

    function stopDrawing() {
        drawing = false;
        lastPos = null;
    }

    function clearCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasDrawn = false;
        resizeCanvas();
    }

    // Form Submission check
    document.getElementById('signature-form').addEventListener('submit', function(e) {
        if (activeMode === 'draw') {
            if (!hasDrawn) {
                e.preventDefault();
                showToast('Silakan gambar tanda tangan Anda di kanvas terlebih dahulu.', 'error');
                return;
            }
            // Set base64 string to hidden input
            const dataUrl = canvas.toDataURL('image/png');
            document.getElementById('signature_base64').value = dataUrl;
        }
    });
</script>
@endsection
