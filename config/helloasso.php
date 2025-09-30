<?php

return [
    // Environnement (sandbox ou production)
    'environment' => env('HELLOASSO_ENV', 'sandbox'),

    // Credentials
    'client_id' => env('HELLOASSO_CLIENT_ID'),
    'client_secret' => env('HELLOASSO_CLIENT_SECRET'),
    'organization_slug' => env('HELLOASSO_ORGANIZATION_SLUG', 'calan-couleurs-test'),

    // Cache des tokens
    'cache' => [
        'token_key' => 'helloasso_access_token',
        'token_expiry_key' => 'helloasso_token_expires_at',
        'default_ttl' => 3600,
    ],
];
