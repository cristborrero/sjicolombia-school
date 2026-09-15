<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | Switch between 'bold' and 'epayco' depending on the client's choice.
    |
    */

    'default' => env('PAYMENT_GATEWAY', 'bold'),

    /*
    |--------------------------------------------------------------------------
    | Bold (bold.co) — Colombian Payment Gateway
    |--------------------------------------------------------------------------
    */

    'bold' => [
        'api_key' => env('BOLD_API_KEY', ''),
        'secret_key' => env('BOLD_SECRET_KEY', ''),
        'base_url' => env('BOLD_BASE_URL', 'https://integrations.api.bold.co'),
        'sandbox' => env('BOLD_SANDBOX', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | ePayco — Colombian Payment Gateway
    |--------------------------------------------------------------------------
    */

    'epayco' => [
        'public_key' => env('EPAYCO_PUBLIC_KEY', ''),
        'private_key' => env('EPAYCO_PRIVATE_KEY', ''),
        'test' => env('EPAYCO_TEST', true),
    ],

];
