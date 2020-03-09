<?php

namespace ThingYard\Kernel;

use GuzzleHttp\Client;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use ThingYard\Kernel\Providers\ConfigProvider;
use ThingYard\Kernel\Providers\RequestProvider;
use ThingYard\Kernel\Providers\HttpClientProvider;

/**
 * Class ServiceContainer
 * @package ThingYard\Kernel
 *
 * @property Config $config
 * @property Client $http_client
 * @property Request $request
 */
class ServiceContainer extends Container
{
    /**
     * 服务提供者容器
     *
     * @var array
     */
    protected $providers = [];

    /**
     * 用户自定义配置
     *
     * @var array
     */
    protected $userConfig = [];

    /**
     * 默认的配置，子类可覆盖
     *
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var null|string
     */
    protected $requestId = null;

    /**
     * ServiceContainer constructor.
     * @param array $config
     * @param array $values
     * @param string $id
     */
    public function __construct(array $config = [], array $values = array(), $id = null)
    {
        $this->registerProviders($this->getProviders());

        parent::__construct($values);

        $this->userConfig = $config;
        $this->requestId = $id;
    }

    /**
     * 设置请求 requestId
     *
     * @param $requestId
     * @return $this
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * 获取请求 requestId
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId = $this->requestId ?? md5(json_encode($this->userConfig));
    }

    /**
     * 获取配置
     *
     * @return array
     */
    public function getConfig()
    {
        $base = [
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'http' => [
                'timeout' => 10.0,
                'headers' => ['Accept' => 'application/json']
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig['default']);
    }

    /**
     * 获取服务提供者
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            ConfigProvider::class,
            HttpClientProvider::class,
            RequestProvider::class
        ], $this->providers);

    }

    /**
     * 注册服务提供者
     *
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}