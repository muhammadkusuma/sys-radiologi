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

# Replace 'old(...)' logic with '$persetujuan->...'
# But leave the ones we will handle specifically
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

content = content.replace(
    r"{{ isset($patient) && $patient->id == $p->id ? 'selected' : '' }}",
    r"{{ $persetujuan->patient_id == $p->id ? 'selected' : '' }}"
)

content = content.replace(
    "@selected(old('doctor') == $doctor->id)",
    "@selected($persetujuan->doctor == $doctor->id)"
)

# Patient and doctor disabled if mode == patient
content = content.replace(
    '<select id="patient_id" name="patient_id" required',
    '<select id="patient_id" name="patient_id" required {{ request(\'mode\') == \'patient\' ? \'disabled\' : \'\' }}'
)
content = content.replace(
    '<select id="doctor" name="doctor"',
    '<select id="doctor" name="doctor" {{ request(\'mode\') == \'patient\' ? \'disabled\' : \'\' }}'
)

# If mode == patient, we need hidden inputs for the disabled selects
content = content.replace(
    '{{-- ===================================================== --}}',
    '{{-- ===================================================== --}}\n@if(request(\'mode\') == \'patient\')\n<input type="hidden" name="patient_id" value="{{ $persetujuan->patient_id }}">\n<input type="hidden" name="doctor" value="{{ $persetujuan->doctor }}">\n@endif\n',
    1
)

# Textareas: diagnosis, planned_procedure
content = content.replace(
    '{{ old(\'diagnosis\') }}',
    '{{ $persetujuan->diagnosis }}'
)
content = content.replace(
    '<textarea name="diagnosis" rows="4" placeholder="Tuliskan diagnosis kerja dan diagnosis banding..."',
    '<textarea name="diagnosis" rows="4" placeholder="Tuliskan diagnosis kerja dan diagnosis banding..." {{ request(\'mode\') == \'patient\' ? \'readonly\' : \'\' }}'
)

content = content.replace(
    '{{ old(\'planned_procedure\') }}',
    '{{ $persetujuan->planned_procedure }}'
)
content = content.replace(
    '<textarea name="planned_procedure" rows="4" placeholder="Tuliskan kondisi pasien saat ini..."',
    '<textarea name="planned_procedure" rows="4" placeholder="Tuliskan kondisi pasien saat ini..." {{ request(\'mode\') == \'patient\' ? \'readonly\' : \'\' }}'
)

# alternative_treatment_detail
content = content.replace(
    'value="{{ old(\'alternative_treatment_detail\') }}"',
    'value="{{ $persetujuan->alternative_treatment_detail }}" {{ request(\'mode\') == \'patient\' ? \'readonly\' : \'\' }}'
)

# alternative_treatment radio
content = content.replace(
    "{{ old('alternative_treatment') == 'none' ? 'checked' : '' }}",
    "{{ $persetujuan->alternative_treatment == 'none' ? 'checked' : '' }} {{ request('mode') == 'patient' ? 'disabled' : '' }}"
)
content = content.replace(
    "{{ old('alternative_treatment') == 'yes' ? 'checked' : '' }}",
    "{{ $persetujuan->alternative_treatment == 'yes' ? 'checked' : '' }} {{ request('mode') == 'patient' ? 'disabled' : '' }}"
)

# add hidden for alternative_treatment
content = content.replace(
    '<div class="flex items-center gap-6 mt-2">',
    '<div class="flex items-center gap-6 mt-2">\n                                        @if(request(\'mode\') == \'patient\')<input type="hidden" name="alternative_treatment" value="{{ $persetujuan->alternative_treatment }}">@endif'
)

# Checkboxes
# Since we fixed create.blade.php already, checkboxes HAVE names now!
names = [
    'check_received_info',
    'check_understand_necessity',
    'check_given_opportunity',
    'check_realize_no_guarantee',
    'check_realize_not_exact_science'
]
for name in names:
    content = content.replace(
        f'<input type="checkbox" name="{name}"',
        f'<input type="checkbox" name="{name}" {{{{ $persetujuan->{name} ? \'checked\' : \'\' }}}}'
    )


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
