<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PaymentOptionNetBanking extends PaymentOption implements \JsonSerializable
{
    /**
     * @var PgNetBankingBank
     */
    private $popularBanks;
    /**
     * @var PgNetBankingBank
     */
    private $topBanks;
    /**
     * @var PgNetBankingBank
     */
    private $allBanks;
    private $ttl;

    /**
     * @param $popularBanks
     */
    public function __construct($enabled, $popularBanks, $topBanks, $allBanks, $ttl)
    {
        parent::__construct($enabled);
        $this->popularBanks = $popularBanks;
        $this->allBanks = $allBanks;
        $this->topBanks = $topBanks;
        $this->ttl = $ttl;
    }

    /**
     * @return mixed
     */
    public function getPopularBanks()
    {
        return $this->popularBanks;
    }

    /**
     * @param mixed $popularBanks
     */
    public function setPopularBanks($popularBanks)
    {
        $this->popularBanks = $popularBanks;
    }

    /**
     * @return mixed
     */
    public function getTopBanks()
    {
        return $this->topBanks;
    }

    /**
     * @param mixed $topBanks
     */
    public function setTopBanks($topBanks)
    {
        $this->topBanks = $topBanks;
    }

    /**
     * @return mixed
     */
    public function getAllBanks()
    {
        return $this->allBanks;
    }

    /**
     * @param mixed $allBanks
     */
    public function setAllBanks($allBanks)
    {
        $this->allBanks = $allBanks;
    }

    /**
     * @return mixed
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param mixed $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this) + parent::jsonSerialize();
    }

}
