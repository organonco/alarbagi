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
        'key'        => 'sales',
        'name'       => 'admin::app.components.layouts.sidebar.sales',
        'route'      => 'admin.sales.sellers.invoice.index',
        'sort'       => 2,
        'icon'       => 'icon-sales',
    ], [
        'key'        => 'sales.seller-invoices',
        'name'       => 'marketplace::app.acl.invoices',
        'route'      => 'admin.sales.sellers.invoice.index',
        'sort'       => 1,
        'icon'       => '',
    ],[
        'key'        => 'sales.orders',
        'name'       => 'admin::app.components.layouts.sidebar.orders',
        'route'      => 'admin.sales.orders.index',
        'sort'       => 2,
        'icon'       => '',
    ], [
        'key'        => 'sales.sellers',
        'name'       => 'marketplace::app.acl.sellers',
        'route'      => 'admin.sales.sellers.index',
        'sort'       => 3,
        'icon'       => '',
    ], 
    
    /**
     * Catalog.
     */
    [
        'key'        => 'catalog',
        'name'       => 'admin::app.components.layouts.sidebar.catalog',
        'route'      => 'admin.catalog.products.index',
        'sort'       => 3,
        'icon'       => 'icon-product',
    ], [
        'key'        => 'catalog.products',
        'name'       => 'admin::app.components.layouts.sidebar.products',
        'route'      => 'admin.catalog.products.index',
        'sort'       => 1,
        'icon'       => '',
    ], [
        'key'        => 'catalog.categories',
        'name'       => 'admin::app.components.layouts.sidebar.categories',
        'route'      => 'admin.catalog.categories.index',
        'sort'       => 2,
        'icon'       => '',
    ], [
        'key'        => 'catalog.attributes',
        'name'       => 'admin::app.components.layouts.sidebar.attributes',
        'route'      => 'admin.catalog.attributes.index',
        'sort'       => 3,
        'icon'       => '',
    ], [
        'key'        => 'catalog.families',
        'name'       => 'admin::app.components.layouts.sidebar.attribute-families',
        'route'      => 'admin.catalog.families.index',
        'sort'       => 4,
        'icon'       => '',
    ],

    /**
     * Customers.
     */
    [
        'key'        => 'customers',
        'name'       => 'admin::app.components.layouts.sidebar.customers',
        'route'      => 'admin.customers.customers.index',
        'sort'       => 4,
        'icon'       => 'icon-customer-2',
    ], 
    
    /**
     * CMS.
     */
    [
        'key'        => 'cms',
        'name'       => 'admin::app.components.layouts.sidebar.cms',
        'route'      => 'admin.cms.index',
        'sort'       => 5,
        'icon'       => 'icon-cms',
    ],
    
    
    /**
     * Reporting.
     */


    // [
    //     'key'        => 'reporting',
    //     'name'       => 'admin::app.components.layouts.sidebar.reporting',
    //     'route'      => 'admin.reporting.sales.index',
    //     'sort'       => 7,
    //     'icon'       => 'icon-report',
    //     'icon-class' => 'report-icon',
    // ], [
    //     'key'        => 'reporting.sales',
    //     'name'       => 'admin::app.components.layouts.sidebar.sales',
    //     'route'      => 'admin.reporting.sales.index',
    //     'sort'       => 1,
    //     'icon'       => '',
    // ], [
    //     'key'        => 'reporting.customers',
    //     'name'       => 'admin::app.components.layouts.sidebar.customers',
    //     'route'      => 'admin.reporting.customers.index',
    //     'sort'       => 2,
    //     'icon'       => '',
    // ], [
    //     'key'        => 'reporting.products',
    //     'name'       => 'admin::app.components.layouts.sidebar.products',
    //     'route'      => 'admin.reporting.products.index',
    //     'sort'       => 3,
    //     'icon'       => '',
    // ],

    /**
     * Settings.
     */
    [
        'key'        => 'settings',
        'name'       => 'admin::app.components.layouts.sidebar.settings',
        'route'      => 'admin.settings.users.index',
        'sort'       => 8,
        'icon'       => 'icon-settings',
        'icon-class' => 'settings-icon',
    ],  [
        'key'        => 'settings.users',
        'name'       => 'admin::app.components.layouts.sidebar.users',
        'route'      => 'admin.settings.users.index',
        'sort'       => 6,
        'icon'       => '',
    ], [
        'key'        => 'settings.roles',
        'name'       => 'admin::app.components.layouts.sidebar.roles',
        'route'      => 'admin.settings.roles.index',
        'sort'       => 7,
        'icon'       => '',
    ],

    /**
     * Configuration.
     */
    [
        'key'        => 'configuration',
        'name'       => 'admin::app.components.layouts.sidebar.configure',
        'route'      => 'admin.configuration.index',
        'sort'       => 9,
        'icon'       => 'icon-configuration',
    ]
];
