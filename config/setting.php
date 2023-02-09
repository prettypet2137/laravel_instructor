<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable auto save
    |--------------------------------------------------------------------------
    |
    | Auto-save every time the application shuts down
    |
    */
    'auto_save'         => false,

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Options for caching. Set whether to enable cache, its key, time to live
    | in seconds and whether to auto clear after save.
    |
    */
    'cache' => [
        'enabled'       => false,
        'key'           => 'setting',
        'ttl'           => 3600,
        'auto_clear'    => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Setting driver
    |--------------------------------------------------------------------------
    |
    | Select where to store the settings.
    |
    | Supported: "database", "json", "memory"
    |
    */
    'driver'            => 'database',

    /*
    |--------------------------------------------------------------------------
    | Database driver
    |--------------------------------------------------------------------------
    |
    | Options for database driver. Enter which connection to use, null means
    | the default connection. Set the table and column names.
    |
    */
    'database' => [
        'connection'    => null,
        'table'         => 'settings',
        'key'           => 'key',
        'value'         => 'value',
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON driver
    |--------------------------------------------------------------------------
    |
    | Options for json driver. Enter the full path to the .json file.
    |
    */
    'json' => [
        'path'          => storage_path() . '/settings.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Override application config values
    |--------------------------------------------------------------------------
    |
    | If defined, settings package will override these config values.
    |
    | Sample:
    |   "app.locale" => "settings.locale",
    |
    */

    'override'               => [
        'app.name'                        => 'APP_NAME',
        'app.SITE_DESCRIPTION'          => 'SITE_DESCRIPTION',
        'app.SITE_KEYWORDS'             => 'SITE_KEYWORDS',
        'app.SITE_SLOGAN'             => 'SITE_SLOGAN',
        'app.logo_favicon'                   => 'logo_favicon',
        'app.logo_frontend'             => 'logo_frontend',
        'app.logo_light'             => 'logo_light',
        'app.SITE_LANDING'              => 'SITE_LANDING',
        'app.CURRENCY_CODE'             => 'CURRENCY_CODE',
        'app.CURRENCY_SYMBOL'           => 'CURRENCY_SYMBOL',
        'app.DISABLE_LANDING'           => 'DISABLE_LANDING',
        'app.GOOGLE_ANALYTICS'          => 'GOOGLE_ANALYTICS',
        'app.blockscss'          => 'blockscss',
        'events.EVENT_EMAIL_CONTENT'          => 'EVENT_EMAIL_CONTENT',

        // saas
        'saas.DOMAIN_RENDER_SERVER'=> 'DOMAIN_RENDER_SERVER',
        'saas.no_events' => 'no_events',
        'saas.no_guests' => 'no_guests',
        'saas.remove_branding'  => 'remove_branding',
        'saas.unlimited_premium_theme'=> 'unlimited_premium_theme',
        'saas.custom_domain'=> 'custom_domain',
        'saas.custom_header_footer'=> 'custom_header_footer',
        'saas.custom_fonts'=> 'custom_fonts',

        'app.ads_home_page_below_jobs_search' => 'ads_home_page_below_jobs_search',
        'app.ads_footer_layout_themes' => 'ads_footer_layout_themes',
        
        'mail.host'                       => 'MAIL_HOST',
        'mail.port'                       => 'MAIL_PORT',
        'mail.from.address'               => 'MAIL_FROM_ADDRESS',
        'mail.from.name'                  => 'MAIL_FROM_NAME',
        'mail.encryption'                 => 'MAIL_ENCRYPTION',
        'mail.username'                   => 'MAIL_USERNAME',
        'mail.password'                   => 'MAIL_PASSWORD',
        'app.SERVER_IP'                   => 'SERVER_IP',
        'app.APP_LOCALE'                      => 'APP_LOCALE',
        'app.url'                         => 'APP_URL',
        'app.timezone'                    => 'APP_TIMEZONE',

        'recaptcha.api_site_key'          => 'RECAPTCHA_SITE_KEY',
        'recaptcha.api_secret_key'        => 'RECAPTCHA_SECRET_KEY',

        'services.facebook.client_id'     => 'FACEBOOK_CLIENT_ID',
        'services.facebook.client_secret' => 'FACEBOOK_CLIENT_SECRET',

        'services.google.client_id'     => 'GOOGLE_CLIENT_ID',
        'services.google.client_secret' => 'GOOGLE_CLIENT_SECRET',

        'services.stripe.key'             => 'STRIPE_KEY',
        'services.stripe.secret'          => 'STRIPE_SECRET',
        'services.stripe.webhook.secret'          => 'STRIPE_WEBHOOK_SECRET',

        'services.paypal.client_id'       => 'PAYPAL_CLIENT_ID',
        'services.paypal.secret'          => 'PAYPAL_SECRET',
        'services.paypal.sandbox'         => 'PAYPAL_SANDBOX',

    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------------------
    |
    | Define fallback settings to be used in case the default is null
    |
    | Sample:
    |   "currency" => "USD",
    |
    */
    'fallback' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Required Extra Columns
    |--------------------------------------------------------------------------
    |
    | The list of columns required to be set up
    |
    | Sample:
    |   "user_id",
    |   "tenant_id",
    |
    */
    'required_extra_columns' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption
    |--------------------------------------------------------------------------
    |
    | Define the keys which should be crypt automatically.
    |
    | Sample:
    |   "payment.key"
    |
    */
   'encrypted_keys' => [

   ],

];
