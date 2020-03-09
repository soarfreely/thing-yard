<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/3/8 Time: 上午11:23
 */

namespace ThingYard;

require_once '../vendor/autoload.php';

class Test
{
    /**
     * @var null | Application
     */
    protected $app = null;

    /**
     * @var null
     */
    protected $business = null;

    /**
     * Test constructor.
     */
    public function __construct()
    {
        $this->app = new Application( [
            'default' => [
                'qa' => [
                    'env' => 'https://wanduat.digitalshell.com.cn/api-gateway'
                ]
            ]
        ]);

        $this->business = $this->app['business'];
    }


    /**
     * User: <zhangxiang_php@vchangyi.com>
     * @return mixed
     * Date: 2020/3/8 Time: 下午10:56
     */
    public function login()
    {
        $params = [
            "account"=> "qiaopai_isv",
            "password"=> "qiaopai_isv123456"
        ];

        return $this->business->login($params);
    }

    /**
     * User: <zhangxiang_php@vchangyi.com>
     * @return mixed
     * Date: 2020/3/8 Time: 下午11:01
     */
    public function store()
    {
        $params = [
            'companyId' => 2,
            'stores' => [
                [
                    'code' => 'store_1',
                    'name' => 'store_name_1',
                    'dealerCode' => 'dealer_1',
                    'category' => 'test',
                    'status' => 1,
                ]
            ],
        ];

        return $this->app->store($params);
    }
}


$test = new Test();

dd($test->login());

//dd($test->store());