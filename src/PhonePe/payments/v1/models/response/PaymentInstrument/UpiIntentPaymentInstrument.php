<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

class UpiIntentPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    private $intentUrl;

    public function __construct($intentUrl)
    {
        parent::__construct(PaymentInstrumentConstants::UPI_INTENT);
        $this->intentUrl = $intentUrl;
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }

}
