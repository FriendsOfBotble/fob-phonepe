<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\config;

class MerchantConfig
{
    /**
     * @desc The Merchant Id provided by PhonePe team
     * @var string
     */
    private $merchantId;

    /**
     * @desc The salt key provided by PhonePe team
     * @var string
     */
    private $saltKey;

    /**
     * @desc The salt index provided by PhonePe team
     * @var int
     */
    private $saltIndex;

    /**
     * @param $merchantId
     * @param $saltKey
     * @param $saltIndex
     */
    public function __construct($merchantId, $saltKey, $saltIndex)
    {
        $this->merchantId = $merchantId;
        $this->saltKey = $saltKey;
        $this->saltIndex = $saltIndex;
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
    public function getSaltKey(): string
    {
        return $this->saltKey;
    }

    /**
     * @param string $saltKey
     */
    public function setSaltKey(string $saltKey)
    {
        $this->saltKey = $saltKey;
    }

    /**
     * @return int
     */
    public function getSaltIndex(): int
    {
        return $this->saltIndex;
    }

    /**
     * @param integer $saltIndex
     */
    public function setSaltIndex(int $saltIndex)
    {
        $this->saltIndex = $saltIndex;
    }
}
