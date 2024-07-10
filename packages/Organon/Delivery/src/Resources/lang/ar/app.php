<?php

return [
    'area' => [
        'titles' => [
            'index' => "المناطق",
            'create' => "منطقة جديدة",
            'save' => 'حفظ المنطقة'
        ],
        'attributes' => [
            'name' => 'اسم المنطقة',
            'info' => 'معلومات إضافية',
            'is_active' => 'نشط'
        ],
        'is_active' => [
            false => 'لا',
            true => 'نعم'
        ]
    ],
    'shipping-company' => [
        'titles' => [
            'index' => "شركات التوصيل",
            'create' => "شركة توصيل جديدة",
            'save' => 'حفظ شركة التوصيل'
        ],
        'attributes' => [
            'name' => 'اسم شركة التوصيل',
            'username' => 'اسم المستخدم', 
            'password' => 'كلمة المرور', 
            'info' => 'معلومات إضافية',
            'is_active' => 'نشط',
            'area_id' => 'المنطقة'
        ],
        'is_active' => [
            false => 'لا',
            true => 'نعم'
        ]
    ]
];
