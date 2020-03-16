<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/16 Time: 上午11:19
 */

namespace ThingYard\Kernel\Middleware;


use Psr\Http\Message\RequestInterface;

class SerialIdMiddle extends BaseMiddleware
{

    /**
     * @inheritDoc
     */
    public function onBefore(RequestInterface $request)
    {
        // TODO: Implement onBefore() method.
        return $request->withHeader('serialId', $this->app->getSerialId());
    }

    /**
     * @inheritDoc
     */
    public static function getAccessName()
    {
        // TODO: Implement getAccessName() method.
        return 'serial_id';
    }
}