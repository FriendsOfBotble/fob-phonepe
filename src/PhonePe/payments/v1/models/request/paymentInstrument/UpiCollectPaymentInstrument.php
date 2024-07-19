<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;

class UpiCollectPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    private $vpa;

    public function __construct($vpa)
    {
        $this->vpa = $vpa;
        parent::__construct(PaymentInstrumentConstants::UPI_COLLECT);
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }
}
