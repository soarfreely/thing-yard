<?php

namespace ThingYard\Yard\Business;

use Pimple\Container;
use ThingYard\Yard\YardProvider;

/**
 * Class ServiceProvider
 * @package PgServiceSdk\Work
 */
class BusinessProvider extends YardProvider
{
    /**
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        parent::register($pimple);

        // 注册模块名
        $pimple['business_yard_module'] = 'business';

        // Ｂ端
        $pimple['business'] = function ($app) {
            return new Business($app);
        };

    }
}
