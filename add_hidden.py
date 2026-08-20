import re
with open('resources/views/persetujuan_tindakan/edit.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Add hidden for alternative_treatment right after the none radio
hidden = """
                                @if(request('mode') == 'patient')
                                    <input type="hidden" name="alternative_treatment" value="{{ $persetujuan->alternative_treatment }}">
                                @endif
"""
content = re.sub(
    r'(<input type="radio" name="alternative_treatment" value="none"[^>]+/>)',
    r'\1' + hidden,
    content
)

with open('resources/views/persetujuan_tindakan/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
