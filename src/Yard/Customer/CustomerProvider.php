<?php

namespace ThingYard\Yard\Customer;

use Pimple\Container;
use ThingYard\Yard\YardProvider;

/**
 * Class ServiceProvider
 * @package PgServiceSdk\Work
 */
class CustomerProvider extends YardProvider
{
    /**
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        parent::register($pimple);

        $pimple['customer_yard_module'] = 'customer';

        // C端相关
        $pimple['customer'] = function ($app) {
            return new Customer($app);
        };

    }
}
