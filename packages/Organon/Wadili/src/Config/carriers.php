<?php

return [
    'wadili' => [
        'code'         => 'wadili',
        'title'        => 'مع توصيل',
        'description'  => 'يتم التوصيل مع شركة وديلي',
        'active'       => true,
        'default_rate' => '10',
        'type'         => 'per_unit',
        'class'        => 'Organon\Wadili\Carriers\Wadili',
        'icon' => 'icon-product'
    ],
];