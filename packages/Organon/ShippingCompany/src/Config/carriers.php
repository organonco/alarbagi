<?php

return [
    'shippingcompany' => [
        'code'         => 'shippingcompany',
        'title'        => 'مع توصيل',
        'description'  => 'يتم شحن المنتجات القابلة للتوصيل مع شركة التوصيل التابعة للمنطقة',
        'active'       => true,
        'default_rate' => '10',
        'type'         => 'per_unit',
        'class'        => 'Organon\ShippingCompany\Carriers\ShippingCompany',
        'icon' => 'icon-flate-rate'
    ],
];