<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\BillingAddress;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\CardDetails;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\CardPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\Expiry;

class NewCardInstrumentBuilder
{
    private $encryptedCvv;
    private $expiryMonth;
    private $expiryYear;
    private $encryptionKeyId;
    private $cardHolderName;
    private $encryptedCardNumber;
    private $saveCard;
    private $authMode;
    private $billingAddressLine1;
    private $billingAddressLine2;
    private $billingAddressCity;
    private $billingAddressState;
    private $billingAddressZip;
    private $billingAddressCountry;

    /**
     * @param mixed $encryptedCvv
     */
    public function encryptedCvv($encryptedCvv): NewCardInstrumentBuilder
    {
        $this->encryptedCvv = $encryptedCvv;

        return $this;
    }

    /**
     * @param mixed $expiryMonth
     */
    public function expiryMonth($expiryMonth): NewCardInstrumentBuilder
    {
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @param mixed $expiryYear
     */
    public function expiryYear($expiryYear): NewCardInstrumentBuilder
    {
        $this->expiryYear = $expiryYear;

        return $this;
    }

    /**
     * @param mixed $encryptionKeyId
     */
    public function encryptionKeyId($encryptionKeyId): NewCardInstrumentBuilder
    {
        $this->encryptionKeyId = $encryptionKeyId;

        return $this;
    }

    /**
     * @param mixed $cardHolderName
     */
    public function cardHolderName($cardHolderName): NewCardInstrumentBuilder
    {
        $this->cardHolderName = $cardHolderName;

        return $this;
    }

    /**
     * @param mixed $encryptedCardNumber
     */
    public function encryptedCardNumber($encryptedCardNumber): NewCardInstrumentBuilder
    {
        $this->encryptedCardNumber = $encryptedCardNumber;

        return $this;
    }

    /**
     * @param mixed $saveCard
     */
    public function saveCard($saveCard): NewCardInstrumentBuilder
    {
        $this->saveCard = $saveCard;

        return $this;
    }

    /**
     * @param mixed $authMode
     */
    public function authMode($authMode): NewCardInstrumentBuilder
    {
        $this->authMode = $authMode;

        return $this;
    }

    /**
     * @param mixed $billingAddressLine1
     */
    public function billingAddressLine1($billingAddressLine1): NewCardInstrumentBuilder
    {
        $this->billingAddressLine1 = $billingAddressLine1;

        return $this;
    }

    /**
     * @param mixed $billingAddressLine2
     */
    public function billingAddressLine2($billingAddressLine2): NewCardInstrumentBuilder
    {
        $this->billingAddressLine2 = $billingAddressLine2;

        return $this;
    }

    /**
     * @param mixed $billingAddressCity
     */
    public function billingAddressCity($billingAddressCity): NewCardInstrumentBuilder
    {
        $this->billingAddressCity = $billingAddressCity;

        return $this;
    }

    /**
     * @param mixed $billingAddressState
     */
    public function billingAddressState($billingAddressState): NewCardInstrumentBuilder
    {
        $this->billingAddressState = $billingAddressState;

        return $this;
    }

    /**
     * @param mixed $billingAddressZip
     */
    public function billingAddressZip($billingAddressZip): NewCardInstrumentBuilder
    {
        $this->billingAddressZip = $billingAddressZip;

        return $this;
    }

    /**
     * @param mixed $billingAddressCountry
     */
    public function billingAddressCountry($billingAddressCountry): NewCardInstrumentBuilder
    {
        $this->billingAddressCountry = $billingAddressCountry;

        return $this;
    }

    public function build(): CardPaymentInstrument
    {
        return new CardPaymentInstrument(
            $this->authMode,
            new CardDetails(
                $this->encryptedCardNumber,
                $this->encryptionKeyId,
                $this->cardHolderName,
                new Expiry(
                    $this->expiryMonth,
                    $this->expiryYear
                ),
                $this->encryptedCvv,
                new BillingAddress(
                    $this->billingAddressLine1,
                    $this->billingAddressLine2,
                    $this->billingAddressCity,
                    $this->billingAddressState,
                    $this->billingAddressZip,
                    $this->billingAddressCountry
                )
            ),
            $this->saveCard
        );
    }

}
