<?php
namespace ThingYard\Kernel\Contracts;

use Psr\Http\Message\RequestInterface;

/**
 * Interface MiddlewareInterface
 * @package ThingYard\Kernel\Contracts
 */
interface MiddlewareInterface
{
    /**
     * 中间件具体的实现
     *
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
     public function onBefore(RequestInterface $request);

    /**
     * 中间件名
     *
     * @return string
     */
     public static function getAccessName();
}