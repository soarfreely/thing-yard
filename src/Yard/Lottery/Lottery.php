<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/15 Time: 下午1:38
 */

namespace ThingYard\Yard\Lottery;


use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use ThingYard\Kernel\Exceptions\AuthorizationException;
use ThingYard\Kernel\Exceptions\BadRequestException;
use ThingYard\Kernel\Exceptions\InvalidConfigException;
use ThingYard\Kernel\Exceptions\ResourceNotFoundException;
use ThingYard\Kernel\Exceptions\ServiceInvalidException;
use ThingYard\Kernel\Exceptions\ValidationException;
use ThingYard\Kernel\Support\Collection;

class Lottery extends LotteryClient
{

    /**
     * 登陆
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
     * Date: 2020/3/15 Time: 下午1:47
     */
    public function login(array $params)
    {
        $url = $this->realUrl('/auth/mp/login');
        return $this->httpGet($url, $params);
    }

    /**
     * 查询活动
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
     * Date: 2020/3/9 Time: 下午6:02
     */
    public function promotion(array $params)
    {
        $url = $this->realUrl('/qiaopai/promotion', $params);
        return $this->httpGet($url, $params);
    }

    /**
     * 查询活动所有奖项
     *
     * @param $promotionId
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/16 Time: 上午11:12
     */
    public function awards($promotionId)
    {
        $url =  sprintf('/basic/%s/awards', $promotionId);
        return $this->httpGet($url);
    }

    /**
     * 预抽奖校验
     *
     * @param $type string 抽奖类型:tag:扫码抽奖活动检验,interact:互动抽奖活动检验
     * @param $params array
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/16 Time: 上午11:55
     */
    public function check($type, $params)
    {
        $params = [
            $type => $params,
        ];
        $url = $this->realUrl('/lottery/check', $params);
        return $this->httpPostJson($url);
    }

    /**
     * 扫码抽奖
     *
     * @param $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/16 Time: 上午11:59
     */
    public function tag($params)
    {
        $url = $this->realUrl('/lottery/v2/tag', $params);
        return $this->httpPostJson($url);
    }

    /**
     * 查询用户抽、中奖详情
     *
     * @param $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/16 Time: 下午12:01
     */
    public function lotteryRecords($params)
    {
        $url = $this->realUrl('/user/lotteryRecords', $params);
        return $this->httpPostJson($url);
    }

    /**
     * 兑奖
     *
     * @param $params
     * @return array|object|ResponseInterface|string|Collection
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/16 Time: 下午12:02
     */
    public function claim($params)
    {
        $url = $this->realUrl('/claim', $params);
        return $this->httpPostJson($url);
    }

}