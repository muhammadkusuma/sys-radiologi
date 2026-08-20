import re

with open('resources/views/persetujuan_tindakan/create.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

names = [
    'check_received_info',
    'check_understand_necessity',
    'check_given_opportunity',
    'check_realize_no_guarantee',
    'check_realize_not_exact_science'
]

# Find the 5 checkboxes that lack names in the final section
# They have class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
for name in names:
    content = re.sub(r'(<input type="checkbox"[^>]*?class="mt-1 h-5 w-5 rounded[^"]*"\n\s*required>)',
                     rf'<input type="checkbox" name="{name}"\n                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"\n                                required>', content, count=1)

with open('resources/views/persetujuan_tindakan/create.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
