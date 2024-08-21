<?php
return [
    'general' => [
        'save' => 'حفظ'
    ],
    'acl' => [
        'marketplace' => 'المتاجر',
        'sellers' => 'التجار',
        'invoices' => 'فواتير التجار'
    ],
    'register' => [
        'title' => [
            'seller' => 'التسجيل كبائع',
            'customer' => 'التسجيل كمستخدم'
        ],
        'desc' => [
            'seller' => 'ضاعف مبيعاتك عبر منصة العربجي !',
            'customer' => ['first' => 'تصفح أسواق العربجي المتنوعة أو', 'last' => 'سجل كبائع']
        ],
        'labels' => [
            'shop_name' => 'اسم المتجر',
            'shop_bio' => 'وصف المتجر',
            'address' => 'عنوان المتجر',
            'slug' => 'اختصار الرابط (slug)',
            'area_id' => 'المنطقة',
            'parent_category_select' => 'التصنيف الأساسي',
            'seller_category_id' => 'التصنيف الفرعي',
			'opening_time' => 'وقت الدوام',
			'opening_days' => 'أيام الدوام',
			'owner_name' => 'اسم صاحب العلاقة'
        ],
        'flash_messages' => [
            'pending_approval' => 'حسابك الآن قيد التدقيق من قبل مدراء الموقع',
            'pending-verification' => 'الرجاء التحقق من البريد الالكتروني الخاص بك لتأكيد الحساب'
        ],
    ],
    'login' => [
        'labels' => [
            'are_you_a_seller' => 'هل أنت بائع؟',
            'sign_in_here' => 'تسجيل الدخول كبائع',
        ]
    ],
    'catalog' => [
        'products' => [
            'index' => [
                'datagrid' => [
                    'seller_name' => 'اسم البائع',
                    'seller_name_value' => 'اسم البائع: :value',
                ]
            ],
            'view' => [
                'sold_by' => 'تباع من قبل: :name',
                'available' => ':qty قطع متاحة',
                'out_of_stock' => 'غير متاح',
                'preperation_time' => "وقت التحضير",
                'deliverable' => [
                    'true' => 'قابل للتوصيل',
                    'false' => 'غير قابل للتوصيل',
                ], 
                'preperation_time_none' => "فوري",
                'preperation_time_hours' => ":count ساعات",
                'preperation_time_minutes' => ":count دقيقة",
                'preperation_time_days' => ":count أيام"
            ]
        ]
    ],
    "seller-order" => [
        'statuses' => [
            'PENDING' => [
                'label' => 'قيد التدقيق',
                'class' => 'pending'
            ],
            'APPROVED' => [
                'label' => 'مقبول',
                'class' => 'processing'
            ],
            'CANCELLED' => [
                'label' => 'ملغى من قبل المشتري',
                'class' => 'info'
            ],
            'PICKED_UP' => [
                'label' => 'مستلم من قبل المنصة',
                'class' => 'closed'
            ],
            'SHIPPED' => [
                'label' => 'مستلم من قبل المشتري',
                'class' => 'info'
            ],
            'CANCELLED_BY_SELLER' => [
                'label' => 'ملغى من قبل البائع',
                'class' => 'info'
            ]
        ]
    ],
    "seller" => [
        'statuses' => [
			'UNVERIFIED' => [
                'label' => 'بانتظار تأكيد الايميل',
                'class' => 'pending'
            ],
            'PENDING' => [
                'label' => 'قيد التدقيق',
                'class' => 'pending'
            ],
            'ACTIVE' => [
                'label' => 'فعّال',
                'class' => 'processing'
            ],
            'DEACTIVATED' => [
                'label' => 'ملغى تفعيله من قبل الإدارة',
                'class' => 'info'
            ],
            'PAUSED' => [
                'label' => 'متوقف مؤقتاً',
                'class' => 'processing'
            ]
        ]
    ],
    "seller-invoice" => [
        'statuses' => [
            'PENDING' => [
                'label' => 'قيد التدقيق',
                'class' => 'pending'
            ], 'DRAFT' => [
                'label' => 'مسودة',
                'class' => 'info'
            ], 'APPROVED' => [
                'label' => 'مقبول',
                'class' => 'processing'
            ], 'REJECTED' => [
                'label' => 'مرفوض',
                'class' => 'cancelled'
            ], 'ISSUED' => [
                'label' => 'مدفوع',
                'class' => 'processing'
            ],
        ]
    ],
    'admin' => [
        'orders' => [
            'index' => [
                'page-title' => 'الطلبات',
                'datagrid' => [
                    'order-increment-id' => "معرف الطلب",
                    'status' => "الحالة",
                    'customer-name' => "المشتري",
                    'subtotal' => "الإجمالي الفرعي",
                    'number_of_products' => "عدد المنتجات",
                    'customer_email' => "بريد المشتري الالكتروني",
                    'customer_address' => "عنوان المشتري",
                    'shipping_title' => 'التوصيل',
                    'area' => 'المنطقة'
                ]
            ],
            'view' => [
                'approve' => 'قبول',
                'cancel' => 'الغاء',
                'cancel-msg' => 'هل أنت متأكد بأنك تريد الغاء هذا الطلب؟',
                'approve-msg' => 'هل أنت متأكد بأنك تريد قبول هذا الطلب؟',
            ]
        ],
        'sellers' => [
            'index' => [
                'page-title' => "البائعين",
                'datagrid' => [
                    'shop-name' => 'اسم المتجر',
                    'email' => 'البريد الالكتروني',
                    'status' => "الحالة",
                    'phone' => 'رقم الهاتف',
                    'area' => 'المنطقة'
                ]
            ],
            'view' => [
                'activate' => 'تفعيل',
                'deactivate' => 'الغاء تفعيل',
                'generate-invoice' => 'انشاء فاتورة',
                'edit-invoice' => 'تعديل الفاتورة في المسودة',
                'activate-msg' => 'هل أنت متأكد من تفعيل هذا التاجر؟ سيكون بإمكان التاجر تفعيل منتجاته لتعرض على الموقع بشكل مباشر',
                'deactivate-msg' => 'هل أنت متأكد من إلغاء تفعيل هذا التاجر؟ سيتم اخفاء منتجاته من الموقع',
                'generate-invoice-msg' => 'هل أنت متأكد من إنشاء فاتورة؟ يمكنك مراجعة الفاتورة وتعديلها قبل ارسالها إلى التاجر من خلال الصفحة التالية.',
            ]
        ],
        'account' => [
            'profile' => [
                'page-title' => 'الملف الشخصي',
                'labels' => [
                    'name' => 'اسم المتجر',
                    "description" => 'وصف المتجر',
                    "logo" => "الصورة الشخصية للمتجر",
                    "address" => "عنوان المتجر بالتفصيل",
                    "email" => "البريد الالكتروني",
                    "landline" => "الرقم الأرضي",
                    'phone' => 'رقم الهاتف',
                    'area_name' => 'المنطقة',
					'opening_days' => 'أيام الدوام',
					'opening_time' => 'أوقات الدوام',
					'owner_name' => 'اسم صاحب العلاقة',
                ],
                'actions' => [
                    'update' => "تحديث معلومات الملف الشخصي"
                ],
                'flash_messages' => [
                    'updated' => 'تم تحديث المعلومات',
                ],
            ],
            'settings' => [
                'page-title' => 'اعدادات المتجر',
                'labels' => [
                    'current' => 'كلمة المرور الحالية',
                    'new' => 'كلمة المرور الجديدة',
                    'confirmation' => 'إعادة كلمة المرور الجديدة',
                    'payment-method' => 'طريقة الدفع',
                    "deliver-by" => "يتم التوصيل خلال (بالأيام)",
                    'active-status' => 'فعّال',
                ],
                'flash_messages' => [
                    'password-updated' => 'تم تغيير كلمة المرور بنجاح',
                    'payment-method-updated' => 'تم تغيير طريقة الدفع بنجاح',
                ],
                'actions' => [
                    'update-password' => 'تغيير كلمة المرور',
                    'update-payment-method' => 'تحديث طريقة الدفع',
                    'update-account-status' => 'تحديث حالة الحساب',
                ]
            ],
        ],
        'offers' => [
            'index' => [
                'title' => 'العروض الخاصة',
                'datagrid' => [
                    'title' => 'العنوان',
                    'post' => 'النص',
                    'status' => 'الحالة',
                    'image' => 'الصورة',
                ],
            ],
            'create' => [
                'title' => 'إنشاء عرض',
                'attributes' => [
                    'title' => 'العنوان',
                    'post' => 'النص',
                    'image' => 'الصورة',
                    'status' => 'الحالة'
                ]
            ],
            'edit' => [
                'title' => 'تعديل العرض',
                'attributes' => [
                    'title' => 'العنوان',
                    'post' => 'النص',
                    'image' => 'الصورة',
                    'status' => 'الحالة'
                ]
            ],
            'preview' => [
                'title' => 'معاينة العرض',
                'edit' => 'تعديل',
            ]
        ],
        'seller_categories' => [
            'index' => [
                'title' => 'فئات التجار',
                'datagrid' => [
                    'name' => 'الاسم',
                    'parent' => 'الأب',
                ],
            ], 'create' => [
                'title' => 'إنشاء فئة تاجر',
                'attributes' => [
                    'name' => 'اسم الفئة',
                    'parent' => 'الفئة الأب',
                    'banner' => 'البنر الإعلاني',
                    'image' => 'الصورة',
					'sort' => 'الترتيب ضمن الفئات'
                ]
            ],
            'edit' => [
                'title' => 'تعديل فئة التاجر'
            ]
        ]
    ],
    'settings' => [
        'messages' => [
            'user-pending' => "يتم تدقيق حسابك من قبل الإدارة",
            'user-deactivated' => "تم الغاء حسابك من قبل الإدارة",
            'account-deactivated-msg' => 'تم الغاء حسابك من قبل الإدارة، منتجاتك لن تظهر على الموقع',
            'account-paused-msg' => 'حسابك متوقف مؤقتاً، منتجاتك لن تظهر على الموقع، يمكنك تفعيل الحساب مجدداً من الإعدادات',
            'account-pending-msg' => 'حسابك قيد التدقيق من قبل الإدارة، يمكنك إضافة منتجاتك لكنها لن تظهر على الموقع.'
        ]
    ]
];
