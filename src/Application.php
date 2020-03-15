<?php

namespace ThingYard;

use ThingYard\Kernel\ServiceContainer;
use ThingYard\Yard\Business\Business;
use ThingYard\Yard\Business\BusinessProvider;
use ThingYard\Yard\Customer\Customer;
use ThingYard\Yard\Customer\CustomerProvider;
use ThingYard\Yard\Lottery\Lottery;
use ThingYard\Yard\Lottery\LotteryProvider;

/**
 * Class Application
 *
 * @property Business $business
 * @property Customer $customer
 * @property Lottery $lottery
 *
 * @package ThingYard
 */
class Application extends ServiceContainer
{
    /**
     * 应用的服务提供者
     *
     * @var array
     */
    protected $providers = [
        BusinessProvider::class,
        CustomerProvider::class,
        LotteryProvider::class,
    ];
}
