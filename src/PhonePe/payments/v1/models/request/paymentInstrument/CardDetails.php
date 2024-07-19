<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

class CardDetails implements \JsonSerializable
{
    private $encryptedCardNumber;
    private $encryptionKeyId;
    private $cardHolderName;
    /**
     * @var Expiry
     */
    private $expiry;
    private $encryptedCvv;
    /**
     * @var BillingAddress
     */
    private $billingAddress;

    /**
     * @param $encryptedCardNumber
     * @param $encryptionKeyId
     * @param $cardHolderName
     * @param Expiry $expiry
     * @param $encryptedCvv
     * @param BillingAddress $billingAddress
     */
    public function __construct($encryptedCardNumber, $encryptionKeyId, $cardHolderName, Expiry $expiry, $encryptedCvv, BillingAddress $billingAddress)
    {
        $this->encryptedCardNumber = $encryptedCardNumber;
        $this->encryptionKeyId = $encryptionKeyId;
        $this->cardHolderName = $cardHolderName;
        $this->expiry = $expiry;
        $this->encryptedCvv = $encryptedCvv;
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return mixed
     */
    public function getEncryptedCardNumber()
    {
        return $this->encryptedCardNumber;
    }

    /**
     * @param mixed $encryptedCardNumber
     */
    public function setEncryptedCardNumber($encryptedCardNumber)
    {
        $this->encryptedCardNumber = $encryptedCardNumber;
    }

    /**
     * @return mixed
     */
    public function getEncryptionKeyId()
    {
        return $this->encryptionKeyId;
    }

    /**
     * @param mixed $encryptionKeyId
     */
    public function setEncryptionKeyId($encryptionKeyId)
    {
        $this->encryptionKeyId = $encryptionKeyId;
    }

    /**
     * @return mixed
     */
    public function getCardHolderName()
    {
        return $this->cardHolderName;
    }

    /**
     * @param mixed $cardHolderName
     */
    public function setCardHolderName($cardHolderName)
    {
        $this->cardHolderName = $cardHolderName;
    }

    /**
     * @return Expiry
     */
    public function getExpiry(): Expiry
    {
        return $this->expiry;
    }

    /**
     * @param Expiry $expiry
     */
    public function setExpiry(Expiry $expiry)
    {
        $this->expiry = $expiry;
    }

    /**
     * @return mixed
     */
    public function getEncryptedCvv()
    {
        return $this->encryptedCvv;
    }

    /**
     * @param mixed $encryptedCvv
     */
    public function setEncryptedCvv($encryptedCvv)
    {
        $this->encryptedCvv = $encryptedCvv;
    }

    /**
     * @return BillingAddress
     */
    public function getBillingAddress(): BillingAddress
    {
        return $this->billingAddress;
    }

    /**
     * @param BillingAddress $billingAddress
     */
    public function setBillingAddress(BillingAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
