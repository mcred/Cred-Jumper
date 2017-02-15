<?php
/**
 * Define Routes here
 */
$router->get('/', ['CredJumper\CredentialsRepository', 'get']);

/**
 * APIs that do not require authorization
 */
$router->get('/credentials/{id:i}?', ['CredJumper\CredentialsRepository', 'get']);
$router->post('/credentials', ['CredJumper\CredentialsRepository', 'add']);
