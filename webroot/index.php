<?php
/**
 * @var \Zend\Diactoros\ServerRequest $request
 */
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\RouteParser;
use Phroute\Phroute\Dispatcher;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response;

require __DIR__.'/../bootstrap.php';

function logError($message)
{
    error_log("Spaceballs Error: [". date("Y/m/d h:i:s", time()) ."] ".$message);
}

/**
 * Set error reporting if local environment
 */
if ($_ENV['APP_ENV'] == 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

/**
 * Include route and dependency definitions
 */
$router = new RouteCollector(new RouteParser());
require __DIR__.'/../http/RouterResolver.php';
require __DIR__.'/../dependencies.php';
require __DIR__.'/../http/routes.php';

/**
 * Init the dispatcher and the response
 */
$dispatcher   = new Dispatcher($router->getData(), new RouterResolver($container));

/**
 * Get request object from DI Container
 */
$request = $container['Request'];
$headers = [];
/**
 * Attempt to call route based on url input. If failure, catch exception
 */
try {
    $body     = [
        $dispatcher->dispatch(
            $request->getMethod(),
            $request->getUri()->getPath()
        )
    ];
    $status = 200;
} catch (HttpRouteNotFoundException $e) {
    $body     = [
        $e->getMessage(),
    ];
    $status = 404;
    logError($e->getMessage());
} catch (HttpMethodNotAllowedException $e) {
    $allowed = explode(':', $e->getMessage());
    $headers["Access-Control-Allow-Methods"] = $allowed[1];
    $body = null;
    $status = 200;
} catch (InvalidArgumentException $e) {
    $body     = [
        $e->getMessage()
    ];
    $status = 500;
    logError($e->getMessage());
} catch (ActionNotAllowedException $e) {
    $body     = [
        $e->getMessage()
    ];
    $headers['WWW-Authenticate'] = 'HTTP/1.0 401 Unauthorized';
    $status = 401;
    logError($e->getMessage());
} catch (DatabaseException $e) {
    $body = [
        'Error with database'
    ];
    $status = 500;
    logError($e->getMessage());
}

/**
 * Emit response via SAPI emitter class
 */
if (!isset($response)) {
    $response = new Response\JsonResponse($body, $status, $headers);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
