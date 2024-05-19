<?php

return [
    'model' => [
        'donotdisturb' => [
            'menu' => 'Ne keresd fel',
            'label' => 'Ne keresd fel cím',
            'plural_label' => 'Ne keresd fel címek'
        ],
        'city' => [
            'menu' => 'Települések',
            'label' => 'Település',
            'plural_label' => 'Települések'
        ],
        'event' => [
            'menu' => 'Napló',
            'label' => 'Napló',
            'plural_label' => 'Napló bejegyzések'
        ],
        'publisher' => [
            'menu' => 'Hírnökök',
            'label' => 'Hírnök',
            'plural_label' => 'Hírnökök'
        ],
        'territory' => [
            'menu' => 'Területek',
            'label' => 'Terület',
            'plural_label' => 'Területek'
        ],
        'congregation' => [
            'menu' => 'Gyülekezetek',
            'label' => 'Gyülekezet',
            'plural_label' => 'Gyülekezetek'
        ],
        'user' => [
            'menu' => 'Felhasználók',
            'label' => 'Felhasználó',
            'plural_label' => 'Felhasználók'
        ],
    ],
    'menu' => [
        'group' => [
            'database' => 'Adatok kezelése',
            'admin' => 'Adminisztráció'
        ]
    ],
    'roles' => [
        'field_name' => 'Jogosultság',
        'admin' => 'Adminisztrátor',
        'normal' => 'Normál felhasználó'
    ],
    'fields' => [
        'role'
    ],
    'assigned_to' => ':name munkálja :date óta',
    'last_completed' => ':name munkálta be legutóbb ekkor: :date',
    'not_assigned' => 'Még senki sem munkálta',
    'not_defined' => 'Nem ismert',
    'validation' => [
        'assigned_before_or_equal' => 'A kiutalás nem lehet későbbi mint a mai nap.',
        'completed_before_assigned' => 'A befejezés nem lehet korábbi mint :date',
        'completed_before_or_equal' => 'A bejefezés nem lehet későbbi mint a mai nap.',
        'assigned_before_completed' => 'A kiutalás nem lehet korábbi mint a legutóbbi befejezés napja :date'
    ]
    

];