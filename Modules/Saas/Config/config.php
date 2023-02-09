<?php
return [
    'id' => 'saas',
    'name' => 'Saas',
    'author' => 'TechFago',
    'author_uri' => 'https://techfago.com',
    'version' => '1.0',
    'desc' => '',
    'menu' => [
        'siderbar_position' => 80, // Need config !=0
        'siderbar_admin_position' => 80, // Need config !=0
        'payment_skins_position' => 1,
        'setting_payment_position' => 2,
    ],
    // default feature
    'no_events' => 1,
    'no_guests' => 1,
    'remove_branding'  =>false,
    'unlimited_premium_theme'=> false,
    'custom_domain'=> false,
    'custom_header_footer'=> false,
    'custom_fonts' => false,
    'DOMAIN_RENDER_SERVER' => 'page.startevent.test',
    // back
    'PERMISSIONS'                     => [
        'remove_branding'  => __('Remove branding on event public link'),
        'unlimited_premium_theme'=> __('Unlimited premium theme event'),
        'custom_fonts'=> __('Unlimited custom fonts'),
        'custom_header_footer'=> __('Customize header and footer for event'),
        'custom_domain'=> __('Customize domain for event'),
    ],
    'payment' =>    [
        'paypal' => [
            'gateway_name' => 'paypal',
            'class_payment_name' => Modules\Saas\Http\Controllers\Payment\PayPal::class,
        ],
        'stripe' => [
            'gateway_name' => 'stripe',
            'class_payment_name' => Modules\Saas\Http\Controllers\Payment\Stripe::class,
        ],
    ]
];

