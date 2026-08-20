import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Remove readonly from diagnosis
content = content.replace('readonly class="bg-gray-100">{{ $persetujuan->diagnosis }}</textarea>', '>{{ $persetujuan->diagnosis }}</textarea>')

# Remove readonly from planned_procedure
content = content.replace('readonly class="bg-gray-100">{{ $persetujuan->planned_procedure }}</textarea>', '>{{ $persetujuan->planned_procedure }}</textarea>')

# Remove readonly from alternative_treatment_detail
content = content.replace('readonly class="bg-gray-100"', '')

# Remove disabled from alternative_treatment radios
content = content.replace('<input type="radio" name="alternative_treatment" value="none"\n                                        {{ $persetujuan->alternative_treatment == \'none\' ? \'checked\' : \'\' }} disabled>', '<input type="radio" name="alternative_treatment" value="none"\n                                        {{ $persetujuan->alternative_treatment == \'none\' ? \'checked\' : \'\' }}>')

content = content.replace('<input type="radio" name="alternative_treatment" value="yes"\n                                        {{ $persetujuan->alternative_treatment == \'yes\' ? \'checked\' : \'\' }} disabled>', '<input type="radio" name="alternative_treatment" value="yes"\n                                        {{ $persetujuan->alternative_treatment == \'yes\' ? \'checked\' : \'\' }}>')

# Remove the hidden input for alternative_treatment that we added
content = re.sub(
    r'<input type="hidden" name="alternative_treatment" value="\{\{ \$persetujuan->alternative_treatment \}\}">',
    '',
    content
)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
