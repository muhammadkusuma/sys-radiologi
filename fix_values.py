import re

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Helper to add value to inputs if not present
def add_value(name, is_textarea=False):
    global content
    if is_textarea:
        # e.g., <textarea name="wali_alamat" ...></textarea>
        content = re.sub(
            rf'(<textarea[^>]*name="{name}"[^>]*>)(\s*)(</textarea>)',
            rf'\1{{{{ $persetujuan->{name} }}}}\3',
            content
        )
    else:
        # <input ... name="name" ...>
        # make sure it doesn't already have value=
        content = re.sub(
            rf'(<input[^>]*name="{name}"(?![^>]*value=)[^>]*)>',
            rf'\1 value="{{{{ $persetujuan->{name} }}}}">',
            content
        )

# text inputs
add_value('other_relationship')
add_value('wali_nama')
add_value('wali_umur')
add_value('wali_identitas')
add_value('wali_hubungan_lainnya')
add_value('yang_menyatakan_nama')
add_value('saksi_1_nama')
add_value('saksi_2_nama')

# textareas
add_value('wali_alamat', is_textarea=True)
# Wait, let's check if wali_alamat is textarea
if '<textarea name="wali_alamat"' not in content:
    add_value('wali_alamat', is_textarea=False)

# Selects (wali_jk, wali_jenis_identitas, wali_hubungan)
content = re.sub(r'(<option value="L")(\s*>)', r'\1 {{ $persetujuan->wali_jk == "L" ? "selected" : "" }}\2', content)
content = re.sub(r'(<option value="P")(\s*>)', r'\1 {{ $persetujuan->wali_jk == "P" ? "selected" : "" }}\2', content)

content = re.sub(r'(<option value="KTP")(\s*>)', r'\1 {{ $persetujuan->wali_jenis_identitas == "KTP" ? "selected" : "" }}\2', content)
content = re.sub(r'(<option value="SIM")(\s*>)', r'\1 {{ $persetujuan->wali_jenis_identitas == "SIM" ? "selected" : "" }}\2', content)
content = re.sub(r'(<option value="PASPOR")(\s*>)', r'\1 {{ $persetujuan->wali_jenis_identitas == "PASPOR" ? "selected" : "" }}\2', content)

content = re.sub(r'(<select name="wali_hubungan"[^>]*>[\s\S]*?<option value="suami")(>)', r'\1 {{ $persetujuan->wali_hubungan == "suami" ? "selected" : "" }}\2', content)
content = re.sub(r'(<select name="wali_hubungan"[^>]*>[\s\S]*?<option value="istri")(>)', r'\1 {{ $persetujuan->wali_hubungan == "istri" ? "selected" : "" }}\2', content)
content = re.sub(r'(<select name="wali_hubungan"[^>]*>[\s\S]*?<option value="ayah")(>)', r'\1 {{ $persetujuan->wali_hubungan == "ayah" ? "selected" : "" }}\2', content)
content = re.sub(r'(<select name="wali_hubungan"[^>]*>[\s\S]*?<option value="ibu")(>)', r'\1 {{ $persetujuan->wali_hubungan == "ibu" ? "selected" : "" }}\2', content)
content = re.sub(r'(<select name="wali_hubungan"[^>]*>[\s\S]*?<option value="anak")(>)', r'\1 {{ $persetujuan->wali_hubungan == "anak" ? "selected" : "" }}\2', content)
content = re.sub(r'(<select name="wali_hubungan"[^>]*>[\s\S]*?<option value="lainnya")(>)', r'\1 {{ $persetujuan->wali_hubungan == "lainnya" ? "selected" : "" }}\2', content)

# pernyataan_tindakan radio buttons
content = re.sub(
    r'(<input type="radio" name="pernyataan_tindakan" value="SETUJU")(>)',
    r'\1 {{ $persetujuan->pernyataan_tindakan == "SETUJU" ? "checked" : "" }}\2',
    content
)
content = re.sub(
    r'(<input type="radio" name="pernyataan_tindakan" value="TIDAK SETUJU")(>)',
    r'\1 {{ $persetujuan->pernyataan_tindakan == "TIDAK SETUJU" ? "checked" : "" }}\2',
    content
)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
