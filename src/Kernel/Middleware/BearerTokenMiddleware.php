<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/11 Time: 上午8:34
 */

namespace ThingYard\Kernel\Middleware;


use Psr\Http\Message\RequestInterface;

class BearerTokenMiddleware extends BaseMiddleware
{
    /**
     * @inheritDoc
     */
    public function onBefore(RequestInterface $request)
    {
        // TODO: Implement onBefore() method.
        return $request->withHeader('Authorization', $this->app->getToken());
    }

    /**
     * @inheritDoc
     */
    public static function getAccessName()
    {
        // TODO: Implement getAccessName() method.
        return 'token';
    }

}