<?php

return [
    'defaults' => [
        'guard'     => 'customer',
        'passwords' => 'customers',
    ],

    'guards' => [
        'customer' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],

        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],

        'warehouse_admin' => [
            'driver'   => 'session',
            'provider' => 'warehouse_admins',
        ],

        'driver' => [
            'driver'   => 'session',
            'provider' => 'warehouse_admins',
        ],
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model'  => Webkul\Customer\Models\Customer::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => \Organon\Marketplace\Models\Admin::class,
        ],

        'warehouse_admins' => [
            'driver' => 'eloquent',
            'model'  => \Organon\Delivery\Models\WarehouseAdmin::class,
        ],

        'driver' => [
            'driver' => 'eloquent',
            'model'  => \Organon\Delivery\Models\Driver::class,
        ],
    ],

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table'    => 'customer_password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table'    => 'admin_password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],
];
