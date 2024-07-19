<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\PgDeviceContext;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgPayRequest;

class PgPayRequestBuilder
{
    private $merchantId;
    private $merchantTransactionId;
    private $amount;
    private $merchantUserId;
    private $redirectUrl;
    private $redirectMode;
    private $callbackUrl;
    private $mobileNumber;
    /**
     * @var PgDeviceContext
     */
    private $deviceContext;
    /**
     * @var PaymentInstrument
     */
    private $paymentInstrument;

    /**
     * @param mixed $merchantId
     */
    public function merchantId($merchantId): PgPayRequestBuilder
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * @param mixed $merchantTransactionId
     */
    public function merchantTransactionId($merchantTransactionId): PgPayRequestBuilder
    {
        $this->merchantTransactionId = $merchantTransactionId;

        return $this;
    }

    /**
     * @param mixed $amount
     */
    public function amount($amount): PgPayRequestBuilder
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param mixed $merchantUserId
     */
    public function merchantUserId($merchantUserId): PgPayRequestBuilder
    {
        $this->merchantUserId = $merchantUserId;

        return $this;
    }

    /**
     * @param mixed $redirectUrl
     */
    public function redirectUrl($redirectUrl): PgPayRequestBuilder
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * @param mixed $redirectMode
     */
    public function redirectMode($redirectMode): PgPayRequestBuilder
    {
        $this->redirectMode = $redirectMode;

        return $this;
    }

    /**
     * @param mixed $callbackUrl
     */
    public function callbackUrl($callbackUrl): PgPayRequestBuilder
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }

    /**
     * @param mixed $mobileNumber
     */
    public function mobileNumber($mobileNumber): PgPayRequestBuilder
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * @param PaymentInstrument $paymentInstrument
     */
    public function paymentInstrument(PaymentInstrument $paymentInstrument): PgPayRequestBuilder
    {
        $this->paymentInstrument = $paymentInstrument;

        return $this;
    }

    /**
     * @param mixed $deviceContext
     */
    public function deviceContext($deviceContext): PgPayRequestBuilder
    {
        $this->deviceContext = new PgDeviceContext($deviceContext);

        return $this;
    }

    public static function builder(): PgPayRequestBuilder
    {
        return new PgPayRequestBuilder();
    }

    public function build(): PgPayRequest
    {
        return new PgPayRequest(
            $this->merchantId,
            $this->merchantTransactionId,
            $this->amount,
            $this->merchantUserId,
            $this->redirectUrl,
            $this->redirectMode,
            $this->callbackUrl,
            $this->mobileNumber,
            $this->paymentInstrument,
            $this->deviceContext
        );
    }
}
