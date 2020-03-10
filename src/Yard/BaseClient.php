<?php

namespace ThingYard\Yard;

use ThingYard\Kernel\Exceptions\InvalidArgumentException;
use ThingYard\Kernel\KernelClient;
use ThingYard\Kernel\Middleware\YardRequestIdMiddleware;

abstract class BaseClient extends KernelClient
{
    /**
     * 中间件注册
     */
    protected function registerMiddleware()
    {
        $this->pushMiddleware(
            $this->app['yard_request_id_middleware'],
            YardRequestIdMiddleware::getAccessName()
        );

//        parent::registerMiddleware();
    }

    /**
     * 格式化 URL
     *
     * @param string $url
     *
     * @return string
     */
    protected function realUrl($url)
    {
        return ltrim(sprintf(
            $url,
            $this->app->config['env']
        ),'/');
    }

    /**
     * @param $url
     * User: <zhangxiang_php@vchangyi.com>
     * @return string
     * Date: 2020/3/9 Time: 下午2:23
     * @throws InvalidArgumentException
     */
    protected function urlCompanyId($url)
    {
        if (empty($this->app->config['companyId'])) {
            throw new InvalidArgumentException('company_id is invalid');
        }
        $query = [
            'companyId' => $this->app->config['qa.companyId']
        ];
        $queryString = http_build_query($query);
        $url .= '?'.$queryString;

        return $this->realUrl($url);
    }

    /**
     * 查询字符串
     *
     * @param $url
     * User: <zhangxiang_php@vchangyi.com>
     * @param array $query
     * @return string
     * Date: 2020/3/9 Time: 下午2:23
     */
    protected function queryString($url, array $query)
    {
        if (!empty($query)) {
            $queryString = http_build_query($query);
            $url .= '?'.$queryString;
        }

        return $this->realUrl($url);
    }
}
