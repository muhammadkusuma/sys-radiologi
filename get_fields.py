import re
with open('resources/views/persetujuan_tindakan/create.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

names = re.findall(r'name="([^"]+)"', content)
print("Fields:")
for n in sorted(list(set(names))):
    print(n)
