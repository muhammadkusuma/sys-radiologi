import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

mode_check = "{{ request('mode') == 'patient' ? 'readonly' : '' }}"
mode_check_disabled = "{{ request('mode') == 'patient' ? 'disabled' : '' }}"

# diagnosis
content = re.sub(
    r'<textarea name="diagnosis"(.*?)>{{ \$persetujuan->diagnosis }}</textarea>',
    r'<textarea name="diagnosis"\1 ' + mode_check + r' class="{{ request(\'mode\') == \'patient\' ? \'bg-gray-100\' : \'\' }}">{{ $persetujuan->diagnosis }}</textarea>',
    content, flags=re.DOTALL
)

# planned_procedure
content = re.sub(
    r'<textarea name="planned_procedure"(.*?)>{{ \$persetujuan->planned_procedure }}</textarea>',
    r'<textarea name="planned_procedure"\1 ' + mode_check + r' class="{{ request(\'mode\') == \'patient\' ? \'bg-gray-100\' : \'\' }}">{{ $persetujuan->planned_procedure }}</textarea>',
    content, flags=re.DOTALL
)

# alternative_treatment_detail
content = re.sub(
    r'value="\{\{ \$persetujuan->alternative_treatment_detail \}\}"',
    r'value="{{ $persetujuan->alternative_treatment_detail }}" ' + mode_check + r' class="{{ request(\'mode\') == \'patient\' ? \'bg-gray-100\' : \'\' }}"',
    content
)

# alternative_treatment radios
content = re.sub(
    r'(<input type="radio" name="alternative_treatment" value="none"[^>]+)>',
    r'\1 ' + mode_check_disabled + '>',
    content
)
content = re.sub(
    r'(<input type="radio" name="alternative_treatment" value="yes"[^>]+)>',
    r'\1 ' + mode_check_disabled + '>',
    content
)

# Insert hidden input for alternative_treatment if mode is patient
# We can just put it right after the 'yes' radio button
hidden_input = """
                                    @if(request('mode') == 'patient')
                                        <input type="hidden" name="alternative_treatment" value="{{ $persetujuan->alternative_treatment }}">
                                    @endif
"""
content = re.sub(
    r'(<input type="radio" name="alternative_treatment" value="yes"[^>]+>)',
    r'\1' + hidden_input,
    content
)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
