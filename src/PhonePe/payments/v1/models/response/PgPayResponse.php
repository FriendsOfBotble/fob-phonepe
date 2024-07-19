<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgPayResponse implements \JsonSerializable
{
    private $merchantId;
    private $merchantTransactionId;
    /**
     * @var PaymentInstrument
     */
    private $instrumentResponse;

    /**
     * @param $merchantId
     * @param $merchantTransactionId
     */
    public function __construct($merchantId, $merchantTransactionId, PaymentInstrument $instrumentResponse)
    {
        $this->merchantId = $merchantId;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->instrumentResponse = $instrumentResponse;
    }

    /**
     * @return mixed $merchantId
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
     * @return mixed $merchantTransactionId
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
     * @return PaymentInstrument $instrumentResponse
     */
    public function getInstrumentResponse(): PaymentInstrument
    {
        return $this->instrumentResponse;
    }

    /**
     * @param PaymentInstrument $instrumentResponse
     */
    public function setInstrumentResponse(PaymentInstrument $instrumentResponse)
    {
        $this->instrumentResponse = $instrumentResponse;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
