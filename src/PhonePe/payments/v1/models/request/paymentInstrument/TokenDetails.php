<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

class TokenDetails implements \JsonSerializable
{
    private $encryptedCvv;
    private $cryptogram;
    private $encryptedToken;
    private $encryptionKeyId;
    /**
     * @var Expiry
     */
    private $expiry;
    private $panSuffix;
    private $cardHolderName;

    /**
     * @param $encryptedCvv
     * @param $cryptogram
     * @param $encryptedToken
     * @param $encryptionKeyId
     * @param Expiry $expiry
     * @param $panSuffix
     * @param $cardHolderName
     */
    public function __construct($encryptedCvv, $cryptogram, $encryptedToken, $encryptionKeyId, Expiry $expiry, $panSuffix, $cardHolderName)
    {
        $this->encryptedCvv = $encryptedCvv;
        $this->cryptogram = $cryptogram;
        $this->encryptedToken = $encryptedToken;
        $this->encryptionKeyId = $encryptionKeyId;
        $this->expiry = $expiry;
        $this->panSuffix = $panSuffix;
        $this->cardHolderName = $cardHolderName;
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
     * @return mixed
     */
    public function getCryptogram()
    {
        return $this->cryptogram;
    }

    /**
     * @param mixed $cryptogram
     */
    public function setCryptogram($cryptogram)
    {
        $this->cryptogram = $cryptogram;
    }

    /**
     * @return mixed
     */
    public function getEncryptedToken()
    {
        return $this->encryptedToken;
    }

    /**
     * @param mixed $encryptedToken
     */
    public function setEncryptedToken($encryptedToken)
    {
        $this->encryptedToken = $encryptedToken;
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
    public function getPanSuffix()
    {
        return $this->panSuffix;
    }

    /**
     * @param mixed $panSuffix
     */
    public function setPanSuffix($panSuffix)
    {
        $this->panSuffix = $panSuffix;
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
