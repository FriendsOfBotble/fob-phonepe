<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PaymentOption implements \JsonSerializable
{
    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @param $enabled
     */
    public function __construct($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
