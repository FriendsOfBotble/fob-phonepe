<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;

class NetBankingPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    private $bankId;

    public function __construct($bankId)
    {
        $this->bankId = $bankId;
        parent::__construct(PaymentInstrumentConstants::NET_BANKING);
    }

    /**
     * @return mixed
     */
    public function getBankId()
    {
        return $this->bankId;
    }

    /**
     * @param mixed $bankId
     */
    public function setBankId($bankId)
    {
        $this->bankId = $bankId;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }
}
