<?php

return [
    'user' => [
        'model' => 'App\User',
    ],
    'broadcast' => [
        'enable' => true,
        'app_name' => 'LBSN',
        'pusher' => [
            'app_id' => '612380',
            'app_key' => '8d537a15588a7492cacc',
            'app_secret' => 'b82f7f7a11e995138a08',
            'options' => [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        ],
    ],
];
