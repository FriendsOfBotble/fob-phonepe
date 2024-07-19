<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\utils;

class HttpResponse implements \JsonSerializable
{
    private $headers;
    private $response;

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
