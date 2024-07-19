<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PaymentInstrument implements \JsonSerializable
{
    private $type;

    /**
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
