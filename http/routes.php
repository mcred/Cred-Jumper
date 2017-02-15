<?php
/**
 * Define Routes here
 */
$router->get('/', function () {
    return 'Hello, PHRoute';
});

/**
 * APIs that do not require authorization
 */
$router->get('/merchants/{id:i}?/{status_id:i}?', ['PayScape\MerchantApi', 'getMerchants']);
$router->post('/merchants', ['PayScape\MerchantApi', 'postMerchants']);
$router->put('/merchants', ['PayScape\MerchantApi', 'putMerchant']);
$router->delete('/merchant/{id:i}', ['PayScape\MerchantApi', 'deleteMerchants']);
