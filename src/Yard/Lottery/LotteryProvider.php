<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/15 Time: 下午1:45
 */

namespace ThingYard\Yard\Lottery;


use Pimple\Container;
use ThingYard\Kernel\Middleware\SerialIdMiddle;
use ThingYard\Yard\YardProvider;

class LotteryProvider extends YardProvider
{
    /**
     * @param Container $pimple
     * Date: 2020/3/15 Time: 下午1:46
     */
    public function register(Container $pimple)
    {
        parent::register($pimple);

        $pimple['lottery_yard_module'] = 'lottery';

        // 中间件
        $pimple['serial_middleware'] = function ($app) {
            return new SerialIdMiddle($app);
        };

        // 抽奖相关
        $pimple['lottery'] = function ($app) {
            return new Lottery($app);
        };
    }
}