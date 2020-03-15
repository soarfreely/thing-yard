<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/11 Time: 上午9:10
 */

namespace ThingYard\Yard;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ThingYard\Kernel\Middleware\BearerTokenMiddleware;
use ThingYard\Kernel\Middleware\YardRequestIdMiddleware;

abstract class YardProvider implements ServiceProviderInterface
{

     /**
      * @inheritDoc
      */
     public function register(Container $pimple)
     {
         // TODO: Implement register() method.

         $pimple['yard_request_id_middleware'] = function ($app) {
             return new YardRequestIdMiddleware($app);
         };

         $pimple['token_middleware'] = function ($app) {
             return new BearerTokenMiddleware($app);
         };
     }
 }