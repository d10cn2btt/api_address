<?php
return [
    'code' => [
        'common' => [
            'system_error' => 'Error occurred! Please try again later.',
            'request_success' => 'Request succeeded.',
            'request_error' => 'Request failed.',
            'validate_failed' => 'Validation failed! Please check your inputs.',
            'create_failed' => 'Failed to create',
            'update_failed' => 'Failed to update',
            'delete_failed' => 'Failed to delete',
            'activate_failed' => 'Failed to activate',
        ],
        'auth' => [
            'token_absent' => 'Token is required',
            'token_expired' => 'Token is expired',
            'token_blacklisted' => 'Token was in the blacklist',
            'token_invalid' => 'Token is invalid',
        ],
        'model_not_found' => [
            App\Models\User::class => 55,
        ],
    ],
];
