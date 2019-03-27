<?php
return [
    'code' => [
        'common' => [
            'system_error' => -1,
            'request_success' => 0,
            'request_error' => 1,
            'validate_failed' => 2,
            'create_failed' => 3,
            'update_failed' => 4,
            'delete_failed' => 5,
            'activate_failed' => 6,
        ],
        'auth' => [
            'token_absent' => 12,
            'token_expired' => 13,
            'token_blacklisted' => 14,
            'token_invalid' => 15,
        ],
        'model_not_found' => [
            App\Models\User::class => 55,
        ],
    ],
];
