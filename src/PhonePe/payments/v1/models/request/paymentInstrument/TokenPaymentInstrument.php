<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PaymentInstrument;

class TokenPaymentInstrument extends PaymentInstrument implements \JsonSerializable
{
    /**
     * @var mixed
     * @desc The authentication mode for the card payment. Generally 3DS is used
     * example 3DS, H2H
     */
    private $authMode;
    /**
     * @var TokenDetails
     */
    private $tokenDetails;

    /**
     * @param $authMode
     * @param TokenDetails $tokenDetails
     */
    public function __construct($authMode, TokenDetails $tokenDetails)
    {
        parent::__construct(PaymentInstrumentConstants::TOKEN);
        $this->authMode = $authMode;
        $this->tokenDetails = $tokenDetails;
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
     * @return TokenDetails
     */
    public function getTokenDetails(): TokenDetails
    {
        return $this->tokenDetails;
    }

    /**
     * @param TokenDetails $tokenDetails
     */
    public function setTokenDetails(TokenDetails $tokenDetails)
    {
        $this->tokenDetails = $tokenDetails;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }
}
