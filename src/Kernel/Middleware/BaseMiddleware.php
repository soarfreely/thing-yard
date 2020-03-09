<?php
namespace ThingYard\Kernel\Middleware;

use ThingYard\Kernel\ServiceContainer;
use ThingYard\Kernel\Contracts\MiddlewareInterface;

/**
 * Class BaseMiddleware
 * @package ThingYard\Kernel\Middleware
 */
abstract class BaseMiddleware implements MiddlewareInterface
{
    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * BaseMiddleware constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param callable $handler
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function ($request, array $options) use ($handler) {
            $request = $this->onBefore($request);
            return $handler($request, $options);
        };
    }
}
