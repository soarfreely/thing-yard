<?php

namespace ThingYard\Yard\Customer;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ThingYard\Kernel\Middleware\YardRequestIdMiddleware;

/**
 * Class ServiceProvider
 * @package PgServiceSdk\Work
 */
class CustomerProvider implements ServiceProviderInterface
{
    /**
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['customer_yard_module'] = 'customer';

        $pimple['yard_request_id_middleware'] = function ($app) {
            return new YardRequestIdMiddleware($app);
        };

        // C端相关
        $pimple['customer'] = function ($app) {
            return new Customer($app);
        };

    }
}
