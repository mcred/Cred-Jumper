<?php
    require __DIR__.'/bootstrap.php';

    return [
        'paths' => [
            'migrations' => __DIR__.'/db/migrations',
            'seeds' => __DIR__.'/db/seeds',
        ],
        'environments' =>[
            'default_migration_table' => 'phinxlog',
            'default_database' => 'default',
            'default' => [
                'name' => $_ENV['db_name'],
                'adapter' => 'mysql',
                'host' => $_ENV['db_host'],
                'user' => $_ENV['db_username'],
                'pass' => $_ENV['db_password'],
                'port' => $_ENV['db_port'],
                'charset' => 'utf8',
            ]
        ]
    ];
