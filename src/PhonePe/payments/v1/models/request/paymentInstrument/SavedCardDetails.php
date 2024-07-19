<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument;

class SavedCardDetails implements \JsonSerializable
{
    private $cardId;
    private $encryptedCvv;
    /**
     * @var int
     */
    private $encryptionKeyId;

    /**
     * @param $cardId
     * @param $encryptedCvv
     * @param $encryptionKeyId
     */
    public function __construct($cardId, $encryptedCvv, $encryptionKeyId)
    {
        $this->cardId = $cardId;
        $this->encryptedCvv = $encryptedCvv;
        $this->encryptionKeyId = $encryptionKeyId;
    }

    /**
     * @return mixed
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * @param mixed $cardId
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
