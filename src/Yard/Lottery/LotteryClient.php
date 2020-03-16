<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/15 Time: 下午1:39
 */

namespace ThingYard\Yard\Lottery;


use ThingYard\Kernel\Exceptions\InvalidArgumentException;
use ThingYard\Kernel\ServiceContainer;
use ThingYard\Yard\BaseClient;

abstract class LotteryClient extends BaseClient
{
    /**
     * LotteryClient constructor.
     * @param ServiceContainer $app
     * @throws InvalidArgumentException
     */
    public function __construct(ServiceContainer $app)
    {
        parent::__construct($app);

        $this->setBaseUri($app->config->get('lottery_host', ''));
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
        return $this->queryString($url, '', $query);
    }




}