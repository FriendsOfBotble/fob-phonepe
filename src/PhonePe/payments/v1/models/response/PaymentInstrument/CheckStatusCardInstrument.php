<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

class CheckStatusCardInstrument extends CheckStatusPaymentInstrument implements \JsonSerializable
{
    private $cardType;
    private $pgTransactionId;
    private $bankTransactionId;
    private $pgAuthorizationCode;
    private $arn;
    private $bankId;

    /**
     * @param $cardType
     * @param $pgTransactionId
     * @param $bankTransactionId
     * @param $pgAuthorizationCode
     * @param $arn
     * @param $bankId
     */
    public function __construct($cardType, $pgTransactionId, $bankTransactionId, $pgAuthorizationCode, $arn, $bankId)
    {
        parent::__construct(CheckStatusPaymentInstrumentConstants::CARD);
        $this->cardType = $cardType;
        $this->pgTransactionId = $pgTransactionId;
        $this->bankTransactionId = $bankTransactionId;
        $this->pgAuthorizationCode = $pgAuthorizationCode;
        $this->arn = $arn;
        $this->bankId = $bankId;
    }

    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @param mixed $cardType
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    }

    /**
     * @return mixed
     */
    public function getPgTransactionId()
    {
        return $this->pgTransactionId;
    }

    /**
     * @param mixed $pgTransactionId
     */
    public function setPgTransactionId($pgTransactionId)
    {
        $this->pgTransactionId = $pgTransactionId;
    }

    /**
     * @return mixed
     */
    public function getBankTransactionId()
    {
        return $this->bankTransactionId;
    }

    /**
     * @param mixed $bankTransactionId
     */
    public function setBankTransactionId($bankTransactionId)
    {
        $this->bankTransactionId = $bankTransactionId;
    }

    /**
     * @return mixed
     */
    public function getPgAuthorizationCode()
    {
        return $this->pgAuthorizationCode;
    }

    /**
     * @param mixed $pgAuthorizationCode
     */
    public function setPgAuthorizationCode($pgAuthorizationCode)
    {
        $this->pgAuthorizationCode = $pgAuthorizationCode;
    }

    /**
     * @return mixed
     */
    public function getArn()
    {
        return $this->arn;
    }

    /**
     * @param mixed $arn
     */
    public function setArn($arn)
    {
        $this->arn = $arn;
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
