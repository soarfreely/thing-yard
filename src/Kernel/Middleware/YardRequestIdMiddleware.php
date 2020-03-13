<?php

namespace ThingYard\Kernel\Middleware;


use Psr\Http\Message\RequestInterface;

class YardRequestIdMiddleware extends BaseMiddleware
{

    /**
     * 中间件具体的实现
     *
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    public function onBefore(RequestInterface $request)
    {
        $request = $request->withHeader(
            'X-REQUEST-ID',
            $this->app->getRequestId()
        );

        return $request;
    }

    /**
     * 中间件名
     *
     * @return string
     */
    public static function getAccessName()
    {
        return 'yard_request_id';
    }
}
