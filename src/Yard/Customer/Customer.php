<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/7 Time: 下午5:13
 */

namespace ThingYard\Yard\Customer;


use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use ThingYard\Kernel\Exceptions\AuthorizationException;
use ThingYard\Kernel\Exceptions\BadRequestException;
use ThingYard\Kernel\Exceptions\InvalidConfigException;
use ThingYard\Kernel\Exceptions\ResourceNotFoundException;
use ThingYard\Kernel\Exceptions\ServiceInvalidException;
use ThingYard\Kernel\Exceptions\ValidationException;
use ThingYard\Kernel\Support\Collection;
use ThingYard\Yard\Business\CustomerClient;

class Customer extends CustomerClient
{

    /**
     * 防伪扫码
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
     * Date: 2020/3/9 Time: 下午5:35
     */
    public function label(array $params)
    {
        $url = $this->queryString('%s/code/isv/tag/v1/query', $params);
        return $this->httpGet($url, $params);
    }

    /**
     * 物理识别
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
     * Date: 2020/3/9 Time: 下午5:39
     */
    public function physicalRecognition(array $params)
    {
        $url = $this->queryString('%s/tag/v1/physicalRecognition', $params);
        return $this->httpGet($url, $params);
    }

    /**
     * 比对结果提交
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
     * Date: 2020/3/9 Time: 下午5:41
     */
    public function submit(array $params)
    {
        $url = $this->queryString('%s/code/isv/tag/v1/submit', $params);
        return $this->httpPostJson($url, $params);
    }

    /**
     * 根据码信息，查询码信息匹配到的活动信息
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
     * Date: 2020/3/9 Time: 下午5:48
     */
    public function trace(array $params)
    {
        $url = $this->queryString('%s/code/isv/tag/v1/trace', $params);
        return $this->httpGet($url, $params);
    }

    /**
     * @param array $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/9 Time: 下午6:02
     */
    public function promotion(array $params)
    {
        $url = $this->queryString('%s/qiaopai/promotion', $params);
        return $this->httpGet($url, $params);
    }
}