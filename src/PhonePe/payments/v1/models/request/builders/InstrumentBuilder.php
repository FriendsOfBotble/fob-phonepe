<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\PayPagePaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\paymentInstrument\UpiQrPaymentInstrument;

class InstrumentBuilder
{
    public static function buildPayPageInstrument(): PayPagePaymentInstrument
    {
        return new PayPagePaymentInstrument();
    }

    public static function buildUpiQrInstrument(): UpiQrPaymentInstrument
    {
        return new UpiQrPaymentInstrument();
    }

    public static function getUpiIntentInstrumentBuilder(): UpiIntentInstrumentBuilder
    {
        return new UpiIntentInstrumentBuilder();
    }

    public static function getUpiCollectInstrumentBuilder(): UpiCollectInstrumentBuilder
    {
        return new UpiCollectInstrumentBuilder();
    }

    public static function getNetbankingInstrumentBuilder(): NetbankingInstrumentBuilder
    {
        return new NetbankingInstrumentBuilder();
    }

    public static function getNewCardInstrumentBuilder(): NewCardInstrumentBuilder
    {
        return new NewCardInstrumentBuilder();
    }

    public static function getSavedCardInstrumentBuilder(): SavedCardInstrumentBuilder
    {
        return new SavedCardInstrumentBuilder();
    }

    public static function getTokenInstrumentBuilder(): TokenInstrumentBuilder
    {
        return new TokenInstrumentBuilder();
    }

}
