<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

class CheckStatusUpiInstrument extends CheckStatusPaymentInstrument implements \JsonSerializable
{
    private $utr;

    /**
     * @param $utr
     */
    public function __construct($utr)
    {
        parent::__construct(CheckStatusPaymentInstrumentConstants::UPI);
        $this->utr = $utr;
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }

}
