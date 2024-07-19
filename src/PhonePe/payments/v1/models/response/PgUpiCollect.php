<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgUpiCollect extends PaymentOption
{
    private $apps;

    /**
     * @param $apps
     */
    public function __construct($enabled, $apps)
    {
        parent::__construct($enabled);
        $this->apps = $apps;
    }

    /**
     * @return mixed
     */
    public function getApps()
    {
        return $this->apps;
    }

    /**
     * @param mixed $apps
     */
    public function setApps($apps)
    {
        $this->apps = $apps;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }

}
