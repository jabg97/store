<?php
return [
    'login' => env('P2P_LOGIN', ''),
    'tranKey' => env('P2P_TRAN_KEY', ''),
    'url' => env('P2P_URL', ''),
    'type' => env('P2P_TYPE', 'rest'),
    'rest' => [
        'timeout' => env('P2P_TIMEOUT', 15),
        'connect_timeout' => env('P2P_CONNECT_TIMEOUT', 5),
    ],
];
