import re

def fix_checkboxes(file_path, is_edit=False):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # The 5 checkboxes
    names = [
        'check_received_info',
        'check_understand_necessity',
        'check_given_opportunity',
        'check_realize_no_guarantee',
        'check_realize_not_exact_science'
    ]
    
    # We will just replace all 5 checkboxes directly.
    # The first one might have name="check_realize_not_exact_science" right now.
    
    # Remove any existing names from these checkboxes first
    content = re.sub(
        r'<input type="checkbox" name="check_[^"]+"(\s*\{\{[^\}]+\}\})?\s*class="mt-1 h-5 w-5 rounded',
        r'<input type="checkbox"\n                                class="mt-1 h-5 w-5 rounded',
        content
    )
    
    # Now all 5 checkboxes are identical up to the class.
    # We want to find them and replace them one by one.
    parts = content.split('<input type="checkbox"\n                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>')
    
    if len(parts) == 6:
        new_content = parts[0]
        for i, name in enumerate(names):
            if is_edit:
                checked_expr = f"{{{{ $persetujuan->{name} ? 'checked' : '' }}}}"
                new_content += f'<input type="checkbox" name="{name}" {checked_expr}\n                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>'
            else:
                new_content += f'<input type="checkbox" name="{name}"\n                                class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>'
            new_content += parts[i+1]
        
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Fixed {file_path}")
    else:
        print(f"Could not find 5 checkboxes in {file_path}. Found {len(parts)-1}")
        
fix_checkboxes('resources/views/persetujuan_tindakan/create.blade.php', False)
fix_checkboxes('resources/views/persetujuan_tindakan/edit.blade.php', True)
