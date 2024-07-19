<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;

class CheckStatusNetbankingInstrument extends CheckStatusPaymentInstrument implements \JsonSerializable
{
    private $pgTransactionId;
    private $pgServiceTransactionId;
    private $bankTransactionId;
    private $bankId;

    /**
     * @param $pgTransactionId
     * @param $pgServiceTransactionId
     * @param $bankTransactionId
     * @param $bankId
     */
    public function __construct($pgTransactionId, $pgServiceTransactionId, $bankTransactionId, $bankId)
    {
        parent::__construct(CheckStatusPaymentInstrumentConstants::NETBANKING);
        $this->pgTransactionId = $pgTransactionId;
        $this->pgServiceTransactionId = $pgServiceTransactionId;
        $this->bankTransactionId = $bankTransactionId;
        $this->bankId = $bankId;
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
    public function getPgServiceTransactionId()
    {
        return $this->pgServiceTransactionId;
    }

    /**
     * @param mixed $pgServiceTransactionId
     */
    public function setPgServiceTransactionId($pgServiceTransactionId)
    {
        $this->pgServiceTransactionId = $pgServiceTransactionId;
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
