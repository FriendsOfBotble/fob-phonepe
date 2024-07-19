<?php

namespace FriendsOfBotble\PhonePe;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\PhonePePaymentClient as BasePhonePePaymentClient;

class PhonePePaymentClient
{
    public function __construct(
        protected BasePhonePePaymentClient $paymentClient
    ) {
    }

    public function pay(): string
    {
        $merchantTransactionId = 'PHPSDK' . date('ymdHis') . 'payPageTest';

        $request = PgPayRequestBuilder::builder()
            ->mobileNumber('9999999999')
            ->callbackUrl('https://webhook.in/test/status')
            ->merchantId('')
            ->merchantUserId('<merchantUserId>')
            ->amount('')
            ->merchantTransactionId($merchantTransactionId)
            ->redirectUrl('https://webhook.in/test/redirect')
            ->redirectMode('REDIRECT')
            ->paymentInstrument(InstrumentBuilder::buildPayPageInstrument())
            ->build();

        $response = $this->paymentClient->pay($request);

        return $response->getInstrumentResponse()->getRedirectInfo()->getUrl();
    }
}
