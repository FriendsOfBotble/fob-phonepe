<?php

namespace FriendsOfBotble\PhonePe;

use Botble\Payment\Supports\PaymentHelper;
use Exception;
use FriendsOfBotble\PhonePe\Facades\PhonePePayment;
use FriendsOfBotble\PhonePe\PhonePe\common\exceptions\PhonePeException;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\builders\PgRefundRequestBuilder;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgRefundResponse;
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
            ->callbackUrl(route('payment.phonepe.status'))
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

    public function getStatus(string $transactionId): ?PhonePe\payments\v1\models\response\PgCheckStatusResponse
    {
        $request = [
            'transaction_id' => $transactionId,
        ];

        try {
            $response = $this->paymentClient->statusCheck($transactionId);

            PaymentHelper::log(PhonePePayment::getId(), $request, $response->jsonSerialize());

            return $response;
        } catch (Exception $e) {
            PaymentHelper::log(PhonePePayment::getId(), $request, [
                'body' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function refund(string $transactionId, string $merchantTransactionId, float $amount): PgRefundResponse|string
    {
        $request = PgRefundRequestBuilder::builder()
            ->originalTransactionId($transactionId)
            ->merchantId(get_payment_setting('merchant_id', PhonePePayment::getId()))
            ->merchantTransactionId($merchantTransactionId)
            ->amount($amount)
            ->build();

        try {
            $response = $this->paymentClient->refund($request);

            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), $response->jsonSerialize());

            return $response;
        } catch (Exception $e) {
            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), [
                'body' => $e->getMessage(),
            ]);

            return $e->getMessage();
        }
    }
}
