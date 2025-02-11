<?php

return [
    /**
     * Dashboard.
     */
    [
        'key'        => 'dashboard',
        'name'       => 'admin::app.components.layouts.sidebar.dashboard',
        'route'      => 'admin.dashboard.index',
        'sort'       => 1,
        'icon'       => 'icon-dashboard',
    ],

    /**
     * Sales.
     */
    [
        'key'        => 'orders',
        'name'       => 'admin::app.components.layouts.sidebar.orders',
        'route'      => 'admin.sales.orders.index',
        'sort'       => 2,
        'icon'       => 'icon-order-back',
    ],
    [
        'key'        => 'sellers',
        'name'       => 'marketplace::app.acl.sellers',
        'route'      => 'admin.sales.sellers.index',
        'sort'       => 3,
        'icon'       => 'icon-store',
    ],

    [
        'key' => 'seller-categories',
        'name' => 'admin::app.components.layouts.sidebar.seller_categories',
        'route' => 'admin.seller_categories.index',
        'sort' => 4,
        'icon' => 'icon-sales',
    ],

    [
        'key' => 'banners',
        'name' => 'admin::app.components.layouts.sidebar.banners',
        'route' => 'admin.banners.index',
        'sort' => 4,
        'icon' => 'icon-store',
    ],


    /**
     * 
     */
    [
        'key' => 'marketplace',
        'name' => 'admin::app.components.layouts.sidebar.orders',
        'route' => 'marketplace.admin.orders.index',
        'sort' => 3,
        'icon' => 'icon-order-back',
    ],


    [
        'key'        => 'products',
        'name'       => 'admin::app.components.layouts.sidebar.products',
        'route'      => 'admin.catalog.products.index',
        'sort'       => 5,
        'icon'       => 'icon-product-1',
    ],
    // [
    //     'key'        => 'catalog.categories',
    //     'name'       => 'admin::app.components.layouts.sidebar.categories',
    //     'route'      => 'admin.catalog.categories.index',
    //     'sort'       => 2,
    //     'icon'       => '',
    // ], 
    [
        'key'        => 'attributes',
        'name'       => 'admin::app.components.layouts.sidebar.attributes',
        'route'      => 'admin.catalog.attributes.index',
        'sort'       => 3,
        'icon'       => 'icon-sales',
    ],
    [
        'key'        => 'families',
        'name'       => 'admin::app.components.layouts.sidebar.attribute-families',
        'route'      => 'admin.catalog.families.index',
        'sort'       => 4,
        'icon'       => 'icon-sales',
    ],

    /**
     * Customers.
     */
    [
        'key'        => 'customers',
        'name'       => 'admin::app.components.layouts.sidebar.customers',
        'route'      => 'admin.customers.customers.index',
        'sort'       => 6,
        'icon'       => 'icon-customer-2',
    ],

    [
        'key' => 'areas',
        'name' => 'admin::app.components.layouts.sidebar.areas',
        'route' => 'admin.delivery.area.index',
        'sort' => 7,
        'icon' => 'icon-location',
    ],
    [
        'key' => 'shipping-companies',
        'name' => 'admin::app.components.layouts.sidebar.shipping-companies',
        'route' => 'admin.delivery.shipping-company.index',
        'sort' => 8,
        'icon' => 'icon-ship',
    ],





    /**
     * Settings.
     */
    [
        'key'        => 'settings',
        'name'       => 'admin::app.components.layouts.sidebar.settings',
        'route'      => 'admin.settings.users.index',
        'sort'       => 7,
        'icon'       => 'icon-settings',
        'icon-class' => 'settings-icon',
    ],
    [
        'key'        => 'settings.users',
        'name'       => 'admin::app.components.layouts.sidebar.users',
        'route'      => 'admin.settings.users.index',
        'sort'       => 1,
        'icon'       => '',
    ],
    [
        'key'        => 'settings.roles',
        'name'       => 'admin::app.components.layouts.sidebar.roles',
        'route'      => 'admin.settings.roles.index',
        'sort'       => 2,
        'icon'       => '',
    ],


    /**
     * Configuration.
     */
    [
        'key'        => 'configuration',
        'name'       => 'admin::app.components.layouts.sidebar.configure',
        'route'      => 'admin.configuration.index',
        'sort'       => 8,
        'icon'       => 'icon-configuration',
    ],



    /**
     * CMS.
     */
    [
        'key'        => 'cms',
        'name'       => 'admin::app.components.layouts.sidebar.cms',
        'route'      => 'admin.cms.index',
        'sort'       => 9,
        'icon'       => 'icon-cms',
    ],

    [
        'key' => 'offers',
        'name' => 'admin::app.components.layouts.sidebar.offers',
        'route' => 'admin.offers.index',
        'sort' => 10,
        'icon' => 'icon-promotion',
    ],

    [
        'key' => 'account',
        'name' => 'admin::app.components.layouts.sidebar.account',
        'route' => 'admin.account.profile.view',
        'sort' => 10,
        'icon' => 'icon-customer-2',
    ],

    [
        'key' => 'account.profile',
        'name' => 'admin::app.components.layouts.sidebar.profile',
        'route' => 'admin.account.profile.view',
        'sort' => 1,
        'icon' => 'icon-sales',
    ],
    [
        'key' => 'account.settings',
        'name' => 'admin::app.components.layouts.sidebar.account',
        'route' => 'admin.account.settings.view',
        'sort' => 2,
        'icon' => 'icon-sales',
    ],
];
