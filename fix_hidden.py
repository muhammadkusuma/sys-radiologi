import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace(
    '<input type="hidden" name="doctor" value="{{ $persetujuan->doctor }}">',
    '<input type="hidden" name="doctor" value="{{ $persetujuan->doctor }}">\n<input type="hidden" name="alternative_treatment" value="{{ $persetujuan->alternative_treatment }}">'
)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
