<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

class UpiQrPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    private $intentUrl;
    private $qrData;

    public function __construct($intentUrl, $qrData)
    {
        parent::__construct(PaymentInstrumentConstants::UPI_INTENT);
        $this->intentUrl = $intentUrl;
        $this->qrData = $qrData;
    }

    /**
     * @return mixed
     */
    public function getIntentUrl()
    {
        return $this->intentUrl;
    }

    /**
     * @param mixed $intentUrl
     */
    public function setIntentUrl($intentUrl)
    {
        $this->intentUrl = $intentUrl;
    }

    /**
     * @return mixed
     */
    public function getQrData()
    {
        return $this->qrData;
    }

    /**
     * @param mixed $qrData
     */
    public function setQrData($qrData)
    {
        $this->qrData = $qrData;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }

}
