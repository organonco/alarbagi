<?php

return [
    [
        'key'    => 'sales.carriers.wadili',
        'name'   => 'shipping-wadili::app.title',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'shipping-wadili::app.inputs.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'shipping-wadili::app.inputs.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'shipping-wadili::app.inputs.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ]
        ]
    ]
];