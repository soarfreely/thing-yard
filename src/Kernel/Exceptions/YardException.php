<?php

namespace ThingYard\Kernel\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * Class YardException
 * @package ThingYard\Kernel\Exceptions
 */
class YardException extends SdkException
{
    /**
     * @var string
     */
    public $module = '';

    /**
     * @var null|ResponseInterface
     */
    public $response;

    /**
     * @var string
     */
    public $sdkCode = '';

    /**
     * YardException constructor.
     *
     * @param string $module
     * @param string $message
     * @param ResponseInterface|null $response
     * @param string $sdkCode
     * @param null $code
     */
    public function __construct($module, $message, ResponseInterface $response = null, $sdkCode = '', $code = null)
    {
        parent::__construct($message, $code);
        $this->module = $module;
        $this->response = $response;
        $this->sdkCode = $sdkCode;
    }

    /**
     * 获取请求的模块名
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * 获取错误请求的 HTTP CODE
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * 获取 SDK CODE
     *
     * @return string
     */
    public function getSdkCode()
    {
        return $this->sdkCode;
    }

    /**
     * 获取响应
     *
     * @return null|ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

}
