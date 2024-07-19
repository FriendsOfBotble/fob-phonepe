<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;

class SavedCardPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    /**
     * @var mixed
     * @desc The authentication mode for the card payment. Generally 3DS is used
     * possible values 3DS, H2H
     */
    private $authMode;
    /**
     * @var SavedCardDetails
     */
    private $cardDetails;

    /**
     * @param $authMode
     * @param SavedCardDetails $cardDetails
     */
    public function __construct($authMode, SavedCardDetails $cardDetails)
    {
        parent::__construct(PaymentInstrumentConstants::SAVED_CARD);
        $this->authMode = $authMode;
        $this->cardDetails = $cardDetails;
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
     * @return SavedCardDetails
     */
    public function getSavedCardDetails(): SavedCardDetails
    {
        return $this->cardDetails;
    }

    /**
     * @param SavedCardDetails $cardDetails
     */
    public function setSavedCardDetails(SavedCardDetails $cardDetails)
    {
        $this->cardDetails = $cardDetails;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }
}
