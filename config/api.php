<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Limit per page
    |--------------------------------------------------------------------------
    |
    | This is the maximum number of items the API can return per page.
    |
    */
    'max_limit_per_page' => env('MAX_API_LIMIT_PER_PAGE', 100),

    /*
    |--------------------------------------------------------------------------
    | Format of the timestamp
    |--------------------------------------------------------------------------
    |
    | This defines the format of the timestamp that is returned on most API
    | calls.
    |
    */
    'timestamp_format' => env('API_TIMESTAMP_FORMAT', 'Y-m-d H:i:s'),

    /*
    |--------------------------------------------------------------------------
    | Format of the date timestamp
    |--------------------------------------------------------------------------
    |
    | This defines the format of the date that is returned on some API calls
    | when it requires a date only.
    |
    */
    'date_timestamp_format' => env('API_DATE_TIMESTAMP_FORMAT', 'Y-m-d'),

    /*
    |--------------------------------------------------------------------------
    | Error codes for the API
    |--------------------------------------------------------------------------
    */
    'error_codes' => [
        '30' => 'The limit parameter is too big',
        '31' => 'The resource has not been found',
        '32' => 'Error while trying to save the data',
        '33' => 'Too many parameters',
        '34' => 'Too many attempts, please slow down the request',
        '35' => 'This email address is already taken',
        '36' => 'Problems parsing JSON',
        '37' => 'Date should be in the future',
        '38' => 'Invalid query',
        '39' => 'Invalid parameters.',
        '40' => 'Not authorized',
    ],
];
