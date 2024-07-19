<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class CallbackResponse
{
    private $merchantId;
    private $merchantTransactionId;
    private $transactionId;
    private $amount;
    private $state;
    private $responseCode;
    private $paymentInstrument;
    private $utr;

    public function __construct($merchant_id, $merchant_transaction_id, $transaction_id, $amount_in_paisa, $payment_state, $pay_response_code, $payment_instrument_type, $utr)
    {
        $this->merchantId = $merchant_id;
        $this->merchantTransactionId = $merchant_transaction_id;
        $this->transactionId = $transaction_id;
        $this->amount = $amount_in_paisa;
        $this->state = $payment_state;
        $this->responseCode = $pay_response_code;
        $this->paymentInstrument = $payment_instrument_type;
        $this->utr = $utr;
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

    /**
     * @return mixed
     */
    public function getUtr()
    {
        return $this->utr;
    }

    /**
     * @param mixed $utr
     */
    public function setUtr($utr)
    {
        $this->utr = $utr;
    }

    public static function getInstanceFrom($json_callback_payload): CallbackResponse
    {
        return new CallbackResponse(
            $json_callback_payload['data']['merchantId'],
            $json_callback_payload['data']['merchantTransactionId'],
            $json_callback_payload['data']['transactionId'],
            $json_callback_payload['data']['amount'],
            $json_callback_payload['state'],
            $json_callback_payload['code'],
            $json_callback_payload['data']['paymentInstrument']['type'],
            $json_callback_payload['data']['paymentInstrument']['utr']
        );
    }
}
