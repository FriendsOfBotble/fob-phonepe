<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgCheckStatusResponse implements \JsonSerializable
{
    private $merchantId;
    private $merchantTransactionId;
    private $transactionId;
    private $amount;
    private $state;
    private $responseCode;
    private $paymentInstrument;

    /**
     * @param $merchantId
     * @param $merchantTransactionId
     * @param $transactionId
     * @param $amount
     * @param $state
     * @param $responseCode
     * @param $paymentInstrument
     */
    public function __construct($merchantId, $merchantTransactionId, $transactionId, $amount, $state, $responseCode, $paymentInstrument)
    {
        $this->merchantId = $merchantId;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->state = $state;
        $this->responseCode = $responseCode;
        $this->paymentInstrument = $paymentInstrument;
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
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
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
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

    /**
     * @return mixed
     */
    public function getPaymentInstrument()
    {
        return $this->paymentInstrument;
    }

    /**
     * @param mixed $paymentInstrument
     */
    public function setPaymentInstrument($paymentInstrument)
    {
        $this->paymentInstrument = $paymentInstrument;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
