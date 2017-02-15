<?php
/**
 * Define Routes here
 */
$router->get('/', ['CredJumper\Api', 'credential_get']);

/**
 * APIs that do not require authorization
 */
$router->get('/credentials/{id:i}?', ['CredJumper\Api', 'credential_get']);
$router->post('/credentials', ['CredJumper\Api', 'credential_add']);
