<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgRefundResponse implements \JsonSerializable
{
    private $merchantId;
    private $merchantTransactionId;
    private $transactionId;
    private $amount;
    private $state;
    private $responseCode;

    /**
    * @param mixed $merchantId
    * @param mixed $merchantTransactionId
    * @param mixed $transactionId
    * @param mixed $amount
    * @param mixed $state
    * @param mixed $responseCode $name
     */

    public function __construct($merchantId, $merchantTransactionId, $transactionId, $amount, $state, $responseCode)
    {
        $this->merchantId = $merchantId;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->state = $state;
        $this->responseCode = $responseCode;
    }

    /**
     * @return mixed $merchantId
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return mixed $merchantTransactionId
     */
    public function getMerchantTransactionId()
    {
        return $this->merchantTransactionId;
    }

    /**
     * @return mixed $transactionId
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return mixed $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed $responseCode
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
