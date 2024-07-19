<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgUpiApps implements \JsonSerializable
{
    private $enabled;
    private $appname;
    private $handles;

    /**
     * @param $enabled
     * @param $appname
     * @param $handles
     */
    public function __construct($enabled, $appname, $handles)
    {
        $this->enabled = $enabled;
        $this->appname = $appname;
        $this->handles = $handles;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getAppname()
    {
        return $this->appname;
    }

    /**
     * @param mixed $appname
     */
    public function setAppname($appname)
    {
        $this->appname = $appname;
    }

    /**
     * @return mixed
     */
    public function getHandles()
    {
        return $this->handles;
    }

    /**
     * @param mixed $handles
     */
    public function setHandles($handles)
    {
        $this->handles = $handles;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
