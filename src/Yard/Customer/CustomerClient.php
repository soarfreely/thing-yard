<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/9 Time: 下午2:10
 */

namespace ThingYard\Yard\Customer;


use ThingYard\Kernel\Exceptions\InvalidArgumentException;
use ThingYard\Kernel\ServiceContainer;
use ThingYard\Yard\BaseClient;

abstract class CustomerClient extends BaseClient
{
    /**
     * CustomerClient constructor.
     * @param ServiceContainer $app
     * @throws InvalidArgumentException
     */
    public function __construct(ServiceContainer $app)
    {
        parent::__construct($app);

        $this->setBaseUri($app->config->get('business_host', ''));

        $this->setCompanyId();

        $this->company = ['companyId' => $this->companyId];
    }
}