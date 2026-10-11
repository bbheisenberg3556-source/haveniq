<?php

return [
    'categories' => [
        [
            'id' => 'shape_and_size',
            'title' => 'SHAPE AND SIZE OF THE ROOM',
            'fields' => [
                [
                    'id' => 'room_shape',
                    'label' => 'Shape of the room',
                    'type' => 'radio',
                    'options' => [
                        'Rectangular',
                        'Square',
                        'Circle',
                        'Oval',
                        'Octagon',
                        'Other',
                    ],
                ],
                [
                    'id' => 'room_size',
                    'label' => 'Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                ],
                [
                    'id' => 'room_location',
                    'label' => 'Location',
                    'type' => 'radio',
                    'options' => [
                        'Ground floor of one level home',
                        'Ground floor of multi-level home',
                        'Second or other floor of multi-level home',
                        'Apartment',
                    ],
                ],
                [
                    'id' => 'room_ceiling',
                    'label' => 'Ceiling',
                    'type' => 'radio',
                    'options' => [
                        'Low / caved in',
                        'Standard height (8 - 9 feet)',
                        'High / vaulted / cathedral',
                        'Sloped / atticy',
                        'Normal ceilings',
                        'Exposed wooden beams',
                        'Skylight / open glass',
                        'Water stains / cracks / other damage',
                        'Unfinished / exposed pipes',
                    ],
                ],
            ],
        ],
        [
            'id' => 'windows',
            'title' => 'WINDOW(S)',
            'fields' => [
                [
                    'id' => 'has_windows',
                    'label' => 'Are there windows in this room?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'windows_number_walls',
                    'label' => 'Number of walls with windows',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_type',
                    'label' => 'Type of window',
                    'type' => 'radio',
                    'options' => [
                        'Half-window',
                        'Full window',
                        'Small window',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_location',
                    'label' => 'Location',
                    'type' => 'radio',
                    'options' => [
                        'Top of the wall',
                        'Middle of the wall',
                        'Right / Left side of the wall',
                        'Skylight / Overhead',
                        'Top wall',
                        'Bottom wall',
                        'Left wall',
                        'Right wall',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_number_per_wall',
                    'label' => 'Number of windows on each wall',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_shape',
                    'label' => 'Window shape and style',
                    'type' => 'radio',
                    'options' => [
                        'Standard (rectangle / square)',
                        'Arched',
                        'Circular / oval',
                        'Bay window',
                        'Stained glass',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_glass_condition',
                    'label' => 'Glass condition and clarity',
                    'type' => 'radio',
                    'options' => [
                        'Clear and clean',
                        'Frosted / opaque / tinted',
                        'Dirty / fogged / dusty',
                        'Cracked or broken',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_features',
                    'label' => 'Window has (choose all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Bars on the outside',
                        'Bars on the inside',
                        'Blinds',
                        'Curtains',
                        'Dividers',
                        'Windowsill',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_blinds_color',
                    'label' => 'Color of the blind',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Blinds',
                    ],
                ],
                [
                    'id' => 'windows_blinds_status',
                    'label' => 'Blinds status',
                    'type' => 'radio',
                    'options' => [
                        'Closed',
                        'Open',
                        'Half open',
                    ],
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Blinds',
                    ],
                ],
                [
                    'id' => 'windows_curtains_color',
                    'label' => 'Color / pattern of the curtain',
                    'type' => 'text',
                    'placeholder' => 'Insert color / pattern',
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Curtains',
                    ],
                ],
                [
                    'id' => 'windows_curtains_status',
                    'label' => 'Curtains status',
                    'type' => 'radio',
                    'options' => [
                        'Closed',
                        'Open',
                        'Half open',
                    ],
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Curtains',
                    ],
                ],
                [
                    'id' => 'windows_dividers_number',
                    'label' => 'Dividers number',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Dividers',
                    ],
                ],
                [
                    'id' => 'windows_dividers_color',
                    'label' => 'Dividers color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Dividers',
                    ],
                ],
                [
                    'id' => 'windows_sill_status',
                    'label' => 'Windowsill status',
                    'type' => 'radio',
                    'options' => [
                        'Empty',
                        'Holds items',
                    ],
                    'condition' => [
                        'field' => 'windows_features',
                        'value' => 'Windowsill',
                    ],
                ],
                [
                    'id' => 'windows_sill_items',
                    'label' => 'Describe items on windowsill',
                    'type' => 'text',
                    'placeholder' => 'Describe items',
                    'condition' => [
                        'field' => 'windows_sill_status',
                        'value' => 'Holds items',
                    ],
                ],
                [
                    'id' => 'windows_status',
                    'label' => 'Window is',
                    'type' => 'radio',
                    'options' => [
                        'Open',
                        'Closed',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_material',
                    'label' => 'Window material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Plastic',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_outside',
                    'label' => 'What is outside the window?',
                    'type' => 'radio',
                    'options' => [
                        'Nothing',
                        'Another building',
                        'Horizon',
                        'Garden',
                        'Water',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_outside_building_kind',
                    'label' => 'Kind of building outside',
                    'type' => 'text',
                    'placeholder' => 'Insert kind of building',
                    'condition' => [
                        'field' => 'windows_outside',
                        'value' => 'Another building',
                    ],
                ],
                [
                    'id' => 'windows_season',
                    'label' => 'Season (if outside can be seen)',
                    'type' => 'radio',
                    'options' => [
                        'Spring',
                        'Summer',
                        'Fall',
                        'Winter',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_time_of_day',
                    'label' => 'Time of day',
                    'type' => 'radio',
                    'options' => [
                        'Daytime',
                        'Night-time',
                        'Dawn',
                        'Sunset',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_weather',
                    'label' => 'Weather',
                    'type' => 'radio',
                    'options' => [
                        'Sunny',
                        'Rainy',
                        'Gloomy',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'windows_weather_describe',
                    'label' => 'Describe weather',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'windows_weather',
                        'value' => 'Other',
                    ],
                ],
                [
                    'id' => 'windows_angle',
                    'label' => 'Window angle',
                    'type' => 'radio',
                    'options' => [
                        'Looking down from high up',
                        'Looking straight out (floor level)',
                        'Looking up from below',
                    ],
                    'condition' => [
                        'field' => 'has_windows',
                        'value' => 'Yes',
                    ],
                ],
            ],
        ],
        [
            'id' => 'doors',
            'title' => 'DOOR(S)',
            'fields' => [
                [
                    'id' => 'has_doors',
                    'label' => 'Are there doors in this room?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'doors_number_walls',
                    'label' => 'Number of walls with doors',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_location',
                    'label' => 'Location',
                    'type' => 'radio',
                    'options' => [
                        'Top wall',
                        'Bottom wall',
                        'Left wall',
                        'Right wall',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_number_per_wall',
                    'label' => 'Number of doors on each wall',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_type',
                    'label' => 'Door type',
                    'type' => 'radio',
                    'options' => [
                        'Standard rectangular door',
                        'Door with grids (French door)',
                        'Solid',
                        'Glass sections',
                        'Metal',
                        'Sliding',
                        'Wood',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_color',
                    'label' => 'Door color',
                    'type' => 'text',
                    'placeholder' => 'Insert color / Pattern',
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_status',
                    'label' => 'Status',
                    'type' => 'radio',
                    'options' => [
                        'Closed',
                        'Open',
                        'Half open',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_other_side',
                    'label' => 'What is on the other side of the door?',
                    'type' => 'radio',
                    'options' => [
                        'Nothing',
                        'Cannot see / Do not know',
                        'Another room',
                        'Office',
                        'Bedroom',
                        'Kitchen',
                        'Hallway',
                        'Family room / Study',
                        'Outside / exterior',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_other_side_describe',
                    'label' => 'Describe what is on the other side',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'doors_other_side',
                        'value' => 'Other',
                    ],
                ],
                [
                    'id' => 'doors_locks',
                    'label' => 'Locking mechanism',
                    'type' => 'radio',
                    'options' => [
                        'No locking mechanism',
                        'Unlocked / Free to turn',
                        'Locked from inside',
                        'Locked from outside',
                        'Padlock / heavy deadbolt',
                        'Keyhole present',
                        'Chain lock or safety latch',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_hardware',
                    'label' => 'Door handle / hardware',
                    'type' => 'radio',
                    'options' => [
                        'No handle / flush door',
                        'Standard doorknob',
                        'Ornate or antique handle',
                        'Keypad / Digital lock',
                        'Push bar / panic bar',
                        'Peephole present',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_condition',
                    'label' => 'Door condition',
                    'type' => 'radio',
                    'options' => [
                        'Sturdy and well fitted',
                        'Damaged / splintered / forced',
                        'Drafty / gap under the door',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_direction',
                    'label' => 'Direction of the door',
                    'type' => 'radio',
                    'options' => [
                        'Open inwards',
                        'Opens outwards',
                        'Pocket door / slides',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'doors_signs',
                    'label' => 'Signs or markings on the door',
                    'type' => 'checkbox',
                    'options' => [
                        'None',
                        'Keep out / Do not disturb sign',
                        'Welcome sign',
                        'Name plate',
                    ],
                    'condition' => [
                        'field' => 'has_doors',
                        'value' => 'Yes',
                    ],
                ],
            ],
        ],
        [
            'id' => 'walls',
            'title' => 'WALLS',
            'fields' => [
                [
                    'id' => 'wall_1',
                    'label' => '--- WALL 1 ---',
                    'type' => 'text',
                    'placeholder' => 'Optional notes',
                ],
                [
                    'id' => 'wall_1_location',
                    'label' => 'Wall 1 Location',
                    'type' => 'radio',
                    'options' => [
                        'Left of room',
                        'Right of room',
                        'Top of room',
                        'Bottom of room',
                    ],
                ],
                [
                    'id' => 'wall_1_color',
                    'label' => 'Wall 1 Color / Wallpaper',
                    'type' => 'text',
                    'placeholder' => 'Insert color or pattern',
                ],
                [
                    'id' => 'wall_1_texture',
                    'label' => 'Wall 1 Texture',
                    'type' => 'radio',
                    'options' => [
                        'Smooth drywall / plaster',
                        'Exposed brick / stone',
                        'Wood paneling or logs',
                        'Glass wall / floor to ceiling glass',
                        'Fabric',
                        'Concrete / cinderblock',
                        'Unfinished / insulation showing',
                    ],
                ],
                [
                    'id' => 'wall_1_has_decorations',
                    'label' => 'Wall 1 Decorations',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_decorations_list',
                    'label' => 'Choose decorations (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Clocks',
                        'Tapestries / textiles on the wall',
                        'Bulletin Boards',
                        'Posters pop culture art',
                        'Diplomas / awards or certificates',
                        'Religious, spiritual or ancestral symbols',
                        'Hanging plants',
                        'Hooks / pegboards',
                        'Paintings',
                        'Family pictures',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_decorations',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_posters_number',
                    'label' => 'Number of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_1_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_1_posters_theme',
                    'label' => 'Theme of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert theme',
                    'condition' => [
                        'field' => 'wall_1_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_1_paintings_number',
                    'label' => 'Number of paintings',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_1_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_1_paintings_color',
                    'label' => 'Paintings color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'wall_1_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_1_paintings_pattern',
                    'label' => 'Paintings pattern / theme',
                    'type' => 'text',
                    'placeholder' => 'Insert pattern / theme',
                    'condition' => [
                        'field' => 'wall_1_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_1_family_pics_frame',
                    'label' => 'Family pictures frame',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'No frame',
                    ],
                    'condition' => [
                        'field' => 'wall_1_decorations_list',
                        'value' => 'Family pictures',
                    ],
                ],
                [
                    'id' => 'wall_1_has_bookshelves',
                    'label' => 'Wall 1 Built-in bookshelves / nook',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_bookshelves_fill',
                    'label' => 'Bookshelf fullness',
                    'type' => 'radio',
                    'options' => [
                        'Full',
                        'Half-full',
                        'Organized',
                        'Scattered',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_bookshelves_contents',
                    'label' => 'Bookshelf contents (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Books',
                        'Other decorative items',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_has_mirror',
                    'label' => 'Wall 1 Mirror',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_mirror_type',
                    'label' => 'Mirror type',
                    'type' => 'radio',
                    'options' => [
                        'Accent mirror',
                        'Full length',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_mirror_condition',
                    'label' => 'Mirror condition',
                    'type' => 'radio',
                    'options' => [
                        'Clear',
                        'Antique / tinted',
                        'Worn / cracked',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_mirror_material',
                    'label' => 'Mirror frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_has_fireplace',
                    'label' => 'Wall 1 Fireplace / Chimney',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_type',
                    'label' => 'Fireplace Type',
                    'type' => 'radio',
                    'options' => [
                        'Working fireplace',
                        'Decorative fireplace',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_lit',
                    'label' => 'Is fire lit?',
                    'type' => 'radio',
                    'options' => [
                        'Fire is lighted',
                        'Fire is not lighted',
                        'Wood in fireplace for lighting',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_material',
                    'label' => 'Fireplace frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood frame',
                        'Metal frame',
                        'Stone frame',
                        'Natural stone',
                        'Smooth Frame (granite/marble)',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_hearth_protector',
                    'label' => 'Fireplace hearth protector',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_mantel',
                    'label' => 'Mantel material',
                    'type' => 'radio',
                    'options' => [
                        'None',
                        'Wood',
                        'Stone',
                        'Other material',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_mantel_items',
                    'label' => 'Items on the mantel (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Pictures',
                        'Plants',
                        'Flowers',
                        'Other items – describe',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_fireplace_mantel_other',
                    'label' => 'Describe other items on mantel',
                    'type' => 'text',
                    'placeholder' => 'Describe items',
                    'condition' => [
                        'field' => 'wall_1_fireplace_mantel_items',
                        'value' => 'Other items – describe',
                    ],
                ],
                [
                    'id' => 'wall_1_has_wall_sconces',
                    'label' => 'Wall 1 Wall sconces / mounted lamps',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_wall_lighting',
                    'label' => 'Wall lighting condition',
                    'type' => 'radio',
                    'options' => [
                        'Direct natural light hits the wall',
                        'Wall in shadow / dimly lit',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_wall_sconces',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_has_hanging_shelves',
                    'label' => 'Wall 1 Hanging shelves',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_hanging_shelves_desc',
                    'label' => 'Describe objects on shelves',
                    'type' => 'text',
                    'placeholder' => 'Describe objects on shelves',
                    'condition' => [
                        'field' => 'wall_1_has_hanging_shelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_has_closet_doors',
                    'label' => 'Wall 1 Closet / Doors / Hidden storage',
                    'type' => 'radio',
                    'options' => [
                        'No closets / hidden storage areas / doors',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_closet_doors_type',
                    'label' => 'Closet / door type',
                    'type' => 'radio',
                    'options' => [
                        'Closet / Door',
                        'Door',
                        'Hidden panel',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_closet_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_has_tv',
                    'label' => 'Wall 1 Television',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_1_tv_size',
                    'label' => 'TV Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'wall_1_has_tv',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2',
                    'label' => '--- WALL 2 ---',
                    'type' => 'text',
                    'placeholder' => 'Optional notes',
                ],
                [
                    'id' => 'wall_2_location',
                    'label' => 'Wall 2 Location',
                    'type' => 'radio',
                    'options' => [
                        'Left of room',
                        'Right of room',
                        'Top of room',
                        'Bottom of room',
                    ],
                ],
                [
                    'id' => 'wall_2_color',
                    'label' => 'Wall 2 Color / Wallpaper',
                    'type' => 'text',
                    'placeholder' => 'Insert color or pattern',
                ],
                [
                    'id' => 'wall_2_texture',
                    'label' => 'Wall 2 Texture',
                    'type' => 'radio',
                    'options' => [
                        'Smooth drywall / plaster',
                        'Exposed brick / stone',
                        'Wood paneling or logs',
                        'Glass wall / floor to ceiling glass',
                        'Fabric',
                        'Concrete / cinderblock',
                        'Unfinished / insulation showing',
                    ],
                ],
                [
                    'id' => 'wall_2_has_decorations',
                    'label' => 'Wall 2 Decorations',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_decorations_list',
                    'label' => 'Choose decorations (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Clocks',
                        'Tapestries / textiles on the wall',
                        'Bulletin Boards',
                        'Posters pop culture art',
                        'Diplomas / awards or certificates',
                        'Religious, spiritual or ancestral symbols',
                        'Hanging plants',
                        'Hooks / pegboards',
                        'Paintings',
                        'Family pictures',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_decorations',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_posters_number',
                    'label' => 'Number of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_2_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_2_posters_theme',
                    'label' => 'Theme of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert theme',
                    'condition' => [
                        'field' => 'wall_2_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_2_paintings_number',
                    'label' => 'Number of paintings',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_2_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_2_paintings_color',
                    'label' => 'Paintings color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'wall_2_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_2_paintings_pattern',
                    'label' => 'Paintings pattern / theme',
                    'type' => 'text',
                    'placeholder' => 'Insert pattern / theme',
                    'condition' => [
                        'field' => 'wall_2_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_2_family_pics_frame',
                    'label' => 'Family pictures frame',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'No frame',
                    ],
                    'condition' => [
                        'field' => 'wall_2_decorations_list',
                        'value' => 'Family pictures',
                    ],
                ],
                [
                    'id' => 'wall_2_has_bookshelves',
                    'label' => 'Wall 2 Built-in bookshelves / nook',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_bookshelves_fill',
                    'label' => 'Bookshelf fullness',
                    'type' => 'radio',
                    'options' => [
                        'Full',
                        'Half-full',
                        'Organized',
                        'Scattered',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_bookshelves_contents',
                    'label' => 'Bookshelf contents (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Books',
                        'Other decorative items',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_has_mirror',
                    'label' => 'Wall 2 Mirror',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_mirror_type',
                    'label' => 'Mirror type',
                    'type' => 'radio',
                    'options' => [
                        'Accent mirror',
                        'Full length',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_mirror_condition',
                    'label' => 'Mirror condition',
                    'type' => 'radio',
                    'options' => [
                        'Clear',
                        'Antique / tinted',
                        'Worn / cracked',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_mirror_material',
                    'label' => 'Mirror frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_has_fireplace',
                    'label' => 'Wall 2 Fireplace / Chimney',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_type',
                    'label' => 'Fireplace Type',
                    'type' => 'radio',
                    'options' => [
                        'Working fireplace',
                        'Decorative fireplace',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_lit',
                    'label' => 'Is fire lit?',
                    'type' => 'radio',
                    'options' => [
                        'Fire is lighted',
                        'Fire is not lighted',
                        'Wood in fireplace for lighting',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_material',
                    'label' => 'Fireplace frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood frame',
                        'Metal frame',
                        'Stone frame',
                        'Natural stone',
                        'Smooth Frame (granite/marble)',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_hearth_protector',
                    'label' => 'Fireplace hearth protector',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_mantel',
                    'label' => 'Mantel material',
                    'type' => 'radio',
                    'options' => [
                        'None',
                        'Wood',
                        'Stone',
                        'Other material',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_mantel_items',
                    'label' => 'Items on the mantel (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Pictures',
                        'Plants',
                        'Flowers',
                        'Other items – describe',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_fireplace_mantel_other',
                    'label' => 'Describe other items on mantel',
                    'type' => 'text',
                    'placeholder' => 'Describe items',
                    'condition' => [
                        'field' => 'wall_2_fireplace_mantel_items',
                        'value' => 'Other items – describe',
                    ],
                ],
                [
                    'id' => 'wall_2_has_wall_sconces',
                    'label' => 'Wall 2 Wall sconces / mounted lamps',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_wall_lighting',
                    'label' => 'Wall lighting condition',
                    'type' => 'radio',
                    'options' => [
                        'Direct natural light hits the wall',
                        'Wall in shadow / dimly lit',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_wall_sconces',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_has_hanging_shelves',
                    'label' => 'Wall 2 Hanging shelves',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_hanging_shelves_desc',
                    'label' => 'Describe objects on shelves',
                    'type' => 'text',
                    'placeholder' => 'Describe objects on shelves',
                    'condition' => [
                        'field' => 'wall_2_has_hanging_shelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_has_closet_doors',
                    'label' => 'Wall 2 Closet / Doors / Hidden storage',
                    'type' => 'radio',
                    'options' => [
                        'No closets / hidden storage areas / doors',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_closet_doors_type',
                    'label' => 'Closet / door type',
                    'type' => 'radio',
                    'options' => [
                        'Closet / Door',
                        'Door',
                        'Hidden panel',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_closet_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_has_tv',
                    'label' => 'Wall 2 Television',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_2_tv_size',
                    'label' => 'TV Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'wall_2_has_tv',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3',
                    'label' => '--- WALL 3 ---',
                    'type' => 'text',
                    'placeholder' => 'Optional notes',
                ],
                [
                    'id' => 'wall_3_location',
                    'label' => 'Wall 3 Location',
                    'type' => 'radio',
                    'options' => [
                        'Left of room',
                        'Right of room',
                        'Top of room',
                        'Bottom of room',
                    ],
                ],
                [
                    'id' => 'wall_3_color',
                    'label' => 'Wall 3 Color / Wallpaper',
                    'type' => 'text',
                    'placeholder' => 'Insert color or pattern',
                ],
                [
                    'id' => 'wall_3_texture',
                    'label' => 'Wall 3 Texture',
                    'type' => 'radio',
                    'options' => [
                        'Smooth drywall / plaster',
                        'Exposed brick / stone',
                        'Wood paneling or logs',
                        'Glass wall / floor to ceiling glass',
                        'Fabric',
                        'Concrete / cinderblock',
                        'Unfinished / insulation showing',
                    ],
                ],
                [
                    'id' => 'wall_3_has_decorations',
                    'label' => 'Wall 3 Decorations',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_decorations_list',
                    'label' => 'Choose decorations (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Clocks',
                        'Tapestries / textiles on the wall',
                        'Bulletin Boards',
                        'Posters pop culture art',
                        'Diplomas / awards or certificates',
                        'Religious, spiritual or ancestral symbols',
                        'Hanging plants',
                        'Hooks / pegboards',
                        'Paintings',
                        'Family pictures',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_decorations',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_posters_number',
                    'label' => 'Number of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_3_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_3_posters_theme',
                    'label' => 'Theme of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert theme',
                    'condition' => [
                        'field' => 'wall_3_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_3_paintings_number',
                    'label' => 'Number of paintings',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_3_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_3_paintings_color',
                    'label' => 'Paintings color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'wall_3_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_3_paintings_pattern',
                    'label' => 'Paintings pattern / theme',
                    'type' => 'text',
                    'placeholder' => 'Insert pattern / theme',
                    'condition' => [
                        'field' => 'wall_3_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_3_family_pics_frame',
                    'label' => 'Family pictures frame',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'No frame',
                    ],
                    'condition' => [
                        'field' => 'wall_3_decorations_list',
                        'value' => 'Family pictures',
                    ],
                ],
                [
                    'id' => 'wall_3_has_bookshelves',
                    'label' => 'Wall 3 Built-in bookshelves / nook',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_bookshelves_fill',
                    'label' => 'Bookshelf fullness',
                    'type' => 'radio',
                    'options' => [
                        'Full',
                        'Half-full',
                        'Organized',
                        'Scattered',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_bookshelves_contents',
                    'label' => 'Bookshelf contents (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Books',
                        'Other decorative items',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_has_mirror',
                    'label' => 'Wall 3 Mirror',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_mirror_type',
                    'label' => 'Mirror type',
                    'type' => 'radio',
                    'options' => [
                        'Accent mirror',
                        'Full length',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_mirror_condition',
                    'label' => 'Mirror condition',
                    'type' => 'radio',
                    'options' => [
                        'Clear',
                        'Antique / tinted',
                        'Worn / cracked',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_mirror_material',
                    'label' => 'Mirror frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_has_fireplace',
                    'label' => 'Wall 3 Fireplace / Chimney',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_type',
                    'label' => 'Fireplace Type',
                    'type' => 'radio',
                    'options' => [
                        'Working fireplace',
                        'Decorative fireplace',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_lit',
                    'label' => 'Is fire lit?',
                    'type' => 'radio',
                    'options' => [
                        'Fire is lighted',
                        'Fire is not lighted',
                        'Wood in fireplace for lighting',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_material',
                    'label' => 'Fireplace frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood frame',
                        'Metal frame',
                        'Stone frame',
                        'Natural stone',
                        'Smooth Frame (granite/marble)',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_hearth_protector',
                    'label' => 'Fireplace hearth protector',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_mantel',
                    'label' => 'Mantel material',
                    'type' => 'radio',
                    'options' => [
                        'None',
                        'Wood',
                        'Stone',
                        'Other material',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_mantel_items',
                    'label' => 'Items on the mantel (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Pictures',
                        'Plants',
                        'Flowers',
                        'Other items – describe',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_fireplace_mantel_other',
                    'label' => 'Describe other items on mantel',
                    'type' => 'text',
                    'placeholder' => 'Describe items',
                    'condition' => [
                        'field' => 'wall_3_fireplace_mantel_items',
                        'value' => 'Other items – describe',
                    ],
                ],
                [
                    'id' => 'wall_3_has_wall_sconces',
                    'label' => 'Wall 3 Wall sconces / mounted lamps',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_wall_lighting',
                    'label' => 'Wall lighting condition',
                    'type' => 'radio',
                    'options' => [
                        'Direct natural light hits the wall',
                        'Wall in shadow / dimly lit',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_wall_sconces',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_has_hanging_shelves',
                    'label' => 'Wall 3 Hanging shelves',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_hanging_shelves_desc',
                    'label' => 'Describe objects on shelves',
                    'type' => 'text',
                    'placeholder' => 'Describe objects on shelves',
                    'condition' => [
                        'field' => 'wall_3_has_hanging_shelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_has_closet_doors',
                    'label' => 'Wall 3 Closet / Doors / Hidden storage',
                    'type' => 'radio',
                    'options' => [
                        'No closets / hidden storage areas / doors',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_closet_doors_type',
                    'label' => 'Closet / door type',
                    'type' => 'radio',
                    'options' => [
                        'Closet / Door',
                        'Door',
                        'Hidden panel',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_closet_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_has_tv',
                    'label' => 'Wall 3 Television',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_3_tv_size',
                    'label' => 'TV Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'wall_3_has_tv',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4',
                    'label' => '--- WALL 4 ---',
                    'type' => 'text',
                    'placeholder' => 'Optional notes',
                ],
                [
                    'id' => 'wall_4_location',
                    'label' => 'Wall 4 Location',
                    'type' => 'radio',
                    'options' => [
                        'Left of room',
                        'Right of room',
                        'Top of room',
                        'Bottom of room',
                    ],
                ],
                [
                    'id' => 'wall_4_color',
                    'label' => 'Wall 4 Color / Wallpaper',
                    'type' => 'text',
                    'placeholder' => 'Insert color or pattern',
                ],
                [
                    'id' => 'wall_4_texture',
                    'label' => 'Wall 4 Texture',
                    'type' => 'radio',
                    'options' => [
                        'Smooth drywall / plaster',
                        'Exposed brick / stone',
                        'Wood paneling or logs',
                        'Glass wall / floor to ceiling glass',
                        'Fabric',
                        'Concrete / cinderblock',
                        'Unfinished / insulation showing',
                    ],
                ],
                [
                    'id' => 'wall_4_has_decorations',
                    'label' => 'Wall 4 Decorations',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_decorations_list',
                    'label' => 'Choose decorations (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Clocks',
                        'Tapestries / textiles on the wall',
                        'Bulletin Boards',
                        'Posters pop culture art',
                        'Diplomas / awards or certificates',
                        'Religious, spiritual or ancestral symbols',
                        'Hanging plants',
                        'Hooks / pegboards',
                        'Paintings',
                        'Family pictures',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_decorations',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_posters_number',
                    'label' => 'Number of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_4_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_4_posters_theme',
                    'label' => 'Theme of posters',
                    'type' => 'text',
                    'placeholder' => 'Insert theme',
                    'condition' => [
                        'field' => 'wall_4_decorations_list',
                        'value' => 'Posters pop culture art',
                    ],
                ],
                [
                    'id' => 'wall_4_paintings_number',
                    'label' => 'Number of paintings',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'wall_4_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_4_paintings_color',
                    'label' => 'Paintings color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'wall_4_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_4_paintings_pattern',
                    'label' => 'Paintings pattern / theme',
                    'type' => 'text',
                    'placeholder' => 'Insert pattern / theme',
                    'condition' => [
                        'field' => 'wall_4_decorations_list',
                        'value' => 'Paintings',
                    ],
                ],
                [
                    'id' => 'wall_4_family_pics_frame',
                    'label' => 'Family pictures frame',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'No frame',
                    ],
                    'condition' => [
                        'field' => 'wall_4_decorations_list',
                        'value' => 'Family pictures',
                    ],
                ],
                [
                    'id' => 'wall_4_has_bookshelves',
                    'label' => 'Wall 4 Built-in bookshelves / nook',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_bookshelves_fill',
                    'label' => 'Bookshelf fullness',
                    'type' => 'radio',
                    'options' => [
                        'Full',
                        'Half-full',
                        'Organized',
                        'Scattered',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_bookshelves_contents',
                    'label' => 'Bookshelf contents (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Books',
                        'Other decorative items',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_bookshelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_has_mirror',
                    'label' => 'Wall 4 Mirror',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_mirror_type',
                    'label' => 'Mirror type',
                    'type' => 'radio',
                    'options' => [
                        'Accent mirror',
                        'Full length',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_mirror_condition',
                    'label' => 'Mirror condition',
                    'type' => 'radio',
                    'options' => [
                        'Clear',
                        'Antique / tinted',
                        'Worn / cracked',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_mirror_material',
                    'label' => 'Mirror frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_mirror',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_has_fireplace',
                    'label' => 'Wall 4 Fireplace / Chimney',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_type',
                    'label' => 'Fireplace Type',
                    'type' => 'radio',
                    'options' => [
                        'Working fireplace',
                        'Decorative fireplace',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_lit',
                    'label' => 'Is fire lit?',
                    'type' => 'radio',
                    'options' => [
                        'Fire is lighted',
                        'Fire is not lighted',
                        'Wood in fireplace for lighting',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_material',
                    'label' => 'Fireplace frame material',
                    'type' => 'radio',
                    'options' => [
                        'Wood frame',
                        'Metal frame',
                        'Stone frame',
                        'Natural stone',
                        'Smooth Frame (granite/marble)',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_hearth_protector',
                    'label' => 'Fireplace hearth protector',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_mantel',
                    'label' => 'Mantel material',
                    'type' => 'radio',
                    'options' => [
                        'None',
                        'Wood',
                        'Stone',
                        'Other material',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_mantel_items',
                    'label' => 'Items on the mantel (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Pictures',
                        'Plants',
                        'Flowers',
                        'Other items – describe',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_fireplace',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_fireplace_mantel_other',
                    'label' => 'Describe other items on mantel',
                    'type' => 'text',
                    'placeholder' => 'Describe items',
                    'condition' => [
                        'field' => 'wall_4_fireplace_mantel_items',
                        'value' => 'Other items – describe',
                    ],
                ],
                [
                    'id' => 'wall_4_has_wall_sconces',
                    'label' => 'Wall 4 Wall sconces / mounted lamps',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_wall_lighting',
                    'label' => 'Wall lighting condition',
                    'type' => 'radio',
                    'options' => [
                        'Direct natural light hits the wall',
                        'Wall in shadow / dimly lit',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_wall_sconces',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_has_hanging_shelves',
                    'label' => 'Wall 4 Hanging shelves',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_hanging_shelves_desc',
                    'label' => 'Describe objects on shelves',
                    'type' => 'text',
                    'placeholder' => 'Describe objects on shelves',
                    'condition' => [
                        'field' => 'wall_4_has_hanging_shelves',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_has_closet_doors',
                    'label' => 'Wall 4 Closet / Doors / Hidden storage',
                    'type' => 'radio',
                    'options' => [
                        'No closets / hidden storage areas / doors',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_closet_doors_type',
                    'label' => 'Closet / door type',
                    'type' => 'radio',
                    'options' => [
                        'Closet / Door',
                        'Door',
                        'Hidden panel',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_closet_doors',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_has_tv',
                    'label' => 'Wall 4 Television',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'wall_4_tv_size',
                    'label' => 'TV Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'wall_4_has_tv',
                        'value' => 'Yes',
                    ],
                ],
            ],
        ],
        [
            'id' => 'furniture',
            'title' => 'FURNITURE',
            'fields' => [
                [
                    'id' => 'has_furniture',
                    'label' => 'Is there furniture in this room?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_enable',
                    'label' => 'Add Furniture Piece #1?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'has_furniture',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_location',
                    'label' => 'Piece #1 Location',
                    'type' => 'radio',
                    'options' => [
                        'Center of the room',
                        'Near / against top wall',
                        'Near / against bottom wall',
                        'Near / against left wall',
                        'Near / against right wall',
                    ],
                    'condition' => [
                        'field' => 'furn_1_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_type',
                    'label' => 'Piece #1 Type',
                    'type' => 'radio',
                    'options' => [
                        'Sofa / Chair / Chaise',
                        'Table',
                        'Rug',
                        'Technology',
                    ],
                    'condition' => [
                        'field' => 'furn_1_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_condition',
                    'label' => 'Piece #1 Condition',
                    'type' => 'radio',
                    'options' => [
                        'Immaculate / new / protected',
                        'Stained / scratched / lived in',
                        'Delicate / need for high care',
                    ],
                    'condition' => [
                        'field' => 'furn_1_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_type',
                    'label' => 'Sofa Type',
                    'type' => 'radio',
                    'options' => [
                        'Chair',
                        'Chaise',
                        'Love seat',
                        'Three-seater',
                        'Four-seater',
                        'Curved / arc',
                        'Sleeper sofa',
                        'Ottoman',
                        'Wing chair',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_material',
                    'label' => 'Sofa Material',
                    'type' => 'radio',
                    'options' => [
                        'Linen',
                        'Velvet',
                        'Wood',
                        'Metal',
                        'Leather',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_color',
                    'label' => 'Sofa Color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_legs',
                    'label' => 'Sofa Legs',
                    'type' => 'radio',
                    'options' => [
                        'No (sunken / floor seating)',
                        'Wood',
                        'Metal',
                        'Straight',
                        'Curved',
                        'Skirted',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_has_pillows',
                    'label' => 'Decorative pillows / throw blankets',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_pillows_number',
                    'label' => 'Number of pillows / throw blankets',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'furn_1_sofa_has_pillows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_pillows_color',
                    'label' => 'Pillows / blankets color or pattern',
                    'type' => 'text',
                    'placeholder' => 'Insert color / pattern',
                    'condition' => [
                        'field' => 'furn_1_sofa_has_pillows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_other_materials',
                    'label' => 'Other materials on the sofa (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Book',
                        'Papers',
                        'Blanket',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_sofa_associated_table',
                    'label' => 'Associated table',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_1_table_type',
                    'label' => 'Table Type',
                    'type' => 'radio',
                    'options' => [
                        'Coffee table',
                        'Side table',
                        'Desk',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_1_table_shape',
                    'label' => 'Table Shape',
                    'type' => 'radio',
                    'options' => [
                        'Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_1_table_material',
                    'label' => 'Table Material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Stone / granite',
                        'Bamboo',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_1_table_size',
                    'label' => 'Table Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_1_table_drawers',
                    'label' => 'Drawers / Storage',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_1_table_drawers_count',
                    'label' => 'Number of drawers / storage',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'furn_1_table_drawers',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_1_table_items',
                    'label' => 'Items on table (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Nothing',
                        'Glasses',
                        'Flowers / plants',
                        'Books',
                        'Drink / food',
                        'Lamp',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_1_table_lamp_style',
                    'label' => 'Lamp style',
                    'type' => 'radio',
                    'options' => [
                        'Modern',
                        'Antique',
                    ],
                    'condition' => [
                        'field' => 'furn_1_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_1_table_lamp_shape',
                    'label' => 'Lamp shape',
                    'type' => 'radio',
                    'options' => [
                        'Straight',
                        'Curved',
                    ],
                    'condition' => [
                        'field' => 'furn_1_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_1_table_lamp_shade',
                    'label' => 'Lamp shade',
                    'type' => 'radio',
                    'options' => [
                        'With lamp shade',
                        'Without lamp shade',
                    ],
                    'condition' => [
                        'field' => 'furn_1_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_1_table_lamp_color',
                    'label' => 'Lamp color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'furn_1_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_1_table_lamp_status',
                    'label' => 'Lamp light status',
                    'type' => 'radio',
                    'options' => [
                        'Light is on',
                        'Light is off',
                    ],
                    'condition' => [
                        'field' => 'furn_1_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_1_rug_type',
                    'label' => 'Rug Type',
                    'type' => 'radio',
                    'options' => [
                        'Hand-knot',
                        'Flat weave',
                        'Hand tufted',
                        'Shag',
                        'Braided / coiled',
                        'Machine made',
                        'Persian',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_1_rug_shape',
                    'label' => 'Rug Shape',
                    'type' => 'radio',
                    'options' => [
                        'Circle / Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_1_rug_color',
                    'label' => 'Rug Color / Pattern',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_1_tech_type',
                    'label' => 'Technology Type',
                    'type' => 'radio',
                    'options' => [
                        'Stereo',
                        'Charging station',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Technology',
                    ],
                ],
                [
                    'id' => 'furn_1_tech_describe',
                    'label' => 'Describe Technology',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'furn_1_type',
                        'value' => 'Technology',
                    ],
                ],
                [
                    'id' => 'furn_2_enable',
                    'label' => 'Add Furniture Piece #2?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'has_furniture',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_location',
                    'label' => 'Piece #2 Location',
                    'type' => 'radio',
                    'options' => [
                        'Center of the room',
                        'Near / against top wall',
                        'Near / against bottom wall',
                        'Near / against left wall',
                        'Near / against right wall',
                    ],
                    'condition' => [
                        'field' => 'furn_2_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_type',
                    'label' => 'Piece #2 Type',
                    'type' => 'radio',
                    'options' => [
                        'Sofa / Chair / Chaise',
                        'Table',
                        'Rug',
                        'Technology',
                    ],
                    'condition' => [
                        'field' => 'furn_2_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_condition',
                    'label' => 'Piece #2 Condition',
                    'type' => 'radio',
                    'options' => [
                        'Immaculate / new / protected',
                        'Stained / scratched / lived in',
                        'Delicate / need for high care',
                    ],
                    'condition' => [
                        'field' => 'furn_2_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_type',
                    'label' => 'Sofa Type',
                    'type' => 'radio',
                    'options' => [
                        'Chair',
                        'Chaise',
                        'Love seat',
                        'Three-seater',
                        'Four-seater',
                        'Curved / arc',
                        'Sleeper sofa',
                        'Ottoman',
                        'Wing chair',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_material',
                    'label' => 'Sofa Material',
                    'type' => 'radio',
                    'options' => [
                        'Linen',
                        'Velvet',
                        'Wood',
                        'Metal',
                        'Leather',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_color',
                    'label' => 'Sofa Color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_legs',
                    'label' => 'Sofa Legs',
                    'type' => 'radio',
                    'options' => [
                        'No (sunken / floor seating)',
                        'Wood',
                        'Metal',
                        'Straight',
                        'Curved',
                        'Skirted',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_has_pillows',
                    'label' => 'Decorative pillows / throw blankets',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_pillows_number',
                    'label' => 'Number of pillows / throw blankets',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'furn_2_sofa_has_pillows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_pillows_color',
                    'label' => 'Pillows / blankets color or pattern',
                    'type' => 'text',
                    'placeholder' => 'Insert color / pattern',
                    'condition' => [
                        'field' => 'furn_2_sofa_has_pillows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_other_materials',
                    'label' => 'Other materials on the sofa (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Book',
                        'Papers',
                        'Blanket',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_sofa_associated_table',
                    'label' => 'Associated table',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_2_table_type',
                    'label' => 'Table Type',
                    'type' => 'radio',
                    'options' => [
                        'Coffee table',
                        'Side table',
                        'Desk',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_2_table_shape',
                    'label' => 'Table Shape',
                    'type' => 'radio',
                    'options' => [
                        'Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_2_table_material',
                    'label' => 'Table Material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Stone / granite',
                        'Bamboo',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_2_table_size',
                    'label' => 'Table Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_2_table_drawers',
                    'label' => 'Drawers / Storage',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_2_table_drawers_count',
                    'label' => 'Number of drawers / storage',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'furn_2_table_drawers',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_2_table_items',
                    'label' => 'Items on table (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Nothing',
                        'Glasses',
                        'Flowers / plants',
                        'Books',
                        'Drink / food',
                        'Lamp',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_2_table_lamp_style',
                    'label' => 'Lamp style',
                    'type' => 'radio',
                    'options' => [
                        'Modern',
                        'Antique',
                    ],
                    'condition' => [
                        'field' => 'furn_2_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_2_table_lamp_shape',
                    'label' => 'Lamp shape',
                    'type' => 'radio',
                    'options' => [
                        'Straight',
                        'Curved',
                    ],
                    'condition' => [
                        'field' => 'furn_2_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_2_table_lamp_shade',
                    'label' => 'Lamp shade',
                    'type' => 'radio',
                    'options' => [
                        'With lamp shade',
                        'Without lamp shade',
                    ],
                    'condition' => [
                        'field' => 'furn_2_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_2_table_lamp_color',
                    'label' => 'Lamp color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'furn_2_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_2_table_lamp_status',
                    'label' => 'Lamp light status',
                    'type' => 'radio',
                    'options' => [
                        'Light is on',
                        'Light is off',
                    ],
                    'condition' => [
                        'field' => 'furn_2_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_2_rug_type',
                    'label' => 'Rug Type',
                    'type' => 'radio',
                    'options' => [
                        'Hand-knot',
                        'Flat weave',
                        'Hand tufted',
                        'Shag',
                        'Braided / coiled',
                        'Machine made',
                        'Persian',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_2_rug_shape',
                    'label' => 'Rug Shape',
                    'type' => 'radio',
                    'options' => [
                        'Circle / Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_2_rug_color',
                    'label' => 'Rug Color / Pattern',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_2_tech_type',
                    'label' => 'Technology Type',
                    'type' => 'radio',
                    'options' => [
                        'Stereo',
                        'Charging station',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Technology',
                    ],
                ],
                [
                    'id' => 'furn_2_tech_describe',
                    'label' => 'Describe Technology',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'furn_2_type',
                        'value' => 'Technology',
                    ],
                ],
                [
                    'id' => 'furn_3_enable',
                    'label' => 'Add Furniture Piece #3?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'has_furniture',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_location',
                    'label' => 'Piece #3 Location',
                    'type' => 'radio',
                    'options' => [
                        'Center of the room',
                        'Near / against top wall',
                        'Near / against bottom wall',
                        'Near / against left wall',
                        'Near / against right wall',
                    ],
                    'condition' => [
                        'field' => 'furn_3_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_type',
                    'label' => 'Piece #3 Type',
                    'type' => 'radio',
                    'options' => [
                        'Sofa / Chair / Chaise',
                        'Table',
                        'Rug',
                        'Technology',
                    ],
                    'condition' => [
                        'field' => 'furn_3_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_condition',
                    'label' => 'Piece #3 Condition',
                    'type' => 'radio',
                    'options' => [
                        'Immaculate / new / protected',
                        'Stained / scratched / lived in',
                        'Delicate / need for high care',
                    ],
                    'condition' => [
                        'field' => 'furn_3_enable',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_type',
                    'label' => 'Sofa Type',
                    'type' => 'radio',
                    'options' => [
                        'Chair',
                        'Chaise',
                        'Love seat',
                        'Three-seater',
                        'Four-seater',
                        'Curved / arc',
                        'Sleeper sofa',
                        'Ottoman',
                        'Wing chair',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_material',
                    'label' => 'Sofa Material',
                    'type' => 'radio',
                    'options' => [
                        'Linen',
                        'Velvet',
                        'Wood',
                        'Metal',
                        'Leather',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_color',
                    'label' => 'Sofa Color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_legs',
                    'label' => 'Sofa Legs',
                    'type' => 'radio',
                    'options' => [
                        'No (sunken / floor seating)',
                        'Wood',
                        'Metal',
                        'Straight',
                        'Curved',
                        'Skirted',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_has_pillows',
                    'label' => 'Decorative pillows / throw blankets',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_pillows_number',
                    'label' => 'Number of pillows / throw blankets',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'furn_3_sofa_has_pillows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_pillows_color',
                    'label' => 'Pillows / blankets color or pattern',
                    'type' => 'text',
                    'placeholder' => 'Insert color / pattern',
                    'condition' => [
                        'field' => 'furn_3_sofa_has_pillows',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_other_materials',
                    'label' => 'Other materials on the sofa (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Book',
                        'Papers',
                        'Blanket',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_sofa_associated_table',
                    'label' => 'Associated table',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Sofa / Chair / Chaise',
                    ],
                ],
                [
                    'id' => 'furn_3_table_type',
                    'label' => 'Table Type',
                    'type' => 'radio',
                    'options' => [
                        'Coffee table',
                        'Side table',
                        'Desk',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_3_table_shape',
                    'label' => 'Table Shape',
                    'type' => 'radio',
                    'options' => [
                        'Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_3_table_material',
                    'label' => 'Table Material',
                    'type' => 'radio',
                    'options' => [
                        'Wood',
                        'Metal',
                        'Stone / granite',
                        'Bamboo',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_3_table_size',
                    'label' => 'Table Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_3_table_drawers',
                    'label' => 'Drawers / Storage',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_3_table_drawers_count',
                    'label' => 'Number of drawers / storage',
                    'type' => 'text',
                    'placeholder' => 'Insert number',
                    'condition' => [
                        'field' => 'furn_3_table_drawers',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'furn_3_table_items',
                    'label' => 'Items on table (Check all that apply)',
                    'type' => 'checkbox',
                    'options' => [
                        'Nothing',
                        'Glasses',
                        'Flowers / plants',
                        'Books',
                        'Drink / food',
                        'Lamp',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Table',
                    ],
                ],
                [
                    'id' => 'furn_3_table_lamp_style',
                    'label' => 'Lamp style',
                    'type' => 'radio',
                    'options' => [
                        'Modern',
                        'Antique',
                    ],
                    'condition' => [
                        'field' => 'furn_3_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_3_table_lamp_shape',
                    'label' => 'Lamp shape',
                    'type' => 'radio',
                    'options' => [
                        'Straight',
                        'Curved',
                    ],
                    'condition' => [
                        'field' => 'furn_3_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_3_table_lamp_shade',
                    'label' => 'Lamp shade',
                    'type' => 'radio',
                    'options' => [
                        'With lamp shade',
                        'Without lamp shade',
                    ],
                    'condition' => [
                        'field' => 'furn_3_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_3_table_lamp_color',
                    'label' => 'Lamp color',
                    'type' => 'text',
                    'placeholder' => 'Insert color',
                    'condition' => [
                        'field' => 'furn_3_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_3_table_lamp_status',
                    'label' => 'Lamp light status',
                    'type' => 'radio',
                    'options' => [
                        'Light is on',
                        'Light is off',
                    ],
                    'condition' => [
                        'field' => 'furn_3_table_items',
                        'value' => 'Lamp',
                    ],
                ],
                [
                    'id' => 'furn_3_rug_type',
                    'label' => 'Rug Type',
                    'type' => 'radio',
                    'options' => [
                        'Hand-knot',
                        'Flat weave',
                        'Hand tufted',
                        'Shag',
                        'Braided / coiled',
                        'Machine made',
                        'Persian',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_3_rug_shape',
                    'label' => 'Rug Shape',
                    'type' => 'radio',
                    'options' => [
                        'Circle / Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_3_rug_color',
                    'label' => 'Rug Color / Pattern',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Rug',
                    ],
                ],
                [
                    'id' => 'furn_3_tech_type',
                    'label' => 'Technology Type',
                    'type' => 'radio',
                    'options' => [
                        'Stereo',
                        'Charging station',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Technology',
                    ],
                ],
                [
                    'id' => 'furn_3_tech_describe',
                    'label' => 'Describe Technology',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'furn_3_type',
                        'value' => 'Technology',
                    ],
                ],
            ],
        ],
        [
            'id' => 'rugs',
            'title' => 'RUGS',
            'fields' => [
                [
                    'id' => 'has_rugs',
                    'label' => 'Are there rugs in this room?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'rugs_type',
                    'label' => 'Rug Type',
                    'type' => 'radio',
                    'options' => [
                        'Hand-knot',
                        'Flat weave',
                        'Hand tufted',
                        'Shag',
                        'Braided / coiled',
                        'Machine made',
                        'Persian',
                    ],
                    'condition' => [
                        'field' => 'has_rugs',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'rugs_shape',
                    'label' => 'Rug Shape',
                    'type' => 'radio',
                    'options' => [
                        'Circle / Oval',
                        'Square',
                        'Rectangular',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'has_rugs',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'rugs_color',
                    'label' => 'Rug Color / Pattern',
                    'type' => 'text',
                    'placeholder' => 'Describe',
                    'condition' => [
                        'field' => 'has_rugs',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'rugs_location',
                    'label' => 'Rug Location',
                    'type' => 'radio',
                    'options' => [
                        'Under furniture',
                        'Next to furniture',
                        'In front of furniture',
                        'Center of room',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'has_rugs',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'rugs_location_details',
                    'label' => 'Location details',
                    'type' => 'text',
                    'placeholder' => 'e.g. Under furniture #1 / in front of sofa',
                    'condition' => [
                        'field' => 'has_rugs',
                        'value' => 'Yes',
                    ],
                ],
            ],
        ],
        [
            'id' => 'technology',
            'title' => 'TECHNOLOGY',
            'fields' => [
                [
                    'id' => 'has_tech',
                    'label' => 'Is there technology in this room?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'tech_type',
                    'label' => 'Tech Type',
                    'type' => 'radio',
                    'options' => [
                        'Stereo',
                        'Charging station',
                        'Other',
                    ],
                    'condition' => [
                        'field' => 'has_tech',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'tech_describe',
                    'label' => 'Describe technology',
                    'type' => 'text',
                    'placeholder' => 'Describe technology item',
                    'condition' => [
                        'field' => 'has_tech',
                        'value' => 'Yes',
                    ],
                ],
            ],
        ],
        [
            'id' => 'plants',
            'title' => 'PLANTS',
            'fields' => [
                [
                    'id' => 'has_plants',
                    'label' => 'Are there plants in this room?',
                    'type' => 'radio',
                    'options' => [
                        'No',
                        'Yes',
                    ],
                ],
                [
                    'id' => 'plants_location',
                    'label' => 'Location',
                    'type' => 'radio',
                    'options' => [
                        'In front / near wall #1',
                        'In front / near wall #2',
                        'In front / near wall #3',
                        'In front / near wall #4',
                    ],
                    'condition' => [
                        'field' => 'has_plants',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'plants_size',
                    'label' => 'Size',
                    'type' => 'radio',
                    'options' => [
                        'Small',
                        'Medium',
                        'Large',
                    ],
                    'condition' => [
                        'field' => 'has_plants',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'plants_condition',
                    'label' => 'Condition',
                    'type' => 'radio',
                    'options' => [
                        'Blossoming and vibrant',
                        'Tired (needs water and attention)',
                        'Dead / almost dead',
                    ],
                    'condition' => [
                        'field' => 'has_plants',
                        'value' => 'Yes',
                    ],
                ],
                [
                    'id' => 'plants_container',
                    'label' => 'Container / pot style and color',
                    'type' => 'text',
                    'placeholder' => 'Describe container / pot color and style',
                    'condition' => [
                        'field' => 'has_plants',
                        'value' => 'Yes',
                    ],
                ],
            ],
        ],
    ]
];
