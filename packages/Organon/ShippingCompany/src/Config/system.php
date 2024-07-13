<?php

return [
    [
        'key'    => 'sales.carriers.shippingcompany',
        'name'   => 'shipping-company::app.title',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'shipping-company::app.inputs.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'shipping-company::app.inputs.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'shipping-company::app.inputs.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ]
        ]
    ]
];