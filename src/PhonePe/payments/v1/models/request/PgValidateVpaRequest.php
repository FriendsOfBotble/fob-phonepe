<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request;

class PgValidateVpaRequest implements \JsonSerializable
{
    private $merchantId;
    private $vpa;

    /**
     * @param string $merchantId
     * @param string $vpa
     */
    public function __construct(string $merchantId, string $vpa)
    {
        $this->merchantId = $merchantId;
        $this->vpa = $vpa;
    }

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId(string $merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getVpa(): string
    {
        return $this->vpa;
    }

    /**
     * @param string $vpa
     */
    public function setVpa(string $vpa)
    {
        $this->vpa = $vpa;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
