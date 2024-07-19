<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;

class UpiIntentPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    private $targetApp;

    public function __construct($targetApp)
    {
        $this->targetApp = $targetApp;
        parent::__construct(PaymentInstrumentConstants::UPI_INTENT);
    }

    /**
     * @return mixed
     */
    public function getTargetApp()
    {
        return $this->targetApp;
    }

    /**
     * @param mixed $targetApp
     */
    public function setTargetApp($targetApp)
    {
        $this->targetApp = $targetApp;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }
}
