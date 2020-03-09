<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/7 Time: 下午5:13
 */

namespace ThingYard\Yard\Business;


use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use ThingYard\Kernel\Exceptions\AuthorizationException;
use ThingYard\Kernel\Exceptions\BadRequestException;
use ThingYard\Kernel\Exceptions\InvalidConfigException;
use ThingYard\Kernel\Exceptions\ResourceNotFoundException;
use ThingYard\Kernel\Exceptions\ServiceInvalidException;
use ThingYard\Kernel\Exceptions\ValidationException;
use ThingYard\Kernel\Support\Collection;
use ThingYard\Yard\BaseClient;

class Business extends BaseClient
{

    /**
     *  isv登录
     *
     * User: <zhangxiang_php@vchangyi.com>
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException Date: 2020/3/8 Time: 下午3:06
     */
    public function login(array $params)
    {
        $url = $this->realUrl('%s/data/isv/login/v1');
        return $this->httpPostJson($url, $params);
    }

    /**
     * 新增门店（批量添加）
     *
     * @param array $params
     * User: <zhangxiang_php@vchangyi.com>
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/8 Time: 下午10:25
     */
    public function store(array $params)
    {
        $url = $this->realUrl('%s/%s/tm/isv/stores/v1');
        return $this->httpPostJson($url, $params);
    }
}