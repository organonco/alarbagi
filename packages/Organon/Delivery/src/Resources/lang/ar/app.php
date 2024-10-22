<?php

return [
    'area' => [
        'titles' => [
            'index' => "المناطق",
            'create' => "منطقة جديدة",
            'edit' => 'تعديل المنطقة',
            'save' => 'حفظ المنطقة',
            'no-company-assigned' => 'لا يوجد شركة توصيل محددة لهذه المنطقة'
        ],
        'attributes' => [
            'name' => 'اسم المنطقة',
            'info' => 'معلومات إضافية',
            'is_active' => 'نشط',
			'sort' => 'الترتيب ضمن المناطق',
            'is_external' => 'مدارة من قبل شركة وديلي',
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
            'edit' => 'تعديل شركة التوصيل',
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
