<?php
/**
 * Define Routes here
 */
$router->get('/', ['CredJumper\Api', 'credential_get']);

/**
 * APIs that do not require authorization
 */
$router->get('/credentials/{id:i}?', ['CredJumper\Api', 'credentialGet']);
$router->post('/credentials', ['CredJumper\Api', 'credentialAdd']);
