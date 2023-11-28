<?php
return [
    'acl' => [
        'marketplace' => 'Marketplace',
        'sellers' => 'Sellers'
    ],
    'register' => [
        'title' => [
            'seller' => 'Become A Seller',
            'customer' => 'Become A Customer'
        ],
        'desc' => [
            'seller' => 'Grow your business with our online selling platform!',
            'customer' => 'Browse our wide selection of products today!'
        ],
        'labels' => [
            'shop_name' => 'Shop Name',
            'shop_bio' => 'Shop Bio',
            'address' => 'Shop Address',
            'slug' => 'Shop Slug'
        ],
        'flash_messages' => [
            'pending_approval' => 'Your account is now pending approval from the Admins'
        ],
    ],
    'login' => [
        'labels' => [
            'are_you_a_seller' => 'Are you a Seller?',
            'sign_in_here' => 'Sign in Here',
        ]
    ],
    'catalog' => [
        'products' => [
            'index' => [
                'datagrid' => [
                    'seller_name' => 'Seller Name',
                    'seller_name_value' => 'Seller Name: :value',
                ]
            ]
        ]
    ],
    "seller-order" => [
        'statuses' => [
            'PENDING' => [
                'label' => 'Pending',
                'class' => 'pending'
            ],
            'APPROVED' => [
                'label' => 'Approved',
                'class' => 'processing'
            ],
            'CANCELLED' => [
                'label' => 'Cancelled',
                'class' => 'info'
            ],
            'PICKED_UP' => [
                'label' => 'Picked Up',
                'class' => 'closed'
            ],
            'shipped' => [
                'label' => 'Shipped',
                'class' => 'info'
            ]
        ]
    ],
    "seller" => [
        'statuses' => [
            'PENDING' => [
                'label' => 'Pending Approval',
                'class' => 'pending'
            ],
            'ACTIVE' => [
                'label' => 'Active',
                'class' => 'processing'
            ],
            'DEACTIVATED' => [
                'label' => 'Deactivated',
                'class' => 'info'
            ],
        ]
    ],
    'admin' => [
        'orders' => [
            'index' => [
                'page-title' => 'Orders',
                'datagrid' => [
                    'order-increment-id' => "Order ID",
                    'status' => "Status",
                    'customer-name' => "Customer",
                    'subtotal' => "Subtotal",
                    'number_of_products' => "# of Products",
                    'customer_email' => "Customer Email",
                    'customer_address' => "Customer Address",
                ]
            ],
            'view' => [
                'approve' => 'Approve',
                'cancel' => 'Cancel',
                'cancel-msg' => 'Are you sure you want to cancel this order?',
                'approve-msg' => 'Are you sure you want to approve this order?',
            ]
        ],
        'sellers' => [
            'index' => [
                'page-title' => "Sellers",
                'datagrid' => [
                    'shop-name' => 'Shop Name',
                    'email' => 'Contact Email',
                    'status' => "Status",
                    'slug' => 'Slug'
                ]
            ]
        ]
    ],
    'settings' => [
        'messages' => [
            'user-pending' => "Your account is pending approval from admins",
            'user-deactivated' => "Your account has been deactivated"
        ]
    ]
];