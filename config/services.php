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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'replicate' => [
        'api_token' => env('REPLICATE_API_TOKEN') ?: base64_decode('cjhfODdXY2tkVDlCTk1XbTJEVjdEQkh4aTZsVk9PaEtUWjE3NHpWRQ=='),
        'model' => env('REPLICATE_IMAGE_MODEL', env('REPLICATE_MODEL', 'black-forest-labs/flux-2-pro')),
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY') ?: base64_decode('QVEuQWI4Uk42S3JmWGFjNkNxN2lEXzM0ZGhocnZ2YzJMbk1iSEhScVpadWhIX19YdzhST0E='),
    ],

];
