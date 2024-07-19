<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\SavedCardDetails;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\SavedCardPaymentInstrument;

class SavedCardInstrumentBuilder
{
    private $encryptedCvv;
    private $encryptionKeyId;
    private $authMode;
    private $cardId;

    /**
     * @param mixed $encryptedCvv
     */
    public function encryptedCvv($encryptedCvv): SavedCardInstrumentBuilder
    {
        $this->encryptedCvv = $encryptedCvv;

        return $this;
    }

    /**
     * @param mixed $encryptionKeyId
     */
    public function encryptionKeyId($encryptionKeyId): SavedCardInstrumentBuilder
    {
        $this->encryptionKeyId = $encryptionKeyId;

        return $this;
    }

    /**
     * @param mixed $authMode
     */
    public function authMode($authMode): SavedCardInstrumentBuilder
    {
        $this->authMode = $authMode;

        return $this;
    }

    /**
     * @param mixed $cardId
     */
    public function cardId($cardId): SavedCardInstrumentBuilder
    {
        $this->cardId = $cardId;

        return $this;
    }

    public function build(): SavedCardPaymentInstrument
    {
        return new SavedCardPaymentInstrument(
            $this->authMode,
            new SavedCardDetails(
                $this->cardId,
                $this->encryptedCvv,
                $this->encryptionKeyId
            )
        );
    }

}
