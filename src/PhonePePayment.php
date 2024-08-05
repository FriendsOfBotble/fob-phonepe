<?php

namespace FriendsOfBotble\PhonePe;

use Botble\Payment\Enums\PaymentStatusEnum;
use FriendsOfBotble\PhonePe\Contracts\PhonePePayment as PhonePePaymentContract;
use Illuminate\Http\Request;

class PhonePePayment implements PhonePePaymentContract
{
    public function isConfigured(): bool
    {
        return get_payment_setting('merchant_id', PhonePePayment::getId())
            && get_payment_setting('salt_key', PhonePePayment::getId())
            && get_payment_setting('salt_index', PhonePePayment::getId())
            && get_payment_setting('environment', PhonePePayment::getId(), 'UAT');
    }

    public function getId(): string
    {
        return 'phonepe';
    }

    public function getDisplayName(): string
    {
        return 'PhonePe';
    }

    public function supportedCurrencies(): array
    {
        return [
            'INR',
        ];
    }

    public function generateTransactionId(): string
    {
        return 'PHPSDK' . date('ymdHis') . 'payPageTest';
    }

    public function authorize(array $data, Request $request): array
    {
        if (! $this->isConfigured()) {
            return [
                'error' => true,
                'message' => __('Please setup PhonePe payment method before using it.'),
            ];
        }

        if (! in_array($data['currency'], $this->supportedCurrencies())) {
            return [
                'error' => true,
                'message' => __(
                    ":name doesn't support :currency. List of currencies supported by :name: :currencies.",
                    [
                        'name' => $this->getDisplayName(),
                        'currency' => $data['currency'],
                        'currencies' => implode(', ', $this->supportedCurrencies()),
                    ]
                ),
            ];
        }

        $transactionId = $this->generateTransactionId();
        $url = app(PhonePePaymentClient::class)->pay($data, $transactionId);

        if (! $url) {
            return [
                'error' => true,
                'message' => __('Failed to create payment request.'),
            ];
        }

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, [
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'charge_id' => $transactionId,
            'payment_channel' => $this->getId(),
            'status' => PaymentStatusEnum::PENDING,
            'customer_id' => $data['customer_id'],
            'customer_type' => $data['customer_type'],
            'payment_type' => 'direct',
            'order_id' => $data['order_id'],
        ], $request);

        exit(header('Location: ' . $url));
    }
}
