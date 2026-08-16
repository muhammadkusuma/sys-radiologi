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
            'signature_file' => 'required|image|mimes:png|max:1024',
        ]);

        $user = Auth::user();

        if ($request->hasFile('signature_file')) {
            $file = $request->file('signature_file');
            $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));
            $user->update([
                'signature' => $base64
            ]);
        }

        return redirect()->route('signatures.index')->with('success', 'Tanda tangan PNG berhasil diunggah.');
    }
}
