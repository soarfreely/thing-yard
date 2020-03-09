<?php

namespace ThingYard\Yard\Business;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ThingYard\Kernel\Middleware\YardRequestIdMiddleware;

/**
 * Class ServiceProvider
 * @package PgServiceSdk\Work
 */
class BusinessProvider implements ServiceProviderInterface
{

    /**
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        // 注册模块名
        $pimple['business_yard_module'] = 'business';

        // 注册中间件
        $pimple['yard_request_id_middleware'] = function ($app) {
            return new YardRequestIdMiddleware($app);
        };

        // Ｂ端
        $pimple['business'] = function ($app) {
            return new Business($app);
        };

    }
}
