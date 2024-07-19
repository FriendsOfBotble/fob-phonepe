<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgNetBankingBank implements \JsonSerializable
{
    private $bankId;
    private $bankName;
    private $bankShortName;
    private $available;
    private $accountConstraintSupported;
    private $priority;

    /**
     * @param $bankId
     * @param $bankName
     * @param $bankShortName
     * @param $available
     * @param $accountConstraintSupported
     * @param $priority
     */
    public function __construct($bankId, $bankName, $bankShortName, $available, $accountConstraintSupported, $priority)
    {
        $this->bankId = $bankId;
        $this->bankName = $bankName;
        $this->bankShortName = $bankShortName;
        $this->available = $available;
        $this->accountConstraintSupported = $accountConstraintSupported;
        $this->priority = $priority;
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

    /**
     * @return mixed
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param mixed $bankName
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    /**
     * @return mixed
     */
    public function getBankShortName()
    {
        return $this->bankShortName;
    }

    /**
     * @param mixed $bankShortName
     */
    public function setBankShortName($bankShortName)
    {
        $this->bankShortName = $bankShortName;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getAccountConstraintSupported()
    {
        return $this->accountConstraintSupported;
    }

    /**
     * @param mixed $accountConstraintSupported
     */
    public function setAccountConstraintSupported($accountConstraintSupported)
    {
        $this->accountConstraintSupported = $accountConstraintSupported;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
