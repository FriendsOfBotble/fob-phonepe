<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\models\events;

class BaseEvent implements \JsonSerializable
{
    private $eventState;
    private $eventType;
    private $id;
    private $time;
    private $flowType;
    private $sdkVersion;
    private $sdkType;
    private $message;
    private $code;

    /**
     * @return mixed
     */
    public function getEventState()
    {
        return $this->eventState;
    }

    /**
     * @param mixed $eventState
     */
    public function setEventState($eventState)
    {
        $this->eventState = $eventState;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getFlowType()
    {
        return $this->flowType;
    }

    /**
     * @param mixed $flowType
     */
    public function setFlowType($flowType)
    {
        $this->flowType = $flowType;
    }

    /**
     * @return mixed
     */
    public function getSdkVersion()
    {
        return $this->sdkVersion;
    }

    /**
     * @param mixed $sdkVersion
     */
    public function setSdkVersion($sdkVersion)
    {
        $this->sdkVersion = $sdkVersion;
    }

    /**
     * @return mixed
     */
    public function getSdkType()
    {
        return $this->sdkType;
    }

    /**
     * @param mixed $sdkType
     */
    public function setSdkType($sdkType)
    {
        $this->sdkType = $sdkType;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
