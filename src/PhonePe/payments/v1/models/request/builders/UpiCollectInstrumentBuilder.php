<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\UpiCollectPaymentInstrument;

class UpiCollectInstrumentBuilder
{
    private $vpa;

    public function vpa($vpa): UpiCollectInstrumentBuilder
    {
        $this->vpa = $vpa;

        return $this;
    }

    public function build(): UpiCollectPaymentInstrument
    {
        return new UpiCollectPaymentInstrument($this->vpa);
    }
}
