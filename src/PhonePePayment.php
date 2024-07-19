<?php

namespace FriendsOfBotble\PhonePe;

use Illuminate\Http\Request;

class PhonePePayment
{
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

    public function authorize(array $data, Request $request): array
    {
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

        $data = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

        $pay = app(PhonePePaymentClient::class)->pay();
    }
}
