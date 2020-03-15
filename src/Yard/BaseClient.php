<?php

namespace ThingYard\Yard;

use ThingYard\Kernel\Exceptions\InvalidArgumentException;
use ThingYard\Kernel\KernelClient;
use ThingYard\Kernel\Middleware\BearerTokenMiddleware;
use ThingYard\Kernel\Middleware\YardRequestIdMiddleware;

abstract class BaseClient extends KernelClient
{
    /**
     * 请求成功状态吗
     */
    const HTTP_STATUS_SUCCESS = [200];

    /**
     * 网关
     *
     * @var string
     */
    protected $gateway = 'api-gateway';

    /**
     * 企业id
     * @var string
     */
    protected $companyId = '';

    /**
     * 企业id
     * @var array
     */
    protected $company = [];

    /**
     * 中间件注册
     */
    protected function registerMiddleware()
    {
        $this->pushMiddleware(
            $this->app['yard_request_id_middleware'],
            YardRequestIdMiddleware::getAccessName()
        );

        $this->pushMiddleware(
            $this->app['token_middleware'],
            BearerTokenMiddleware::getAccessName()
        );

        parent::registerMiddleware();
    }

    /**
     *  设置 basic_uri
     * @param $baseUri
     * @return $this
     * @throws InvalidArgumentException Date: 2020/3/12 Time: 下午11:33
     */
    protected function setBaseUri($baseUri)
    {
        if (empty($baseUri)) {
            throw new InvalidArgumentException('host is expected');
        }

        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * 设置CompanyId
     *
     * Date: 2020/3/9 Time: 下午2:23
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function setCompanyId()
    {
        if (empty($companyId = $this->app->config->get('company_id', ''))) {
            throw new InvalidArgumentException('company id is expected');
        }

        $this->companyId = $companyId;
        return $this;
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
     * 查询字符串
     *
     * @param $url
     * @param string $gateway
     * @param array $query
     * @return mixed
     */
    protected function queryString($url, $gateway = '', array $query = [])
    {
        return vsprintf($url, [$gateway, empty($queryString = http_build_query($query)) ? '' : "?$queryString"]);
    }
}
