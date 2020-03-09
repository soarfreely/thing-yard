<?php

namespace ThingYard\Yard;

use ThingYard\Kernel\KernelClient;
use ThingYard\Kernel\Middleware\YardRequestIdMiddleware;

abstract class BaseClient extends KernelClient
{
    /**
     * 中间件注册
     */
    protected function registerMiddleware()
    {
        $this->pushMiddleware(
            $this->app['yard_request_id_middleware'],
            YardRequestIdMiddleware::getAccessName()
        );

//        parent::registerMiddleware();
    }

    /**
     * 格式化 URL
     *
     * @param string $url
     *
     * @return string
     */
    protected function realUrl($url)
    {
        return ltrim(sprintf(
            $url,
            $this->app->config['qa.env']
        ),'/');
    }
}
