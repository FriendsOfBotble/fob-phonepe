<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response;

class PgPaymentsOptionsResponse implements \JsonSerializable
{
    /**
     * @var PaymentOption
     */
    private $upiCollect;
    /**
     * @var PaymentOption
     */
    private $intent;
    /**
     * @var PaymentOption
     */
    private $cards;
    /**
     * @var PaymentOptionNetBanking
     */
    private $netBanking;

    /**
     * @param PaymentOption $upiCollect
     * @param PaymentOption $intent
     * @param PaymentOption $cards
     * @param PaymentOptionNetBanking $netBanking
     */
    public function __construct(PaymentOption $upiCollect, PaymentOption $intent, PaymentOption $cards, PaymentOptionNetBanking $netBanking)
    {
        $this->upiCollect = $upiCollect;
        $this->intent = $intent;
        $this->cards = $cards;
        $this->netBanking = $netBanking;
    }

    /**
     * @return PaymentOption
     */
    public function getUpiCollect(): PaymentOption
    {
        return $this->upiCollect;
    }

    /**
     * @param PaymentOption $upiCollect
     */
    public function setUpiCollect(PaymentOption $upiCollect)
    {
        $this->upiCollect = $upiCollect;
    }

    /**
     * @return PaymentOption
     */
    public function getIntent(): PaymentOption
    {
        return $this->intent;
    }

    /**
     * @param PaymentOption $intent
     */
    public function setIntent(PaymentOption $intent)
    {
        $this->intent = $intent;
    }

    /**
     * @return PaymentOption
     */
    public function getCards(): PaymentOption
    {
        return $this->cards;
    }

    /**
     * @param PaymentOption $cards
     */
    public function setCards(PaymentOption $cards)
    {
        $this->cards = $cards;
    }

    /**
     * @return PaymentOptionNetBanking
     */
    public function getNetBanking(): PaymentOptionNetBanking
    {
        return $this->netBanking;
    }

    /**
     * @param PaymentOptionNetBanking $netBanking
     */
    public function setNetBanking(PaymentOptionNetBanking $netBanking)
    {
        $this->netBanking = $netBanking;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
