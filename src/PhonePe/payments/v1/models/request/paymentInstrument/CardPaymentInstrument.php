<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;

class CardPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    /**
     * @var mixed
     * @desc The authentication mode for the card payment. Generally 3DS is used
     * example 3DS, H2H
     */
    private $authMode;
    /**
     * @var CardDetails
     */
    private $cardDetails;
    private $saveCard;

    /**
     * @param $authMode
     * @param CardDetails $cardDetails
     * @param $saveCard
     */
    public function __construct($authMode, CardDetails $cardDetails, $saveCard)
    {
        parent::__construct(PaymentInstrumentConstants::CARD);
        $this->authMode = $authMode;
        $this->cardDetails = $cardDetails;
        $this->saveCard = $saveCard;
    }

    /**
     * @return mixed
     */
    public function getAuthMode()
    {
        return $this->authMode;
    }

    /**
     * @param mixed $authMode
     */
    public function setAuthMode($authMode)
    {
        $this->authMode = $authMode;
    }

    /**
     * @return CardDetails
     */
    public function getCardDetails(): CardDetails
    {
        return $this->cardDetails;
    }

    /**
     * @param CardDetails $cardDetails
     */
    public function setCardDetails(CardDetails $cardDetails)
    {
        $this->cardDetails = $cardDetails;
    }

    /**
     * @return mixed
     */
    public function getSaveCard()
    {
        return $this->saveCard;
    }

    /**
     * @param mixed $saveCard
     */
    public function setSaveCard($saveCard)
    {
        $this->saveCard = $saveCard;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }
}
