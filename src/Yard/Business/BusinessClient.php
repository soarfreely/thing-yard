<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/9 Time: 下午2:10
 */

namespace ThingYard\Yard\Business;


use ThingYard\Kernel\Exceptions\InvalidArgumentException;
use ThingYard\Kernel\ServiceContainer;
use ThingYard\Yard\BaseClient;

abstract class BusinessClient extends BaseClient
{

    /**
     * 网关
     *
     * @var string
     */
    protected $gateway = 'api-gateway';

    /**
     * 企业id
     *
     * @var string
     */
    protected $companyId = '';

    /**
     * 企业id
     *
     * @var array
     */
    protected $company = [];

    /**
     * BusinessClient constructor.
     * @param ServiceContainer $app
     * @throws InvalidArgumentException
     */
    public function __construct(ServiceContainer $app)
    {
        parent::__construct($app);

        $this->setBaseUri();

        $this->setCompanyId();

        $this->company = ['companyId' => $this->companyId];
    }

    /**
     * 格式化 URL
     *
     * @param string $url
     *
     * @param array $query
     * @return string
     */
    protected function realUrl($url, $query = [])
    {
        return $this->queryString($url, $this->gateway, $query);
    }

    /**
     * 设置CompanyId
     *
     * Date: 2020/3/9 Time: 下午2:23
     * @return BusinessClient
     * @throws InvalidArgumentException
     */
    public function setCompanyId()
    {
        if (empty($companyId = $this->app->config->get('companyId', ''))) {
            throw new InvalidArgumentException('company id is expected');
        }

        $this->companyId = $companyId;
        return $this;
    }

}