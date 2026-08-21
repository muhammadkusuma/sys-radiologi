import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = re.sub(r'(<option value="SETUJU")(\s*>)', r'\1 {{ $persetujuan->pernyataan_tindakan == "SETUJU" ? "selected" : "" }}\2', content)
content = re.sub(r'(<option value="TIDAK SETUJU")(\s*>)', r'\1 {{ $persetujuan->pernyataan_tindakan == "TIDAK SETUJU" ? "selected" : "" }}\2', content)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
