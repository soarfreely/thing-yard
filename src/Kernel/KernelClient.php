<?php

namespace ThingYard\Kernel;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\MessageFormatter;
use ThingYard\Kernel\Http\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use ThingYard\Kernel\Support\Collection;
use ThingYard\Kernel\Traits\HttpRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use ThingYard\Kernel\Exceptions\ValidationException;
use ThingYard\Kernel\Exceptions\BadRequestException;
use ThingYard\Kernel\Exceptions\AuthorizationException;
use ThingYard\Kernel\Exceptions\InvalidConfigException;
use ThingYard\Kernel\Exceptions\ServiceInvalidException;
use ThingYard\Kernel\Exceptions\ResourceNotFoundException;

/**
 * Class KernelClient
 * @package ThingYard\Kernel
 */
class KernelClient
{
    use HttpRequest {
        request as performRequest;
    }

    /**
     * Pimple 容器
     *
     * @var ServiceContainer
     */
    protected $app;

    /**
     * option 选项中 baseUri,子类可覆盖
     *
     * @var string
     */
    protected $baseUri;

    /**
     * 是否处理 JSON 请求的空数组逻辑
     *
     * @var bool
     */
    protected $handleEmptyArray = true;

    /**
     * BaseClient constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * 发送 GET 请求
     *
     * @param string $url
     * @param array $query
     *
     * @return array|object|Collection|ResponseInterface|string
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function httpGet($url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * 发送表单数据（application/x-www-form-urlencoded）
     *
     * @param string $url
     * @param array $data
     *
     * @return array|object|Collection|ResponseInterface|string
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function httpPost($url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * 发送 POST JSON 请求
     *
     * @param string $url
     * @param array $data
     * @param array $query
     *
     * @return array|object|Collection|ResponseInterface|string
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function httpPostJson($url, array $data = [], array $query = [])
    {
        if ($this->handleEmptyArray) {
            $data = $this->handleJsonEmptyArray($data);
        }

        return $this->request($url, 'POST', $this->getOptions($data, $query));
    }

    /**
     *  发送 PUT JSON 请求
     *
     * @param string $url
     * @param array $data
     * @param array $query
     *
     * @return array|object|Collection|ResponseInterface|string
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function httpPutJson($url, array $data = [], array $query = [])
    {
        if ($this->handleEmptyArray) {
            $data = $this->handleJsonEmptyArray($data);
        }

        return $this->request($url, 'PUT', $this->getOptions($data, $query));
    }

    /**
     * @param $url
     * @param array $data
     * @param array $query
     * @return array|object|ResponseInterface|string|Collection|null
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * Date: 2020/3/9 Time: 下午4:45
     */
    public function httpDeleteJson($url, array $data = [], array $query = [])
    {
        if ($this->handleEmptyArray) {
            $data = $this->handleJsonEmptyArray($data);
        }

        return $this->request($url, 'DELETE', $this->getOptions($data, $query));
    }

    /**
     * 发送 PATCH JSON 请求
     *
     * @param string $url
     * @param array $data
     * @param array $query
     *
     * @return array|object|Collection|ResponseInterface|string
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function httpPatchJson($url, array $data = [], array $query = [])
    {
        if ($this->handleEmptyArray) {
            $data = $this->handleJsonEmptyArray($data);
        }

        return $this->request($url, 'PATCH', ['query' => $query, 'json' => $data]);
    }

    /**
     * 发送表单上传附件
     *
     * @param string $url
     * @param array $files
     * @param array $form
     * @param array $query
     *
     * @return array|object|Collection|ResponseInterface|string
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function httpUpload($url, array $files = [], array $form = [], array $query = [])
    {
        $multipart = [];

        foreach ($files as $name => $file) {
            $multipart [] = [
                'name' => $name,
                'contents' => $file,
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request($url, 'POST', compact('multipart', 'query'));
    }

    /**
     * @param $url
     * @param string $method
     * @param array $options
     * @param bool $returnRaw
     * @return array|object|ResponseInterface|string|Collection|null
     * @throws AuthorizationException
     * @throws BadRequestException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws GuzzleException
     */
    public function request($url, $method = 'POST', array $options = [], $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerMiddleware();
        }

        try {
            $response = $this->performRequest($url, $method, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $code = $response->getStatusCode();
            $contents = $response->getBody()->getContents();
            $content = json_decode($contents);
            $message = property_exists($content, 'message') ? $content->message : '';

            switch ($code) {
                case 404:
                    throw new ResourceNotFoundException($message, 404);
                case 400:
                case 422:
                    throw new ValidationException($message, 400);
                    break;
                case 401:
                    throw new AuthorizationException($message, 401);
                default:
                    throw new ServiceInvalidException($message ? $message : 'Service Invalid', 500);
            }
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            $content = json_decode($contents);
            $message = property_exists($content, 'message') ? $content->message : 'Service Invalid';

            throw new ServiceInvalidException($message, 500);
        } catch (RequestException $e) {
            // 在发送网络错误(连接超时、DNS错误等)时
            throw new BadRequestException($e->getMessage(), 400);
        }

        if ($returnRaw) {
            return $response;
        }

        $responseType = $this->app->config->get('response_type');
        return $this->costResponseToType($response, $responseType);
    }

    /**
     * 自定义请求，响应对象
     *
     * @param string $url
     * @param string $method
     * @param array $options
     *
     * @return GuzzleResponse
     *
     * @throws AuthorizationException
     * @throws InvalidConfigException
     * @throws ResourceNotFoundException
     * @throws ServiceInvalidException
     * @throws ValidationException
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function requestRaw($url, $method = 'POST', array $options = [])
    {
        return Response::buildFromPsrResponse($this->request($url, $method, $options, true));
    }

    /**
     * 重写获取客户端，通过 Pimple 容器获取
     *
     * @return Client
     */
    public function getClient()
    {
        if (!($this->httpClient instanceof ClientInterface)) {
            $this->httpClient = $this->app->offsetExists('http_client') ? $this->app['http_client'] : new Client();
        }

        return $this->httpClient;
    }

    /**
     * 处理空的数据
     *
     * @param array $data
     *
     * @return array|object
     */
    protected function handleJsonEmptyArray(array $data)
    {
        count($data) == 0 && $data = (object)$data;
        return $data;
    }

    /**
     * 注册默认中间件
     */
    protected function registerMiddleware()
    {
        //$this->pushMiddleware($this->retryMiddleware(), 'retry');
        if ($this->app->offsetExists('log')) {
            $this->pushMiddleware($this->logMiddleware(), 'log');
        }
    }

    /**
     * 重试中间件
     *
     * @return callable
     */
//    protected function retryMiddleware()
//    {
//        return Middleware::retry(function ($retries,
//                                           Request $request,
//                                           GuzzleResponse $response = null,
//                                           RequestException $exception = null) {
//            if ($retries <= $this->app->config->get('http.retries', 1) && $response) {
//                return true;
//            }
//
//            return false;
//        }, function () {
//            return abs($this->app->config->get('http.retry_delay', 500));
//        });
//    }

    /**
     * 日志中间件
     *
     * @return callable
     */
    protected function logMiddleware()
    {
        $logger = $this->app['log'];
        $logLevel = LogLevel::INFO;
        $config = $this->app->config;
        $formatter = new MessageFormatter(
            $this->app->config->get('http.log_template', MessageFormatter::CLF)
        );

        return function (callable $handler) use ($logger, $formatter, $logLevel, $config) {
            return function ($request, array $options) use ($handler, $logger, $formatter, $logLevel, $config) {
                return $handler($request, $options)->then(
                    function ($response) use ($logger, $request, $formatter, $logLevel, $config) {
                        if ($config->get('http.logging', true)) {
                            $message = $formatter->format($request, $response);
                            $logger->log($logLevel, $message);
                        }
                        return $response;
                    },
                    function ($reason) use ($logger, $request, $formatter) {
                        $response = $reason instanceof RequestException
                            ? $reason->getResponse()
                            : null;
                        $message = $formatter->format($request, $response, $reason);
                        $logger->notice($message);
                        return \GuzzleHttp\Promise\rejection_for($reason);
                    }
                );
            };
        };
    }

    /**
     * options
     *
     * @param $data
     * @param array $query
     * @return array
     */
    private function getOptions($data, $query = [])
    {
        return empty($query) ? ['json' => $data] : ['query' => $query, 'json' => $data];
    }

}
