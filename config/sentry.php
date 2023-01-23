<?php

return [

    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    // defaults
    'breadcrumbs' => [
        // Capture Laravel logs in breadcrumbs
        'logs' => true,
        // Capture SQL queries in breadcrumbs
        'sql_queries' => true,
        // Capture bindings on SQL queries logged in breadcrumbs
        'sql_bindings' => true,
        // Capture queue job information in breadcrumbs
        'queue_info' => true,
        // Capture command information in breadcrumbs
        'command_info' => true,
    ],

    // @see: https://docs.sentry.io/error-reporting/configuration/?platform=php#send-default-pii
    // certain personally identifiable User information is added by active integrations
    'send_default_pii' => true,

];
