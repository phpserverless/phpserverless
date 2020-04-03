<?php

return [
    "URL_BASE" => "http://localhost:35555",
    // Example: Database with Eloquent, delete if not needed
    'USE_ELOQUENT' => false,
    'DB' => [
        'default_connection' => 'sqlite',
        'connections' => [
            'mysql' => [
                "driver" => 'mysql',
                "host" => '',
                "name" => '',
                "user" => '',
                "pass" => '',
                "port" => '3306',
            ],
            'sqlite' => [
                "driver" => 'sqlite',
                "host" => '',
                "name" => 'database.sqlite',
                "user" => '',
                "pass" => '',
                "port" => '',
            ],
        ],
    ],
];