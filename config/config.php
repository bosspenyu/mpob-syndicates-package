<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'syndicates' => [
        'driver' => 'mysql',
        'url' => env('DATABASE_SYNDICATES_URL'),
        'host' => env('DB_SYNDICATES_HOST', '127.0.0.1'),
        'port' => env('DB_SYNDICATES_PORT', '3306'),
        'database' => env('DB_SYNDICATES_DATABASE', 'forge'),
        'username' => env('DB_SYNDICATES_USERNAME', 'forge'),
        'password' => env('DB_SYNDICATES_PASSWORD', ''),
        'unix_socket' => env('DB_SYNDICATES_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
        'options' => extension_loaded('pdo_mysql') ? array_filter([
            PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        ]) : [],
    ],
];
