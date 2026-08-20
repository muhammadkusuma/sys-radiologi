import re

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update Title
content = content.replace('Isi Form Persetujuan Medis', 'Edit Form Persetujuan Medis')

# 2. Update Form Action and Method
content = re.sub(
    r'<form method="POST" action="\{\{ route\(\'persetujuan-tindakan\.store\'\) \}\}">\s*@csrf',
    r'<form method="POST" action="{{ route(\'persetujuan-tindakan.update\', $persetujuan->id) }}">\n            @csrf\n            @method(\'PUT\')',
    content
)

# 3. Disable patient select
content = re.sub(
    r'<select id="patient_id" name="patient_id" required',
    r'<select id="patient_id" name="patient_id" required disabled\n                                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">',
    content
)
# We need a hidden input for patient_id since disabled selects don't submit their value
content = content.replace(
    '<select id="patient_id" name="patient_id" required disabled',
    '<input type="hidden" name="patient_id" value="{{ $persetujuan->patient_id }}">\n                                <select id="patient_id" disabled'
)

# Replace old('patient_id') logic (though create didn't use old for patient_id, it used isset($patient))
content = content.replace(
    r"{{ isset($patient) && $patient->id == $p->id ? 'selected' : '' }}",
    r"{{ $persetujuan->patient_id == $p->id ? 'selected' : '' }}"
)

# 4. Disable doctor select
content = re.sub(
    r'<select id="doctor" name="doctor"',
    r'<input type="hidden" name="doctor" value="{{ $persetujuan->doctor }}">\n                                <select id="doctor" disabled',
    content
)
content = content.replace(
    "@selected(old('doctor') == $doctor->id)",
    "@selected($persetujuan->doctor == $doctor->id)"
)

# 5. Disable diagnosis, planned_procedure, alternative_treatment, alternative_treatment_detail
for field in ['diagnosis', 'planned_procedure']:
    content = content.replace(
        '<textarea id="' + field + '" name="' + field + '" required',
        '<textarea id="' + field + '" name="' + field + '" required readonly class="bg-gray-100"'
    )
    content = content.replace(
        '{{ old(\'' + field + '\') }}</textarea>',
        '{{ $persetujuan->' + field + ' }}</textarea>'
    )

field = 'alternative_treatment_detail'
content = content.replace(
    '<input type="text" id="' + field + '" name="' + field + '"',
    '<input type="text" id="' + field + '" name="' + field + '" readonly class="bg-gray-100"'
)
content = content.replace(
    'value="{{ old(\'' + field + '\') }}"',
    'value="{{ $persetujuan->' + field + ' }}"'
)

# radio buttons for alternative_treatment
content = content.replace(
    '<input type="radio" name="alternative_treatment" value="none" @checked(old(\'alternative_treatment\') === \'none\')',
    '<input type="radio" name="alternative_treatment" value="none" @checked($persetujuan->alternative_treatment === \'none\') disabled'
)
content = content.replace(
    '<input type="radio" name="alternative_treatment" value="yes" @checked(old(\'alternative_treatment\') === \'yes\')',
    '<input type="radio" name="alternative_treatment" value="yes" @checked($persetujuan->alternative_treatment === \'yes\') disabled'
)

# Add hidden input for alternative_treatment since radio buttons are disabled
# I'll just append it to the wrapper div
content = content.replace(
    '<div class="flex items-center gap-6 mt-2">',
    '<div class="flex items-center gap-6 mt-2">\n                                        <input type="hidden" name="alternative_treatment" value="{{ $persetujuan->alternative_treatment }}">'
)

# Replace other old(...) with $persetujuan->...
content = re.sub(r"old\('recipient_name'\)", r"$persetujuan->recipient_name", content)
content = re.sub(r"old\('relationship'\)", r"$persetujuan->relationship", content)
content = re.sub(r"old\('other_relationship'\)", r"$persetujuan->other_relationship", content)

content = re.sub(r"old\('wali_nama'\)", r"$persetujuan->wali_nama", content)
content = re.sub(r"old\('wali_umur'\)", r"$persetujuan->wali_umur", content)
content = re.sub(r"old\('wali_jk'\)", r"$persetujuan->wali_jk", content)
content = re.sub(r"old\('wali_alamat'\)", r"$persetujuan->wali_alamat", content)
content = re.sub(r"old\('wali_jenis_identitas'\)", r"$persetujuan->wali_jenis_identitas", content)
content = re.sub(r"old\('wali_identitas'\)", r"$persetujuan->wali_identitas", content)
content = re.sub(r"old\('wali_hubungan'\)", r"$persetujuan->wali_hubungan", content)
content = re.sub(r"old\('wali_hubungan_lainnya'\)", r"$persetujuan->wali_hubungan_lainnya", content)

content = re.sub(r"old\('yang_menyatakan_nama'\)", r"$persetujuan->yang_menyatakan_nama", content)
content = re.sub(r"old\('saksi_1_nama'\)", r"$persetujuan->saksi_1_nama", content)
content = re.sub(r"old\('saksi_2_nama'\)", r"$persetujuan->saksi_2_nama", content)

content = re.sub(r"old\('tanggal_persetujuan'\)", r"$persetujuan->tanggal_persetujuan?->format('Y-m-d')", content)
content = re.sub(r"old\('jam_persetujuan'\)", r"$persetujuan->jam_persetujuan", content)

content = re.sub(r"old\('pernyataan_tindakan'\) === 'SETUJU'", r"$persetujuan->pernyataan_tindakan === 'SETUJU'", content)
content = re.sub(r"old\('pernyataan_tindakan'\) === 'TIDAK SETUJU'", r"$persetujuan->pernyataan_tindakan === 'TIDAK SETUJU'", content)

content = re.sub(r'<input type="checkbox" name="check_received_info"\s*class="', r'<input type="checkbox" name="check_received_info" {{ $persetujuan->check_received_info ? \'checked\' : \'\' }}\n                                class="', content)
content = re.sub(r'<input type="checkbox" name="check_understand_necessity"\s*class="', r'<input type="checkbox" name="check_understand_necessity" {{ $persetujuan->check_understand_necessity ? \'checked\' : \'\' }}\n                                class="', content)
content = re.sub(r'<input type="checkbox" name="check_given_opportunity"\s*class="', r'<input type="checkbox" name="check_given_opportunity" {{ $persetujuan->check_given_opportunity ? \'checked\' : \'\' }}\n                                class="', content)
content = re.sub(r'<input type="checkbox" name="check_realize_no_guarantee"\s*class="', r'<input type="checkbox" name="check_realize_no_guarantee" {{ $persetujuan->check_realize_no_guarantee ? \'checked\' : \'\' }}\n                                class="', content)
content = re.sub(r'<input type="checkbox" name="check_realize_not_exact_science"\s*class="', r'<input type="checkbox" name="check_realize_not_exact_science" {{ $persetujuan->check_realize_not_exact_science ? \'checked\' : \'\' }}\n                                class="', content)

# 6. Preload signatures. Since the array is stored as JSON in DB, we can pass it to JS.
# We will inject a script block at the end of the file.
script_injection = """
            // Preload signatures
            const signatures = @json($persetujuan->signature ?? []);
            if(signatures && signatures.length > 0) {
                const inputs = document.querySelectorAll('.signature-input');
                const canvases = document.querySelectorAll('.signature-pad');
                
                inputs.forEach((input, index) => {
                    if (signatures[index]) {
                        input.value = signatures[index];
                        const canvas = canvases[index];
                        if (canvas) {
                            const ctx = canvas.getContext('2d');
                            const img = new Image();
                            img.onload = function() {
                                const hRatio = canvas.width / img.width;
                                const vRatio = canvas.height / img.height;
                                const ratio  = Math.min(hRatio, vRatio);
                                const centerShift_x = (canvas.width - img.width*ratio) / 2;
                                const centerShift_y = (canvas.height - img.height*ratio) / 2;
                                ctx.drawImage(img, 0,0, img.width, img.height, centerShift_x, centerShift_y, img.width*ratio, img.height*ratio);
                                
                                // Hide clear button if it's the doctor's signature
                                if (index === 0) {
                                    const clearBtn = document.getElementById('doctor_signature_clear_btn');
                                    if(clearBtn) clearBtn.style.display = 'none';
                                }
                            }
                            img.src = signatures[index];
                        }
                    }
                });
            }
"""

content = content.replace("        });\n    </script>", script_injection + "\n        });\n    </script>")

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
