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
            ],
            'view' => [
                'sold_by' => 'Sold By: :name'
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
            ],
            'CANCELLED_BY_CUSTOMER' => [
                'label' => 'Cancelled By Customer',
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
            'PAUSED' => [
                'label' => 'Paused by shop',
                'class' => 'processing'
            ]
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
                    'slug' => 'Slug',
                ]
            ],
            'view' => [
                'activate' => 'Activate',
                'deactivate' => 'Deactivate',
                'activate-msg' => 'Are you sure you want to activate this user? The user will be able to publish products directly to the website',
                'deactivate-msg' => 'Are you sure you want to deactivate this user? The user will not be able to login until they get re-activated',
            ]
        ],
        'account' => [
            'profile' => [
                'page-title' => 'Shop Profile',
                'labels' => [
                    'name' => 'Shop Name',
                    "description" => 'Shop Bio',
                    "slug" => 'Shop Slug',
                    "logo" => "Shop Logo",
                    "address" => "Shop Address",
                    "deliver_by" => "Deliver By (Minutes)",
                    "payment_method" => "Payment Method",
                    "email" => "Email",
                ],
                'actions' => [
                    'update' => "Update Profile Data"
                ],
                'flash_messages' => [
                    'updated' => 'Profile Was Updated Successfully',
                ],
            ],
            'settings' => [
                'page-title' => 'Shop Settings',
                'labels' => [
                    'current' => 'Current Password',
                    'new' => 'New Password',
                    'confirmation' => 'New Password Again',
                    'payment-method' => 'Payment Method',
                    'deliver-by' => 'Delivery By (Days)',
                    'active-status' => 'Active',
                ],
                'flash_messages' => [
                    'password-updated' => 'Password Was Updated Successfully',
                    'payment-method-updated' => 'Payment Method Was Updated Successfully',
                ],
                'actions' => [
                    'update-password' => 'Update Password',
                    'update-payment-method' => 'Update Payment Method',
                    'update-account-status' => 'Update Account Status',
                ]
            ]
        ]
    ],
    'settings' => [
        'messages' => [
            'user-pending' => "Your account is pending approval from admins",
            'user-deactivated' => "Your account has been deactivated",
            'account-deactivated-msg' => 'Your account has been deactivated by admins. Your products will not be visible to customers.',
            'account-paused-msg' => 'Your account is inactive. Your products will not be visible to customers. Go to settings to reactivate it'
        ]
    ]
];