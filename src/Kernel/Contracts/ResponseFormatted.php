<?php

namespace ThingYard\Kernel\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseFormatted
 * @package ThingYard\Kernel\Contacts
 */
abstract class ResponseFormatted
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * ResponseFormatted constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * 格式化资源
     *
     * @return mixed
     */
    public abstract function format();
}