<?php
use Pimple\Container;
use \Sabre\Xml\Writer;

$container = new Container();

$container['\Zend\Diactoros\ServerRequest'] = function ($c) {
    return new \Zend\Diactoros\ServerRequest();
};

$container['\Curl\Curl'] = function ($c) {
    return new \Curl\Curl();
};

$container['\MysqliDb'] = function ($c) {
    return new \MysqliDb($_ENV['db_host'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_name'], $_ENV['db_port']);
};

$container['Request'] = function ($c) {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER,
        $_GET,
        $_POST,
        $_COOKIE,
        $_FILES
    );
};
