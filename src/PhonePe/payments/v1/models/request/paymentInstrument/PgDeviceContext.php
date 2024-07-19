<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

class PgDeviceContext implements \JsonSerializable
{
    private $deviceOS;

    /**
     * @param $deviceOs
     */
    public function __construct($deviceOs)
    {
        $this->deviceOS = $deviceOs;
    }

    /**
     * @return mixed
     */
    public function getDeviceOS()
    {
        return $this->deviceOS;
    }

    /**
     * @param mixed $deviceOS
     */
    public function setDeviceOS($deviceOS)
    {
        $this->deviceOS = $deviceOS;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
