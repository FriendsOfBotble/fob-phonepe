<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgRefundRequest;

class PgRefundRequestBuilder
{
    private $merchantId;
    private $merchantTransactionId;
    private $amount;
    private $originalTransactionId;
    private $callbackUrl;

    public static function builder(): PgRefundRequestBuilder
    {
        return new PgRefundRequestBuilder();
    }

    public function build(): PgRefundRequest
    {
        return new PgRefundRequest(
            $this->merchantId,
            $this->merchantTransactionId,
            $this->amount,
            $this->originalTransactionId,
            $this->callbackUrl
        );
    }

    /**
     * @param mixed $merchantId
     * @return PgRefundRequestBuilder
     */
    public function merchantId($merchantId): PgRefundRequestBuilder
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * @param mixed $merchantTransactionId
     * @return PgRefundRequestBuilder
     */
    public function merchantTransactionId($merchantTransactionId): PgRefundRequestBuilder
    {
        $this->merchantTransactionId = $merchantTransactionId;

        return $this;
    }

    /**
     * @param mixed $amount
     * @return PgRefundRequestBuilder
     */
    public function amount($amount): PgRefundRequestBuilder
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param mixed $originalTransactionId
     * @return PgRefundRequestBuilder
     */
    public function originalTransactionId($originalTransactionId): PgRefundRequestBuilder
    {
        $this->originalTransactionId = $originalTransactionId;

        return $this;
    }

    /**
     * @param mixed $callbackUrl
     * @return PgRefundRequestBuilder
     */
    public function callbackUrl($callbackUrl): PgRefundRequestBuilder
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }
}
