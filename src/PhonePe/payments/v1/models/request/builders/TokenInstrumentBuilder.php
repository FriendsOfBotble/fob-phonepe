<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\Expiry;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\TokenDetails;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\TokenPaymentInstrument;

class TokenInstrumentBuilder
{
    private $authMode;
    private $encryptedCvv;
    private $cryptogram;
    private $encryptedToken;
    private $encryptionKeyId;
    private $panSuffix;
    private $cardHolderName;
    private $expiryMonth;
    private $expiryYear;

    /**
     * @param mixed $authMode
     */
    public function authMode($authMode): TokenInstrumentBuilder
    {
        $this->authMode = $authMode;

        return $this;
    }

    /**
     * @param mixed $encryptedCvv
     */
    public function encryptedCvv($encryptedCvv): TokenInstrumentBuilder
    {
        $this->encryptedCvv = $encryptedCvv;

        return $this;
    }

    /**
     * @param mixed $cryptogram
     */
    public function cryptogram($cryptogram): TokenInstrumentBuilder
    {
        $this->cryptogram = $cryptogram;

        return $this;
    }

    /**
     * @param mixed $encryptedToken
     */
    public function encryptedToken($encryptedToken): TokenInstrumentBuilder
    {
        $this->encryptedToken = $encryptedToken;

        return $this;
    }

    /**
     * @param mixed $encryptionKeyId
     */
    public function encryptionKeyId($encryptionKeyId): TokenInstrumentBuilder
    {
        $this->encryptionKeyId = $encryptionKeyId;

        return $this;
    }

    /**
     * @param mixed $panSuffix
     */
    public function panSuffix($panSuffix): TokenInstrumentBuilder
    {
        $this->panSuffix = $panSuffix;

        return $this;
    }

    /**
     * @param mixed $cardHolderName
     */
    public function cardHolderName($cardHolderName): TokenInstrumentBuilder
    {
        $this->cardHolderName = $cardHolderName;

        return $this;
    }

    /**
     * @param mixed $expiryMonth
     */
    public function expiryMonth($expiryMonth): TokenInstrumentBuilder
    {
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @param mixed $expiryYear
     */
    public function expiryYear($expiryYear): TokenInstrumentBuilder
    {
        $this->expiryYear = $expiryYear;

        return $this;
    }

    public function build(): TokenPaymentInstrument
    {
        return new TokenPaymentInstrument(
            $this->authMode,
            new TokenDetails(
                $this->encryptedCvv,
                $this->cryptogram,
                $this->encryptedToken,
                $this->encryptionKeyId,
                new Expiry(
                    $this->expiryMonth,
                    $this->expiryYear
                ),
                $this->panSuffix,
                $this->cardHolderName
            )
        );
    }

}
