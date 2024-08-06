<?php

namespace FriendsOfBotble\PhonePe;

use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment;
use FriendsOfBotble\PhonePe\Contracts\PhonePePayment as PhonePePaymentContract;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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

    public function isSupportRefundOnline(): bool
    {
        return true;
    }

    public function getSupportRefundOnline(): bool
    {
        return $this->isSupportRefundOnline();
    }

    public function supportedCurrencies(): array
    {
        return [
            'INR',
        ];
    }

    public function generateTransactionId(): string
    {
        return Str::uuid();
    }

    public function authorize(array $data, Request $request): array
    {
        if (! $this->isConfigured()) {
            return [
                'error' => true,
                'message' => trans('plugins/payment::payment.invalid_settings', ['name' => $this->getDisplayName()]),
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

    public function refund(string $transactionId, float $amount, array $data = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'error' => true,
                'message' => trans('plugins/payment::payment.invalid_settings', ['name' => $this->getDisplayName()]),
            ];
        }

        $payment = Payment::query()
            ->where('charge_id', $transactionId)
            ->first();

        if ((float) $payment->amount !== $amount) {
            return [
                'error' => true,
                'message' => trans('plugins/fob-phonepe::phonepe.refund.partial_refund_not_supported'),
            ];
        }

        if (! Arr::has($payment->metadata, 'transactionId')) {
            return [
                'error' => true,
                'message' => trans('plugins/fob-phonepe::phonepe.refund.transaction_id_not_found'),
            ];
        }

        $response = app(PhonePePaymentClient::class)->refund(
            $payment->metadata['transactionId'],
            $transactionId,
            $payment->metadata['amount'],
        );

        if (is_string($response)) {
            return [
                'error' => true,
                'message' => $response,
            ];
        }

        if ($response->getState() === 'COMPLETED') {
            return [
                'error' => false,
                'message' => trans('plugins/phonepe::phonepe.refund.completed'),
                'data' => $response->jsonSerialize(),
            ];
        }

        if ($response->getState() === 'PENDING') {
            return [
                'error' => false,
                'message' => trans('plugins/phonepe::phonepe.refund.pending'),
                'data' => $response->jsonSerialize(),
            ];
        }

        return [
            'error' => true,
            'message' => trans('plugins/phonepe::phonepe.refund.failed'),
            'data' => $response->jsonSerialize(),
        ];
    }

    /**
     * @deprecated Use refund() instead.
     */
    public function refundOrder(string $paymentId, float|string $totalAmount, array $options = []): array
    {
        return $this->refund($paymentId, $totalAmount, $options);
    }
}
