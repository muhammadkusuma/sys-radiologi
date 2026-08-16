<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignatureController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('signatures.index', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'signature_file' => 'nullable|image|mimes:png|max:1024',
            'signature_base64' => 'nullable|string',
        ]);

        if (!$request->hasFile('signature_file') && !$request->filled('signature_base64')) {
            return redirect()->route('signatures.index')->with('error', 'Silakan unggah file gambar atau gambar tanda tangan secara manual.');
        }

        $user = Auth::user();

        if ($request->hasFile('signature_file')) {
            $file = $request->file('signature_file');
            $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));
            $user->update([
                'signature' => $base64
            ]);
        } elseif ($request->filled('signature_base64')) {
            $user->update([
                'signature' => $request->signature_base64
            ]);
        }

        return redirect()->route('signatures.index')->with('success', 'Tanda tangan berhasil disimpan.');
    }
}
