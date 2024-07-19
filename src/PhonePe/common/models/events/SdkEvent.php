<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\models\events;

use FriendsOfBotble\PhonePe\PhonePe\common\config\Headers;
use FriendsOfBotble\PhonePe\PhonePe\common\models\constants\EventType;
use FriendsOfBotble\PhonePe\PhonePe\common\models\constants\FlowType;
use FriendsOfBotble\PhonePe\PhonePe\common\models\constants\TransactionType;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgPayRequest;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgRefundRequest;

class SdkEvent extends BaseEvent
{
    private $transactionType;
    private $merchantTransactionId;
    private $merchantId;
    private $amount;
    private $callbackUrl;
    private $originalTransactionId;
    private $vpa;
    private $includeBankList;
    private $instrumentType;

    /**
     * @return mixed
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param mixed $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
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
    public function getVpa()
    {
        return $this->vpa;
    }

    /**
     * @param mixed $vpa
     */
    public function setVpa($vpa)
    {
        $this->vpa = $vpa;
    }

    /**
     * @return mixed
     */
    public function getIncludeBankList()
    {
        return $this->includeBankList;
    }

    /**
     * @param mixed $includeBankList
     */
    public function setIncludeBankList($includeBankList)
    {
        $this->includeBankList = $includeBankList;
    }

    /**
     * @return mixed
     */
    public function getInstrumentType()
    {
        return $this->instrumentType;
    }

    /**
     * @param mixed $instrumentType
     */
    public function setInstrumentType($instrumentType)
    {
        $this->instrumentType = $instrumentType;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }

    public static function populateMeta(): SdkEvent
    {
        $sdkEvent = new SdkEvent();
        $sdkEvent->setSdkType(Headers::SDK_TYPE);
        $sdkEvent->setSdkVersion(Headers::SDK_VERSION);
        $sdkEvent->setId(bin2hex(random_bytes(20)));
        $sdkEvent->setTime(date('c'));
        $sdkEvent->setFlowType(FlowType::B2B_PG);

        return $sdkEvent;
    }

    public static function buildClientInitEvent($eventState, $merchantId): SdkEvent
    {
        $sdkEvent = SdkEvent::populateMeta();
        $sdkEvent->setEventState($eventState);
        $sdkEvent->setEventType(EventType::CLIENT_INITIALIZED);
        $sdkEvent->setMerchantId($merchantId);

        return $sdkEvent;
    }

    public static function buildRefundEvent($eventState, PgRefundRequest $pgRefundRequest, $message = ''): SdkEvent
    {
        $sdkEvent = SdkEvent::populateMeta();
        $sdkEvent->setEventType(EventType::REFUND);
        $sdkEvent->setEventState($eventState);
        $sdkEvent->setMerchantTransactionId($pgRefundRequest->getMerchantTransactionId());
        $sdkEvent->setMerchantId($pgRefundRequest->getMerchantId());
        $sdkEvent->setAmount($pgRefundRequest->getAmount());
        $sdkEvent->setCallbackUrl($pgRefundRequest->getCallbackUrl());
        $sdkEvent->setOriginalTransactionId($pgRefundRequest->getOriginalTransactionId());
        $sdkEvent->setTransactionType(TransactionType::REVERSAL);
        $sdkEvent->setMessage($message);

        return $sdkEvent;
    }

    public static function buildPayEvent($eventState, PgPayRequest $pgPayRequest, $message = ''): SdkEvent
    {
        $sdkEvent = SdkEvent::populateMeta();
        $sdkEvent->setEventState($eventState);
        $sdkEvent->setEventType(EventType::PAY);
        $sdkEvent->setMerchantTransactionId($pgPayRequest->getMerchantTransactionId());
        $sdkEvent->setAmount($pgPayRequest->getAmount());
        $sdkEvent->setInstrumentType($pgPayRequest->getPaymentInstrument()->getType());
        $sdkEvent->setCallbackUrl($pgPayRequest->getCallbackUrl());
        $sdkEvent->setMerchantId($pgPayRequest->getMerchantId());
        $sdkEvent->setTransactionType(TransactionType::DEBIT);
        $sdkEvent->setMessage($message);

        return $sdkEvent;
    }

    public static function buildStatusCheckEvent($eventState, $merchantId, $merchantTransactionId, $code = '', $message = ''): SdkEvent
    {
        $sdkEvent = SdkEvent::populateMeta();
        $sdkEvent->setEventState($eventState);
        $sdkEvent->setEventType(EventType::STATUS_CHECK);
        $sdkEvent->setMerchantId($merchantId);
        $sdkEvent->setMerchantTransactionId($merchantTransactionId);
        $sdkEvent->setCode($code);
        $sdkEvent->setMessage($message);

        return $sdkEvent;
    }

    public static function buildValidateVpaEvent($eventState, $vpa, $merchantId, $message = ''): SdkEvent
    {
        $sdkEvent = SdkEvent::populateMeta();
        $sdkEvent->setEventState($eventState);
        $sdkEvent->setEventType(EventType::VALIDATE_VPA);
        $sdkEvent->setMerchantId($merchantId);
        $sdkEvent->setVpa($vpa);
        $sdkEvent->setMessage($message);

        return $sdkEvent;
    }

    public static function buildPaymentOptionsEvent($eventState, bool $includeBankList, $merchantId, $message = ''): SdkEvent
    {
        $sdkEvent = SdkEvent::populateMeta();
        $sdkEvent->setEventState($eventState);
        $sdkEvent->setMerchantId($merchantId);
        $sdkEvent->setEventType(EventType::PAYMENT_OPTIONS);
        $sdkEvent->setMessage($message);
        $sdkEvent->setIncludeBankList($includeBankList);

        return $sdkEvent;
    }

}
