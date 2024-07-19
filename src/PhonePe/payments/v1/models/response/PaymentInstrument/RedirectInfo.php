<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

class RedirectInfo implements \JsonSerializable
{
    private $url;
    private $method;

    /**
     * @param $url
     * @param $method
     */
    public function __construct($url, $method)
    {
        $this->url = $url;
        $this->method = $method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
