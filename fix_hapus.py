import re
with open('resources/views/persetujuan_tindakan/index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = re.sub(r'\}"></a>', r'}">Hapus</a>', content)

with open('resources/views/persetujuan_tindakan/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
