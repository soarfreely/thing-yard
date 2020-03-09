<?php

namespace ThingYard\Kernel\Providers;

use Pimple\Container;
use ThingYard\Kernel\Config;
use Pimple\ServiceProviderInterface;
use ThingYard\Kernel\ServiceContainer;

/**
 * Class ConfigProvider
 * @package PgServiceSdk\Kernel\Providers
 */
class ConfigProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        /**
         * @param ServiceContainer $app
         * @return Config
         */
        $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}