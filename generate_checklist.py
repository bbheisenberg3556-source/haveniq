import pandas as pd
import re

df = pd.read_excel('/Users/hussainkhalil/Desktop/ai-project/Living Room Generation Prompts.xlsx')
items = df['Living Room Item'].dropna().tolist()

categories = []
current_category = None
current_field = None

text_keywords = ["Insert ", "Describe", "Insert color", "Insert number"]
checkbox_keywords = ["decorations", "items on", "other materials", "signs or markings", "glass condition"]

current_condition = None

for item in items:
    item_str = str(item).strip()
    
    if item_str.startswith('o ') or item_str.startswith('o\t') or item_str.startswith('\to '):
        # Safely remove leading bullet
        option = re.sub(r'^\s*o[\s\t]+', '', item_str).strip()
        
        # Clean up instructional text
        option = re.sub(r'\s*\(move to next prompt\)', '', option, flags=re.IGNORECASE)
        option = re.sub(r'\s*\(choose all that apply below\)', '', option, flags=re.IGNORECASE)
        option = re.sub(r'\s*\(Enable window prompts\)', '', option, flags=re.IGNORECASE)
        option = re.sub(r'\s*\(Enable door prompts\)', '', option, flags=re.IGNORECASE)
        option = re.sub(r'\s*\(follow prompts below\)', '', option, flags=re.IGNORECASE)
        option = re.sub(r'\s*\(Complete prompts for.*?\)', '', option, flags=re.IGNORECASE)
        option = re.sub(r'\s*\(If yes, continue to prompts\)', '', option, flags=re.IGNORECASE)
        option = option.strip()
        
        is_text_input = False
        for kw in text_keywords:
            if kw.lower() in option.lower():
                is_text_input = True
                break
                
        if current_field:
            if is_text_input:
                current_field['type'] = 'text'
                current_field['placeholder'] = option
            else:
                current_field['options'].append(option)
    elif item_str.isupper() and len(item_str) > 3 and "REPEAT" not in item_str and "IF YES" not in item_str:
        current_category = {
            'id': item_str.lower().replace(' ', '_').replace('(', '').replace(')', ''),
            'title': item_str,
            'fields': []
        }
        categories.append(current_category)
        current_field = None
    else:
        if "Repeat" in item_str or "If yes" in item_str or item_str == "Living Room Item" or "Complete prompts" in item_str:
            continue
            
        if current_category is None:
            current_category = {
                'id': 'general',
                'title': 'General',
                'fields': []
            }
            categories.append(current_category)
            
        current_field = {
            'id': item_str.lower().replace(' ', '_').replace('(', '').replace(')', '').replace('/', '_').replace('?', '').replace('#', ''),
            'label': item_str,
            'type': 'radio',
            'options': []
        }
        
        # Identify checkboxes
        for kw in checkbox_keywords:
            if kw in item_str.lower():
                current_field['type'] = 'checkbox'
                
        current_category['fields'].append(current_field)

# Clean up fields and add conditions
for cat in categories:
    condition_stack = []
    
    for field in cat['fields']:
        # Fix text types
        if field['type'] == 'radio' and not field['options']:
            field['type'] = 'text'
        if field['type'] == 'text':
            field['options'] = []
            
        # Hardcode major section resets to prevent conditions from bleeding over
        if field['id'] in ['walls', 'furniture_piece_1', 'sofa', 'table', 'rugs', 'technology', 'plants', 'wall_1']:
            condition_stack = []
            
        # Apply current condition if any
        if condition_stack:
            field['condition'] = condition_stack[-1]
            
        # Determine if this field sets a new condition for subsequent fields
        # Check if the options are precisely "No" and "Yes" (or "Yes,")
        opts_lower = [o.lower() for o in field.get('options', [])]
        if len(opts_lower) == 2 and any(o.startswith('no') for o in opts_lower) and any(o.startswith('yes') for o in opts_lower):
            # It's a yes/no question. Set the condition for subsequent fields.
            yes_val = next(o for o in field['options'] if o.lower().startswith('yes'))
            condition_stack.append({
                'field': field['id'],
                'value': yes_val
            })
            
        # Hardcode specific resets for deeply nested fields that shouldn't cascade too far
        if field['id'] == 'window' and cat['id'] == 'walls':
            condition_stack = [] # Reset immediately because wall window has no sub-prompts in excel
        if field['id'] == 'door' and cat['id'] == 'walls':
            condition_stack = []
        if field['id'] == 'mirror' and cat['id'] == 'walls':
            condition_stack = [] # Reset decorations condition

# Output as PHP array
def to_php_array(obj, indent=1):
    spaces = "    " * indent
    if isinstance(obj, dict):
        res = "[\n"
        for k, v in obj.items():
            res += f"{spaces}    '{k}' => {to_php_array(v, indent + 1)},\n"
        res += f"{spaces}]"
        return res
    elif isinstance(obj, list):
        res = "[\n"
        for v in obj:
            res += f"{spaces}    {to_php_array(v, indent + 1)},\n"
        res += f"{spaces}]"
        return res
    elif isinstance(obj, str):
        safe_str = obj.replace("'", "\\'")
        return f"'{safe_str}'"
    elif isinstance(obj, bool):
        return "true" if obj else "false"
    else:
        return str(obj)

php_content = "<?php\n\nreturn [\n    'categories' => " + to_php_array(categories, 1) + "\n];\n"

with open('/Users/hussainkhalil/Desktop/ai-project/config/checklist.php', 'w') as f:
    f.write(php_content)

print("Generated config/checklist.php with conditions and checkboxes successfully.")
