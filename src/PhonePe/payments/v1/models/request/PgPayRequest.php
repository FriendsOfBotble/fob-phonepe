<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request;

class PgPayRequest implements \JsonSerializable
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
     * @var PaymentInstrument
     */
    private $paymentInstrument;
    private $deviceContext;

    /**
     * @param $merchantId
     * @param $merchantTransactionId
     * @param $amount
     * @param $merchantUserId
     * @param $redirectUrl
     * @param $redirectMode
     * @param $callbackUrl
     * @param $mobileNumber
     * @param PaymentInstrument $paymentInstrument
     * @param $deviceContext
     */
    public function __construct($merchantId, $merchantTransactionId, $amount, $merchantUserId, $redirectUrl, $redirectMode, $callbackUrl, $mobileNumber, PaymentInstrument $paymentInstrument, $deviceContext = null)
    {
        $this->merchantId = $merchantId;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->amount = $amount;
        $this->merchantUserId = $merchantUserId;
        $this->redirectUrl = $redirectUrl;
        $this->redirectMode = $redirectMode;
        $this->callbackUrl = $callbackUrl;
        $this->mobileNumber = $mobileNumber;
        $this->paymentInstrument = $paymentInstrument;
        $this->deviceContext = $deviceContext;
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
    public function getMerchantUserId()
    {
        return $this->merchantUserId;
    }

    /**
     * @param mixed $merchantUserId
     */
    public function setMerchantUserId($merchantUserId)
    {
        $this->merchantUserId = $merchantUserId;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param mixed $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return mixed
     */
    public function getRedirectMode()
    {
        return $this->redirectMode;
    }

    /**
     * @param mixed $redirectMode
     */
    public function setRedirectMode($redirectMode)
    {
        $this->redirectMode = $redirectMode;
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

    /**
     * @return mixed
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param mixed $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return PaymentInstrument
     */
    public function getPaymentInstrument(): PaymentInstrument
    {
        return $this->paymentInstrument;
    }

    /**
     * @param PaymentInstrument $paymentInstrument
     */
    public function setPaymentInstrument(PaymentInstrument $paymentInstrument)
    {
        $this->paymentInstrument = $paymentInstrument;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
