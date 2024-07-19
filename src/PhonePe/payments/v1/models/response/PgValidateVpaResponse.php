<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgValidateVpaResponse implements \JsonSerializable
{
    private $name;
    private $vpa;

    /**
     * @param $name
     * @param $vpa
     */
    public function __construct($name, $vpa)
    {
        $this->name = $name;
        $this->vpa = $vpa;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getVpa()
    {
        return $this->vpa;
    }

    /**
     * @param mixed $vpa
     */
    public function setVpa($vpa)
    {
        $this->vpa = $vpa;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
