<?php
use Pimple\Container;
use Phroute\Phroute\HandlerResolverInterface;

class RouterResolver implements HandlerResolverInterface
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function resolve($handler)
    {
        /*
        * Only attempt resolve uninstantiated objects which will be in the form:
        *
        *      $handler = ['Module\Api', 'method'];
        */
        if (is_array($handler) and is_string($handler[0])) {
            $handler[0] = $this->container[$handler[0]];
        }

        return $handler;
    }
}
