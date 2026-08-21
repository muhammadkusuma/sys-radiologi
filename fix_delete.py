import re

with open('resources/views/persetujuan_tindakan/index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

hidden_form = """</a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('persetujuan-tindakan.destroy', $item->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>"""

content = re.sub(r'Hapus</a>', hidden_form, content)

with open('resources/views/persetujuan_tindakan/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
