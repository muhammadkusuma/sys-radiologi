import re

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Make diagnosis textarea readonly
content = re.sub(
    r'<textarea name="diagnosis"([^>]+)>',
    r'<textarea name="diagnosis"\1 readonly class="bg-gray-100">',
    content
)

# Make planned_procedure textarea readonly
content = re.sub(
    r'<textarea name="planned_procedure"([^>]+)>',
    r'<textarea name="planned_procedure"\1 readonly class="bg-gray-100">',
    content
)

# Make alternative_treatment_detail readonly
content = re.sub(
    r'<input type="text" name="alternative_treatment_detail"([^>]+)>',
    r'<input type="text" name="alternative_treatment_detail"\1 readonly class="bg-gray-100">',
    content
)

# Make alternative_treatment radio buttons disabled
content = re.sub(
    r'<input type="radio" name="alternative_treatment"([^>]+)>',
    r'<input type="radio" name="alternative_treatment"\1 disabled>',
    content
)
# Add hidden input for alternative_treatment right after the first radio
content = re.sub(
    r'(<input type="radio" name="alternative_treatment"[^>]+disabled>)',
    r'\1\n<input type="hidden" name="alternative_treatment" value="{{ $persetujuan->alternative_treatment }}">',
    content, count=1
)

# Change old('alternative_treatment') to $persetujuan->...
content = re.sub(
    r"\{\{\s*old\('alternative_treatment'\)\s*==\s*'none'\s*\?\s*'checked'\s*:\s*''\s*\}\}",
    r"{{ $persetujuan->alternative_treatment == 'none' ? 'checked' : '' }}",
    content
)
content = re.sub(
    r"\{\{\s*old\('alternative_treatment'\)\s*==\s*'yes'\s*\?\s*'checked'\s*:\s*''\s*\}\}",
    r"{{ $persetujuan->alternative_treatment == 'yes' ? 'checked' : '' }}",
    content
)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
