import re
with open('resources/views/persetujuan_tindakan/create.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Add ID to doctor canvas
content = re.sub(
    r'<canvas\s+class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>',
    r'<canvas id="doctor_signature_canvas" class="signature-pad w-full h-full bg-transparent absolute top-0 left-0"></canvas>',
    content, count=1
)
content = re.sub(
    r'<input type="hidden" name="signature\[\]" class="signature-input">',
    r'<input type="hidden" name="signature[]" id="doctor_signature_input" class="signature-input">',
    content, count=1
)

with open('resources/views/persetujuan_tindakan/create.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
