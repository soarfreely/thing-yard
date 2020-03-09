<?php

namespace ThingYard\Kernel\Traits;


use ThingYard\Kernel\Contracts\ResponseFormatted;
use ThingYard\Kernel\Exceptions\InvalidConfigException;
use ThingYard\Kernel\Http\Response;
use Psr\Http\Message\ResponseInterface;
use ThingYard\Kernel\Support\Collection;

trait ResponseCastable
{

    /**
     * @param ResponseInterface $response
     * @param null $type
     * @return array|object|Response|Collection
     * @throws InvalidConfigException
     */
    protected function costResponseToType(ResponseInterface $response, $type = null)
    {
        $guzzleResponse = Response::buildFromPsrResponse($response);
        $guzzleResponse->getBody()->rewind();

        switch ($type ? $type : 'array') {
            case 'collection':
                return $guzzleResponse->toCollection();
                break;
            case 'array':
                return $guzzleResponse->toArray();
                break;
            case 'object':
                return $guzzleResponse->toObject();
                break;
            case 'raw':
                return $guzzleResponse;
                break;
            default :
                if (!is_subclass_of($type, ResponseFormatted::class)) {
                    throw new InvalidConfigException(sprintf(
                        'Config key "response_type" classname must be an instanceof %s',
                         ResponseFormatted::class
                    ));
                }

                return (new $type($response))->format();
        }
    }
}