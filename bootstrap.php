<?php
require("src/autoload.php");
require("vendor/autoload.php");
date_default_timezone_set('America/New_York');

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$dotenv->required([
    'db_name',
    'db_host',
    'db_username',
    'db_password',
    'db_port',
])->notEmpty();
