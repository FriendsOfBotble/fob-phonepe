<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request;

class PgRefundRequest implements \JsonSerializable
{
    private $merchantId;
    private $merchantTransactionId;
    private $amount;
    private $originalTransactionId;
    private $callbackUrl;

    /**
     * @param $merchantId
     * @param $merchantTransactionId
     * @param $amount
     * @param $originalTransactionId
     * @param $callbackUrl
     */
    public function __construct($merchantId, $merchantTransactionId, $amount, $originalTransactionId, $callbackUrl)
    {
        $this->merchantId = $merchantId;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->amount = $amount;
        $this->originalTransactionId = $originalTransactionId;
        $this->callbackUrl = $callbackUrl;
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
    public function getMerchantTransactionId()
    {
        return $this->merchantTransactionId;
    }

    /**
     * @param mixed $merchantTransactionId
     */
    public function setMerchantTransactionId($merchantTransactionId)
    {
        $this->merchantTransactionId = $merchantTransactionId;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getOriginalTransactionId()
    {
        return $this->originalTransactionId;
    }

    /**
     * @param mixed $originalTransactionId
     */
    public function setOriginalTransactionId($originalTransactionId)
    {
        $this->originalTransactionId = $originalTransactionId;
    }

    /**
     * @return mixed
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @param mixed $callbackUrl
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
