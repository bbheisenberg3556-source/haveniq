import pprint

categories = []

# 1. SHAPE AND SIZE
categories.append({
    'id': 'shape_and_size',
    'title': 'SHAPE AND SIZE OF THE ROOM',
    'fields': [
        {'id': 'room_shape', 'label': 'Shape of the room', 'type': 'radio', 'options': ['Rectangular', 'Square', 'Circle', 'Oval', 'Octagon', 'Other']},
        {'id': 'room_size', 'label': 'Size', 'type': 'radio', 'options': ['Small', 'Medium', 'Large']},
        {'id': 'room_location', 'label': 'Location', 'type': 'radio', 'options': ['Ground floor of one level home', 'Ground floor of multi-level home', 'Second or other floor of multi-level home', 'Apartment']},
        {'id': 'room_ceiling', 'label': 'Ceiling', 'type': 'radio', 'options': ['Low / caved in', 'Standard height (8 - 9 feet)', 'High / vaulted / cathedral', 'Sloped / atticy', 'Normal ceilings', 'Exposed wooden beams', 'Skylight / open glass', 'Water stains / cracks / other damage', 'Unfinished / exposed pipes']}
    ]
})

# 2. WINDOWS
window_fields = [
    {'id': 'has_windows', 'label': 'Are there windows in this room?', 'type': 'radio', 'options': ['No', 'Yes']}
]
def win_cond(): return {'field': 'has_windows', 'value': 'Yes'}

window_fields.extend([
    {'id': 'windows_number_walls', 'label': 'Number of walls with windows', 'type': 'text', 'placeholder': 'Insert number', 'condition': win_cond()},
    {'id': 'windows_type', 'label': 'Type of window', 'type': 'radio', 'options': ['Half-window', 'Full window', 'Small window'], 'condition': win_cond()},
    {'id': 'windows_location', 'label': 'Location', 'type': 'radio', 'options': ['Top of the wall', 'Middle of the wall', 'Right / Left side of the wall', 'Skylight / Overhead', 'Top wall', 'Bottom wall', 'Left wall', 'Right wall'], 'condition': win_cond()},
    {'id': 'windows_number_per_wall', 'label': 'Number of windows on each wall', 'type': 'text', 'placeholder': 'Insert number', 'condition': win_cond()},
    {'id': 'windows_shape', 'label': 'Window shape and style', 'type': 'radio', 'options': ['Standard (rectangle / square)', 'Arched', 'Circular / oval', 'Bay window', 'Stained glass'], 'condition': win_cond()},
    {'id': 'windows_glass_condition', 'label': 'Glass condition and clarity', 'type': 'radio', 'options': ['Clear and clean', 'Frosted / opaque / tinted', 'Dirty / fogged / dusty', 'Cracked or broken'], 'condition': win_cond()},
    {'id': 'windows_features', 'label': 'Window has (choose all that apply)', 'type': 'checkbox', 'options': ['Bars on the outside', 'Bars on the inside', 'Blinds', 'Curtains', 'Dividers', 'Windowsill'], 'condition': win_cond()},
    
    # Blinds sub-prompts
    {'id': 'windows_blinds_color', 'label': 'Color of the blind', 'type': 'text', 'placeholder': 'Insert color', 'condition': {'field': 'windows_features', 'value': 'Blinds'}},
    {'id': 'windows_blinds_status', 'label': 'Blinds status', 'type': 'radio', 'options': ['Closed', 'Open', 'Half open'], 'condition': {'field': 'windows_features', 'value': 'Blinds'}},
    
    # Curtains sub-prompts
    {'id': 'windows_curtains_color', 'label': 'Color / pattern of the curtain', 'type': 'text', 'placeholder': 'Insert color / pattern', 'condition': {'field': 'windows_features', 'value': 'Curtains'}},
    {'id': 'windows_curtains_status', 'label': 'Curtains status', 'type': 'radio', 'options': ['Closed', 'Open', 'Half open'], 'condition': {'field': 'windows_features', 'value': 'Curtains'}},
    
    # Dividers sub-prompts
    {'id': 'windows_dividers_number', 'label': 'Dividers number', 'type': 'text', 'placeholder': 'Insert number', 'condition': {'field': 'windows_features', 'value': 'Dividers'}},
    {'id': 'windows_dividers_color', 'label': 'Dividers color', 'type': 'text', 'placeholder': 'Insert color', 'condition': {'field': 'windows_features', 'value': 'Dividers'}},
    
    # Windowsill sub-prompts
    {'id': 'windows_sill_status', 'label': 'Windowsill status', 'type': 'radio', 'options': ['Empty', 'Holds items'], 'condition': {'field': 'windows_features', 'value': 'Windowsill'}},
    {'id': 'windows_sill_items', 'label': 'Describe items on windowsill', 'type': 'text', 'placeholder': 'Describe items', 'condition': {'field': 'windows_sill_status', 'value': 'Holds items'}},
    
    {'id': 'windows_status', 'label': 'Window is', 'type': 'radio', 'options': ['Open', 'Closed'], 'condition': win_cond()},
    {'id': 'windows_material', 'label': 'Window material', 'type': 'radio', 'options': ['Wood', 'Metal', 'Plastic'], 'condition': win_cond()},
    
    # Outside the window & sub-prompts
    {'id': 'windows_outside', 'label': 'What is outside the window?', 'type': 'radio', 'options': ['Nothing', 'Another building', 'Horizon', 'Garden', 'Water'], 'condition': win_cond()},
    {'id': 'windows_outside_building_kind', 'label': 'Kind of building outside', 'type': 'text', 'placeholder': 'Insert kind of building', 'condition': {'field': 'windows_outside', 'value': 'Another building'}},
    
    {'id': 'windows_season', 'label': 'Season (if outside can be seen)', 'type': 'radio', 'options': ['Spring', 'Summer', 'Fall', 'Winter'], 'condition': win_cond()},
    {'id': 'windows_time_of_day', 'label': 'Time of day', 'type': 'radio', 'options': ['Daytime', 'Night-time', 'Dawn', 'Sunset'], 'condition': win_cond()},
    {'id': 'windows_weather', 'label': 'Weather', 'type': 'radio', 'options': ['Sunny', 'Rainy', 'Gloomy', 'Other'], 'condition': win_cond()},
    {'id': 'windows_weather_describe', 'label': 'Describe weather', 'type': 'text', 'placeholder': 'Describe', 'condition': {'field': 'windows_weather', 'value': 'Other'}},
    {'id': 'windows_angle', 'label': 'Window angle', 'type': 'radio', 'options': ['Looking down from high up', 'Looking straight out (floor level)', 'Looking up from below'], 'condition': win_cond()}
])
categories.append({'id': 'windows', 'title': 'WINDOW(S)', 'fields': window_fields})

# 3. DOORS
door_fields = [
    {'id': 'has_doors', 'label': 'Are there doors in this room?', 'type': 'radio', 'options': ['No', 'Yes']}
]
def door_cond(): return {'field': 'has_doors', 'value': 'Yes'}

door_fields.extend([
    {'id': 'doors_number_walls', 'label': 'Number of walls with doors', 'type': 'text', 'placeholder': 'Insert number', 'condition': door_cond()},
    {'id': 'doors_location', 'label': 'Location', 'type': 'radio', 'options': ['Top wall', 'Bottom wall', 'Left wall', 'Right wall'], 'condition': door_cond()},
    {'id': 'doors_number_per_wall', 'label': 'Number of doors on each wall', 'type': 'text', 'placeholder': 'Insert number', 'condition': door_cond()},
    {'id': 'doors_type', 'label': 'Door type', 'type': 'radio', 'options': ['Standard rectangular door', 'Door with grids (French door)', 'Solid', 'Glass sections', 'Metal', 'Sliding', 'Wood'], 'condition': door_cond()},
    {'id': 'doors_color', 'label': 'Door color', 'type': 'text', 'placeholder': 'Insert color / Pattern', 'condition': door_cond()},
    {'id': 'doors_status', 'label': 'Status', 'type': 'radio', 'options': ['Closed', 'Open', 'Half open'], 'condition': door_cond()},
    {'id': 'doors_other_side', 'label': 'What is on the other side of the door?', 'type': 'radio', 'options': ['Nothing', 'Cannot see / Do not know', 'Another room', 'Office', 'Bedroom', 'Kitchen', 'Hallway', 'Family room / Study', 'Outside / exterior', 'Other'], 'condition': door_cond()},
    {'id': 'doors_other_side_describe', 'label': 'Describe what is on the other side', 'type': 'text', 'placeholder': 'Describe', 'condition': {'field': 'doors_other_side', 'value': 'Other'}},
    {'id': 'doors_locks', 'label': 'Locking mechanism', 'type': 'radio', 'options': ['No locking mechanism', 'Unlocked / Free to turn', 'Locked from inside', 'Locked from outside', 'Padlock / heavy deadbolt', 'Keyhole present', 'Chain lock or safety latch'], 'condition': door_cond()},
    {'id': 'doors_hardware', 'label': 'Door handle / hardware', 'type': 'radio', 'options': ['No handle / flush door', 'Standard doorknob', 'Ornate or antique handle', 'Keypad / Digital lock', 'Push bar / panic bar', 'Peephole present'], 'condition': door_cond()},
    {'id': 'doors_condition', 'label': 'Door condition', 'type': 'radio', 'options': ['Sturdy and well fitted', 'Damaged / splintered / forced', 'Drafty / gap under the door'], 'condition': door_cond()},
    {'id': 'doors_direction', 'label': 'Direction of the door', 'type': 'radio', 'options': ['Open inwards', 'Opens outwards', 'Pocket door / slides'], 'condition': door_cond()},
    {'id': 'doors_signs', 'label': 'Signs or markings on the door', 'type': 'checkbox', 'options': ['None', 'Keep out / Do not disturb sign', 'Welcome sign', 'Name plate'], 'condition': door_cond()}
])
categories.append({'id': 'doors', 'title': 'DOOR(S)', 'fields': door_fields})

# 4. WALLS (Walls 1 through 4)
wall_fields = []
for i in range(1, 5):
    prefix = f'wall_{i}_'
    wall_fields.append({'id': f'wall_{i}', 'label': f'--- WALL {i} ---', 'type': 'text', 'placeholder': 'Optional notes'})
    wall_fields.append({'id': f'{prefix}location', 'label': f'Wall {i} Location', 'type': 'radio', 'options': ['Left of room', 'Right of room', 'Top of room', 'Bottom of room']})
    wall_fields.append({'id': f'{prefix}color', 'label': f'Wall {i} Color / Wallpaper', 'type': 'text', 'placeholder': 'Insert color or pattern'})
    wall_fields.append({'id': f'{prefix}texture', 'label': f'Wall {i} Texture', 'type': 'radio', 'options': ['Smooth drywall / plaster', 'Exposed brick / stone', 'Wood paneling or logs', 'Glass wall / floor to ceiling glass', 'Fabric', 'Concrete / cinderblock', 'Unfinished / insulation showing']})
    
    # Decorations sub-tree
    wall_fields.append({'id': f'{prefix}has_decorations', 'label': f'Wall {i} Decorations', 'type': 'radio', 'options': ['No', 'Yes']})
    dec_cond = {'field': f'{prefix}has_decorations', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}decorations_list', 'label': 'Choose decorations (Check all that apply)', 'type': 'checkbox', 'options': ['Clocks', 'Tapestries / textiles on the wall', 'Bulletin Boards', 'Posters pop culture art', 'Diplomas / awards or certificates', 'Religious, spiritual or ancestral symbols', 'Hanging plants', 'Hooks / pegboards', 'Paintings', 'Family pictures'], 'condition': dec_cond})
    
    # Posters sub-prompts
    posters_cond = {'field': f'{prefix}decorations_list', 'value': 'Posters pop culture art'}
    wall_fields.append({'id': f'{prefix}posters_number', 'label': 'Number of posters', 'type': 'text', 'placeholder': 'Insert number', 'condition': posters_cond})
    wall_fields.append({'id': f'{prefix}posters_theme', 'label': 'Theme of posters', 'type': 'text', 'placeholder': 'Insert theme', 'condition': posters_cond})
    
    # Paintings sub-prompts: Paintings -> Number + Color + Pattern
    paintings_cond = {'field': f'{prefix}decorations_list', 'value': 'Paintings'}
    wall_fields.append({'id': f'{prefix}paintings_number', 'label': 'Number of paintings', 'type': 'text', 'placeholder': 'Insert number', 'condition': paintings_cond})
    wall_fields.append({'id': f'{prefix}paintings_color', 'label': 'Paintings color', 'type': 'text', 'placeholder': 'Insert color', 'condition': paintings_cond})
    wall_fields.append({'id': f'{prefix}paintings_pattern', 'label': 'Paintings pattern / theme', 'type': 'text', 'placeholder': 'Insert pattern / theme', 'condition': paintings_cond})
    
    # Family pictures sub-prompts: Family pictures -> Frame -> Wood/Metal/No frame
    fam_cond = {'field': f'{prefix}decorations_list', 'value': 'Family pictures'}
    wall_fields.append({'id': f'{prefix}family_pics_frame', 'label': 'Family pictures frame', 'type': 'radio', 'options': ['Wood', 'Metal', 'No frame'], 'condition': fam_cond})
    
    # Built-in bookshelves: Books + Other decorative items options
    wall_fields.append({'id': f'{prefix}has_bookshelves', 'label': f'Wall {i} Built-in bookshelves / nook', 'type': 'radio', 'options': ['No', 'Yes']})
    bk_cond = {'field': f'{prefix}has_bookshelves', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}bookshelves_fill', 'label': 'Bookshelf fullness', 'type': 'radio', 'options': ['Full', 'Half-full', 'Organized', 'Scattered'], 'condition': bk_cond})
    wall_fields.append({'id': f'{prefix}bookshelves_contents', 'label': 'Bookshelf contents (Check all that apply)', 'type': 'checkbox', 'options': ['Books', 'Other decorative items'], 'condition': bk_cond})
    
    # Mirror: Condition + Material sub-prompts
    wall_fields.append({'id': f'{prefix}has_mirror', 'label': f'Wall {i} Mirror', 'type': 'radio', 'options': ['No', 'Yes']})
    mir_cond = {'field': f'{prefix}has_mirror', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}mirror_type', 'label': 'Mirror type', 'type': 'radio', 'options': ['Accent mirror', 'Full length'], 'condition': mir_cond})
    wall_fields.append({'id': f'{prefix}mirror_condition', 'label': 'Mirror condition', 'type': 'radio', 'options': ['Clear', 'Antique / tinted', 'Worn / cracked'], 'condition': mir_cond})
    wall_fields.append({'id': f'{prefix}mirror_material', 'label': 'Mirror frame material', 'type': 'radio', 'options': ['Wood', 'Metal', 'Other'], 'condition': mir_cond})
    
    # Fireplace: hearth protector + items on mantel
    wall_fields.append({'id': f'{prefix}has_fireplace', 'label': f'Wall {i} Fireplace / Chimney', 'type': 'radio', 'options': ['No', 'Yes']})
    fp_cond = {'field': f'{prefix}has_fireplace', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}fireplace_type', 'label': 'Fireplace Type', 'type': 'radio', 'options': ['Working fireplace', 'Decorative fireplace'], 'condition': fp_cond})
    wall_fields.append({'id': f'{prefix}fireplace_lit', 'label': 'Is fire lit?', 'type': 'radio', 'options': ['Fire is lighted', 'Fire is not lighted', 'Wood in fireplace for lighting'], 'condition': fp_cond})
    wall_fields.append({'id': f'{prefix}fireplace_material', 'label': 'Fireplace frame material', 'type': 'radio', 'options': ['Wood frame', 'Metal frame', 'Stone frame', 'Natural stone', 'Smooth Frame (granite/marble)'], 'condition': fp_cond})
    wall_fields.append({'id': f'{prefix}fireplace_hearth_protector', 'label': 'Fireplace hearth protector', 'type': 'radio', 'options': ['No', 'Yes'], 'condition': fp_cond})
    wall_fields.append({'id': f'{prefix}fireplace_mantel', 'label': 'Mantel material', 'type': 'radio', 'options': ['None', 'Wood', 'Stone', 'Other material'], 'condition': fp_cond})
    wall_fields.append({'id': f'{prefix}fireplace_mantel_items', 'label': 'Items on the mantel (Check all that apply)', 'type': 'checkbox', 'options': ['Pictures', 'Plants', 'Flowers', 'Other items – describe'], 'condition': fp_cond})
    mantel_other_cond = {'field': f'{prefix}fireplace_mantel_items', 'value': 'Other items – describe'}
    wall_fields.append({'id': f'{prefix}fireplace_mantel_other', 'label': 'Describe other items on mantel', 'type': 'text', 'placeholder': 'Describe items', 'condition': mantel_other_cond})
    
    # Wall sconces / mounted lamps
    wall_fields.append({'id': f'{prefix}has_wall_sconces', 'label': f'Wall {i} Wall sconces / mounted lamps', 'type': 'radio', 'options': ['No', 'Yes']})
    sconce_cond = {'field': f'{prefix}has_wall_sconces', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}wall_lighting', 'label': 'Wall lighting condition', 'type': 'radio', 'options': ['Direct natural light hits the wall', 'Wall in shadow / dimly lit'], 'condition': sconce_cond})
    
    # Hanging shelves
    wall_fields.append({'id': f'{prefix}has_hanging_shelves', 'label': f'Wall {i} Hanging shelves', 'type': 'radio', 'options': ['No', 'Yes']})
    shelf_cond = {'field': f'{prefix}has_hanging_shelves', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}hanging_shelves_desc', 'label': 'Describe objects on shelves', 'type': 'text', 'placeholder': 'Describe objects on shelves', 'condition': shelf_cond})
    
    # Closet / Doors
    wall_fields.append({'id': f'{prefix}has_closet_doors', 'label': f'Wall {i} Closet / Doors / Hidden storage', 'type': 'radio', 'options': ['No closets / hidden storage areas / doors', 'Yes']})
    closet_cond = {'field': f'{prefix}has_closet_doors', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}closet_doors_type', 'label': 'Closet / door type', 'type': 'radio', 'options': ['Closet / Door', 'Door', 'Hidden panel'], 'condition': closet_cond})
    
    # TV
    wall_fields.append({'id': f'{prefix}has_tv', 'label': f'Wall {i} Television', 'type': 'radio', 'options': ['No', 'Yes']})
    tv_cond = {'field': f'{prefix}has_tv', 'value': 'Yes'}
    wall_fields.append({'id': f'{prefix}tv_size', 'label': 'TV Size', 'type': 'radio', 'options': ['Small', 'Medium', 'Large'], 'condition': tv_cond})

categories.append({'id': 'walls', 'title': 'WALLS', 'fields': wall_fields})

# 5. FURNITURE (Repeatable 3 pieces)
furn_fields = []
furn_fields.append({'id': 'has_furniture', 'label': 'Is there furniture in this room?', 'type': 'radio', 'options': ['No', 'Yes']})
for i in range(1, 4): # 3 pieces
    prefix = f'furn_{i}_'
    cond = {'field': 'has_furniture', 'value': 'Yes'}
    
    furn_fields.append({'id': f'{prefix}enable', 'label': f'Add Furniture Piece #{i}?', 'type': 'radio', 'options': ['No', 'Yes'], 'condition': cond})
    en_cond = {'field': f'{prefix}enable', 'value': 'Yes'}
    
    furn_fields.append({'id': f'{prefix}location', 'label': f'Piece #{i} Location', 'type': 'radio', 'options': ['Center of the room', 'Near / against top wall', 'Near / against bottom wall', 'Near / against left wall', 'Near / against right wall'], 'condition': en_cond})
    
    # Type: add Rug and Technology to the piece type options
    furn_fields.append({'id': f'{prefix}type', 'label': f'Piece #{i} Type', 'type': 'radio', 'options': ['Sofa / Chair / Chaise', 'Table', 'Rug', 'Technology'], 'condition': en_cond})
    
    # Condition per piece (Immaculate/Stained/Delicate)
    furn_fields.append({'id': f'{prefix}condition', 'label': f'Piece #{i} Condition', 'type': 'radio', 'options': ['Immaculate / new / protected', 'Stained / scratched / lived in', 'Delicate / need for high care'], 'condition': en_cond})
    
    # Sofa conditions
    sofa_cond = {'field': f'{prefix}type', 'value': 'Sofa / Chair / Chaise'}
    furn_fields.append({'id': f'{prefix}sofa_type', 'label': 'Sofa Type', 'type': 'radio', 'options': ['Chair', 'Chaise', 'Love seat', 'Three-seater', 'Four-seater', 'Curved / arc', 'Sleeper sofa', 'Ottoman', 'Wing chair'], 'condition': sofa_cond})
    furn_fields.append({'id': f'{prefix}sofa_material', 'label': 'Sofa Material', 'type': 'radio', 'options': ['Linen', 'Velvet', 'Wood', 'Metal', 'Leather'], 'condition': sofa_cond})
    furn_fields.append({'id': f'{prefix}sofa_color', 'label': 'Sofa Color', 'type': 'text', 'placeholder': 'Insert color', 'condition': sofa_cond})
    furn_fields.append({'id': f'{prefix}sofa_legs', 'label': 'Sofa Legs', 'type': 'radio', 'options': ['No (sunken / floor seating)', 'Wood', 'Metal', 'Straight', 'Curved', 'Skirted'], 'condition': sofa_cond})
    
    # Sofa sub-prompts: Decorative pillows, Other materials, Associated table
    furn_fields.append({'id': f'{prefix}sofa_has_pillows', 'label': 'Decorative pillows / throw blankets', 'type': 'radio', 'options': ['No', 'Yes'], 'condition': sofa_cond})
    pillow_cond = {'field': f'{prefix}sofa_has_pillows', 'value': 'Yes'}
    furn_fields.append({'id': f'{prefix}sofa_pillows_number', 'label': 'Number of pillows / throw blankets', 'type': 'text', 'placeholder': 'Insert number', 'condition': pillow_cond})
    furn_fields.append({'id': f'{prefix}sofa_pillows_color', 'label': 'Pillows / blankets color or pattern', 'type': 'text', 'placeholder': 'Insert color / pattern', 'condition': pillow_cond})
    
    furn_fields.append({'id': f'{prefix}sofa_other_materials', 'label': 'Other materials on the sofa (Check all that apply)', 'type': 'checkbox', 'options': ['Book', 'Papers', 'Blanket', 'Other'], 'condition': sofa_cond})
    furn_fields.append({'id': f'{prefix}sofa_associated_table', 'label': 'Associated table', 'type': 'radio', 'options': ['No', 'Yes'], 'condition': sofa_cond})
    
    # Table conditions
    table_cond = {'field': f'{prefix}type', 'value': 'Table'}
    furn_fields.append({'id': f'{prefix}table_type', 'label': 'Table Type', 'type': 'radio', 'options': ['Coffee table', 'Side table', 'Desk'], 'condition': table_cond})
    furn_fields.append({'id': f'{prefix}table_shape', 'label': 'Table Shape', 'type': 'radio', 'options': ['Oval', 'Square', 'Rectangular', 'Other'], 'condition': table_cond})
    furn_fields.append({'id': f'{prefix}table_material', 'label': 'Table Material', 'type': 'radio', 'options': ['Wood', 'Metal', 'Stone / granite', 'Bamboo', 'Other'], 'condition': table_cond})
    furn_fields.append({'id': f'{prefix}table_size', 'label': 'Table Size', 'type': 'radio', 'options': ['Small', 'Medium', 'Large'], 'condition': table_cond})
    
    # Table sub-prompts: Drawers/Storage, Items on table
    furn_fields.append({'id': f'{prefix}table_drawers', 'label': 'Drawers / Storage', 'type': 'radio', 'options': ['No', 'Yes'], 'condition': table_cond})
    drawer_cond = {'field': f'{prefix}table_drawers', 'value': 'Yes'}
    furn_fields.append({'id': f'{prefix}table_drawers_count', 'label': 'Number of drawers / storage', 'type': 'text', 'placeholder': 'Insert number', 'condition': drawer_cond})
    
    furn_fields.append({'id': f'{prefix}table_items', 'label': 'Items on table (Check all that apply)', 'type': 'checkbox', 'options': ['Nothing', 'Glasses', 'Flowers / plants', 'Books', 'Drink / food', 'Lamp'], 'condition': table_cond})
    lamp_cond = {'field': f'{prefix}table_items', 'value': 'Lamp'}
    furn_fields.append({'id': f'{prefix}table_lamp_style', 'label': 'Lamp style', 'type': 'radio', 'options': ['Modern', 'Antique'], 'condition': lamp_cond})
    furn_fields.append({'id': f'{prefix}table_lamp_shape', 'label': 'Lamp shape', 'type': 'radio', 'options': ['Straight', 'Curved'], 'condition': lamp_cond})
    furn_fields.append({'id': f'{prefix}table_lamp_shade', 'label': 'Lamp shade', 'type': 'radio', 'options': ['With lamp shade', 'Without lamp shade'], 'condition': lamp_cond})
    furn_fields.append({'id': f'{prefix}table_lamp_color', 'label': 'Lamp color', 'type': 'text', 'placeholder': 'Insert color', 'condition': lamp_cond})
    furn_fields.append({'id': f'{prefix}table_lamp_status', 'label': 'Lamp light status', 'type': 'radio', 'options': ['Light is on', 'Light is off'], 'condition': lamp_cond})
    
    # Rug under furniture piece
    rug_piece_cond = {'field': f'{prefix}type', 'value': 'Rug'}
    furn_fields.append({'id': f'{prefix}rug_type', 'label': 'Rug Type', 'type': 'radio', 'options': ['Hand-knot', 'Flat weave', 'Hand tufted', 'Shag', 'Braided / coiled', 'Machine made', 'Persian'], 'condition': rug_piece_cond})
    furn_fields.append({'id': f'{prefix}rug_shape', 'label': 'Rug Shape', 'type': 'radio', 'options': ['Circle / Oval', 'Square', 'Rectangular', 'Other'], 'condition': rug_piece_cond})
    furn_fields.append({'id': f'{prefix}rug_color', 'label': 'Rug Color / Pattern', 'type': 'text', 'placeholder': 'Describe', 'condition': rug_piece_cond})

    # Technology under furniture piece
    tech_piece_cond = {'field': f'{prefix}type', 'value': 'Technology'}
    furn_fields.append({'id': f'{prefix}tech_type', 'label': 'Technology Type', 'type': 'radio', 'options': ['Stereo', 'Charging station', 'Other'], 'condition': tech_piece_cond})
    furn_fields.append({'id': f'{prefix}tech_describe', 'label': 'Describe Technology', 'type': 'text', 'placeholder': 'Describe', 'condition': tech_piece_cond})

categories.append({'id': 'furniture', 'title': 'FURNITURE', 'fields': furn_fields})

# 6. RUGS (Standalone Category)
rug_fields = []
rug_fields.append({'id': 'has_rugs', 'label': 'Are there rugs in this room?', 'type': 'radio', 'options': ['No', 'Yes']})
r_cond = {'field': 'has_rugs', 'value': 'Yes'}
rug_fields.append({'id': 'rugs_type', 'label': 'Rug Type', 'type': 'radio', 'options': ['Hand-knot', 'Flat weave', 'Hand tufted', 'Shag', 'Braided / coiled', 'Machine made', 'Persian'], 'condition': r_cond})
rug_fields.append({'id': 'rugs_shape', 'label': 'Rug Shape', 'type': 'radio', 'options': ['Circle / Oval', 'Square', 'Rectangular', 'Other'], 'condition': r_cond})
rug_fields.append({'id': 'rugs_color', 'label': 'Rug Color / Pattern', 'type': 'text', 'placeholder': 'Describe', 'condition': r_cond})
rug_fields.append({'id': 'rugs_location', 'label': 'Rug Location', 'type': 'radio', 'options': ['Under furniture', 'Next to furniture', 'In front of furniture', 'Center of room', 'Other'], 'condition': r_cond})
rug_fields.append({'id': 'rugs_location_details', 'label': 'Location details', 'type': 'text', 'placeholder': 'e.g. Under furniture #1 / in front of sofa', 'condition': r_cond})
categories.append({'id': 'rugs', 'title': 'RUGS', 'fields': rug_fields})

# 7. TECHNOLOGY (Standalone Category)
tech_fields = []
tech_fields.append({'id': 'has_tech', 'label': 'Is there technology in this room?', 'type': 'radio', 'options': ['No', 'Yes']})
t_cond = {'field': 'has_tech', 'value': 'Yes'}
tech_fields.append({'id': 'tech_type', 'label': 'Tech Type', 'type': 'radio', 'options': ['Stereo', 'Charging station', 'Other'], 'condition': t_cond})
tech_fields.append({'id': 'tech_describe', 'label': 'Describe technology', 'type': 'text', 'placeholder': 'Describe technology item', 'condition': t_cond})
categories.append({'id': 'technology', 'title': 'TECHNOLOGY', 'fields': tech_fields})

# 8. PLANTS (Standalone Category)
plant_fields = []
plant_fields.append({'id': 'has_plants', 'label': 'Are there plants in this room?', 'type': 'radio', 'options': ['No', 'Yes']})
p_cond = {'field': 'has_plants', 'value': 'Yes'}
plant_fields.append({'id': 'plants_location', 'label': 'Location', 'type': 'radio', 'options': ['In front / near wall #1', 'In front / near wall #2', 'In front / near wall #3', 'In front / near wall #4'], 'condition': p_cond})
plant_fields.append({'id': 'plants_size', 'label': 'Size', 'type': 'radio', 'options': ['Small', 'Medium', 'Large'], 'condition': p_cond})
plant_fields.append({'id': 'plants_condition', 'label': 'Condition', 'type': 'radio', 'options': ['Blossoming and vibrant', 'Tired (needs water and attention)', 'Dead / almost dead'], 'condition': p_cond})
plant_fields.append({'id': 'plants_container', 'label': 'Container / pot style and color', 'type': 'text', 'placeholder': 'Describe container / pot color and style', 'condition': p_cond})
categories.append({'id': 'plants', 'title': 'PLANTS', 'fields': plant_fields})

# Generate PHP
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

print(f"Generated config/checklist.php successfully with {len(categories)} categories.")
