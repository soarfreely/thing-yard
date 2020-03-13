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

class Business extends BusinessClient
{

    /**
     *  isv登录
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/8 Time: 下午3:06
     */
    public function login(array $params)
    {
        $url = $this->realUrl('/%s/data/isv/login/v1');
        return $this->httpPostJson($url, $params);
    }

    /**
     * 新增门店（批量添加）
     *
     * @param array $params
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
    public function stores(array $params)
    {
        $url = $this->realUrl('/%s/tm/isv/stores/v1%s', $this->company);
        return $this->httpPostJson($url, $params);
    }

    /**
     * 同步用户（批量同步）
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/9 Time: 下午2:35
     */
    public function sync(array $params)
    {
        $url = $this->realUrl('/%s/tm/isv/users/v1%s', $this->company);
        return $this->httpPostJson($url, $params);
    }

    /**
     * 防伪扫码
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/9 Time: 下午2:38
     */
    public function innerCode(array $params)
    {
        $url = $this->realUrl('/%s/tm/isv/tag/v1/innercode%s', $this->company);
        return $this->httpPostJson($url, $params);
    }

    /**
     * 扫明码或箱码入库
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/9 Time: 下午2:39
     */
    public function outerCode(array $params)
    {
        $url = $this->realUrl('/%s/tm/isv/tag/v1/outercode%s', $this->company);
        return $this->httpPostJson($url, $params);
    }

    /**
     * 经销商添加（批量添加）
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/9 Time: 下午2:42
     */
    public function dealer(array $params)
    {
        $url = $this->realUrl('/%s/data/isv/dealers/v1%s', $this->company);
        return $this->httpPostJson($url, $params);
    }


    /**
     * 经销商修改（批量修改）
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function modifyDealer(array $params)
    {
       $url = $this->realUrl('/%s/data/isv/dealers/v1%s', $this->company);
       return $this->httpPutJson($url, $params);
    }

    /**
     * 经销商删除（批量删除）
     *
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection|null
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     */
    public function deleteDealer(array $params)
    {
        $url =  $this->realUrl('/%s/data/isv/dealers/v1%s', $this->company);
        return $this->httpDeleteJson($url, $params);
    }
}