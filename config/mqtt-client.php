<?php

return [
    'default_connection' => 'mosquitto',

    'connections' => [
        'mosquitto' => [
            'host' => env('MQTT_HOST', '127.0.0.1'),
            'port' => env('MQTT_PORT', 1883),
            'client_id' => env('MQTT_CLIENT_ID', 'laravel-client-' . uniqid()),
            'username' => env('MQTT_USERNAME', null),
            'password' => env('MQTT_PASSWORD', null),
            'clean_session' => true,
            'mqtt_version' => 3,
            'retain' => false,
            'qos' => 0,
        ],
    ],
];
