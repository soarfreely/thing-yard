<?php

namespace ThingYard\Kernel\Providers;

use Pimple\Container;
use GuzzleHttp\Client;
use Pimple\ServiceProviderInterface;

class HttpClientProvider implements ServiceProviderInterface
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
        $pimple['http_client'] = function ($app) {
            return new Client($app->config->get('http', []));
        };
    }
}