<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\models\events;

class BulkEvents implements \JsonSerializable
{
    private $merchantId;
    private $events = [];

    /**
     * @param $merchantId
     * @param $events
     */
    public function __construct($merchantId, $events)
    {
        $this->merchantId = $merchantId;
        $this->events[] = $events;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
