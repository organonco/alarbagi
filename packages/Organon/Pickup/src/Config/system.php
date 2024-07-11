<?php

return [
    [
        'key'    => 'sales.carriers.pickup',
        'name'   => 'shipping-pickup::app.title',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'shipping-pickup::app.inputs.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'shipping-pickup::app.inputs.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'shipping-pickup::app.inputs.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ]
        ]
    ]
];