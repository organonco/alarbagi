<?php

return [
    [
        'key'   => 'sales.seller-orders',
        'name'  => 'marketplace::app.acl.marketplace',
        'route' => 'admin.sales.orders.index',
        'sort'  => 1,
    ], [
        'key'   => 'sales.sellers',
        'name'  => 'marketplace::app.acl.sellers',
        'route' => 'admin.sales.orders.index',
        'sort'  => 1,
    ], [
        'key'   => 'sales.seller-invoices',
        'name'  => 'marketplace::app.acl.invoices',
        'route' => 'admin.sales.sellers.invoice.index',
        'sort'  => 1,
    ], [
        'key'   => 'account',
        'name'  => 'Account',
        'route' => 'admin.account.profile.view',
        'sort'  => 1,
    ], [
        'key'   => 'account.profile',
        'name'  => 'Profile',
        'route' => 'admin.account.profile.view',
        'sort'  => 1,
    ], [
        'key'   => 'account.settings',
        'name'  => 'Settings',
        'route' => 'admin.account.settings.view',
        'sort'  => 1,
    ]

];
