<?php
namespace ThingYard\Kernel\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

trait HttpRequest
{
    /**
     * 增加格式化响应的功能
     */
    use ResponseCastable;

    /**
     * 请求的 HTTP 客户端
     *
     * @var Client
     */
    protected $httpClient;

    /**
     * 设置的中间件集合
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * @var HandlerStack
     */
    protected $handlerStack;

    /**
     * 默认的 option 设置
     *
     * @var array
     */
    protected static $default = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
        ]
    ];

    /**
     * 获取默认的 option 选项
     *
     * @return array
     */
    public static function getDefaultOption()
    {
        return static::$default;
    }

    /**
     * 设置默认的 option 选项
     *
     * @param array $defaultOption
     */
    public static function setDefaultOption(array $defaultOption)
    {
        static::$default = $defaultOption;
    }

    /**
     * 获取 HTTP 客户端
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        if (!($this->httpClient instanceof ClientInterface)) {
            $this->httpClient = new Client();
        }

        return $this->httpClient;
    }

    /**
     * 设置请求的客户端
     *
     * @param ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * 发送请求
     *
     * @param string $url
     * @param string $method
     * @param array $option
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function request($url, $method = 'POST', $option = [])
    {
        $method = strtoupper($method);
        $options = array_merge(
            static::$default,
            $option,
            ['handler' => $this->getHandlerStack()],
            ['debug' => boolval($this->app->config['http.debug'])]
        );
        if (property_exists($this, 'baseUri') && !is_null($this->baseUri)) {
            $options['base_uri'] = $this->baseUri;
        }

        $response = $this->getClient()->request($method, $url, $options);

        $response->getBody()->rewind();
        return $response;
    }

    /**
     * 构建 HandlerStack
     *
     * @return HandlerStack
     */
    public function getHandlerStack()
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }

        $this->handlerStack = HandlerStack::create();

        foreach ($this->middleware as $name => $middleware) {
            $this->handlerStack->push($middleware, $name);
        }

        return $this->handlerStack;
    }

    /**
     * @param HandlerStack $handlerStack
     *
     * @return $this
     */
    public function setHandlerStack(HandlerStack $handlerStack)
    {
        $this->handlerStack = $handlerStack;

        return $this;
    }

    /**
     * 添加一个中间件
     *
     * @param callable $middleware
     * @param string $name
     *
     * @return $this
     */
    public function pushMiddleware(callable $middleware, $name = null)
    {
        if (is_null($name)) {
            array_push($this->middleware, $middleware);
        } else {
            $this->middleware[$name] = $middleware;
        }

        return $this;
    }

    /**
     * 获取所有的中间件
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }
}