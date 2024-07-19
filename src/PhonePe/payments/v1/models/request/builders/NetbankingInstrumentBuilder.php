<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\NetBankingPaymentInstrument;

class NetbankingInstrumentBuilder
{
    private $bankId;

    public function bankId($bankId): NetbankingInstrumentBuilder
    {
        $this->bankId = $bankId;

        return $this;
    }

    public function build(): NetBankingPaymentInstrument
    {
        return new NetBankingPaymentInstrument($this->bankId);
    }
}
