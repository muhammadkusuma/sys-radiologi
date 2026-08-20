import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("{{ route(\\'persetujuan-tindakan.update\\', $persetujuan->id) }}", "{{ route('persetujuan-tindakan.update', $persetujuan->id) }}")
content = content.replace("@method(PUT)", "@method('PUT')")

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
