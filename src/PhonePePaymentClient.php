<?php

namespace FriendsOfBotble\PhonePe;

use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Supports\PaymentHelper;
use FriendsOfBotble\PhonePe\Facades\PhonePePayment;
use FriendsOfBotble\PhonePe\PhonePe\common\exceptions\PhonePeException;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\PhonePePaymentClient as BasePhonePePaymentClient;

class PhonePePaymentClient
{
    public function __construct(
        protected BasePhonePePaymentClient $paymentClient
    ) {
    }

    public function pay(array $data, string $transactionId): ?string
    {
        $request = PgPayRequestBuilder::builder()
            ->mobileNumber($data['address']['phone'])
            ->callbackUrl('https://webhook.in/test/status')
            ->merchantId(get_payment_setting('merchant_id', PhonePePayment::getId()))
            ->merchantUserId($data['customer_id'])
            ->amount($data['amount'] * 100)
            ->merchantTransactionId($transactionId)
            ->redirectUrl(route('payment.phonepe.callback', ['trans_id' => $transactionId]))
            ->redirectMode('REDIRECT')
            ->paymentInstrument(InstrumentBuilder::buildPayPageInstrument())
            ->build();

        try {
            $response = $this->paymentClient->pay($request);

            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), $response->jsonSerialize());

            return $response->getInstrumentResponse()->getRedirectInfo()->getUrl();
        } catch (PhonePeException $e) {
            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), [
                'body' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function getStatus(string $transactionId): ?string
    {
        $request = [
            'transaction_id' => $transactionId,
        ];

        try {
            $response = $this->paymentClient->statusCheck($transactionId);

            PaymentHelper::log(PhonePePayment::getId(), $request, $response->jsonSerialize());

            return match ($response->getState()) {
                'SUCCESS' => PaymentStatusEnum::COMPLETED,
                'PENDING' => PaymentStatusEnum::PENDING,
                default => PaymentStatusEnum::FAILED,
            };
        } catch (PhonePeException $e) {
            PaymentHelper::log(PhonePePayment::getId(), $request, [
                'body' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
