<?php

return [
    'pickup' => [
        'code'         => 'pickup',
        'title'        => 'بدون توصيل',
        'description'  => 'يتم التقاط المنتجات من قبل الزبون',
        'active'       => true,
        'default_rate' => '10',
        'type'         => 'per_unit',
        'class'        => 'Organon\Pickup\Carriers\Pickup',
    ],
];