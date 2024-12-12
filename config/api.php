<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'bc' => [
        'endpoint' => env('BC_ENDPOINT'),
        'client_id' => env('BC_CLIENT_ID'),
        'client_secret' => env('BC_CLIENT_SECRET')

    ],

    'entra' => [
        'client_id' => env('ENTRA_CLIENT_ID'),
        'client_secret' => env('ENTRA_CLIENT_SECRET'),
        'tenant_id' => env('ENTRA_TENAT_ID'),
        'object_id' => env('ENTRA_OBJECT_ID')
    ]
];
