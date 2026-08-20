import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('value="{{ $persetujuan- readonly class="bg-gray-100">alternative_treatment_detail }}"', 'value="{{ $persetujuan->alternative_treatment_detail }}" readonly class="bg-gray-100"')

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
