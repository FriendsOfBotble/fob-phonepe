<?php

namespace FriendsOfBotble\PhonePe\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment;
use Botble\Payment\Supports\PaymentHelper;
use Exception;
use FriendsOfBotble\PhonePe\PhonePePaymentClient;
use Illuminate\Http\Request;

class PhonePeController extends BaseController
{
    public function callback(Request $request, PhonePePaymentClient $client)
    {
        $request->validate([
            'trans_id' => ['required', 'string', 'exists:payments,charge_id'],
        ]);

        $response = $client->getStatus($request->input('trans_id'));

        $status = match ($response->getState()) {
            'COMPLETED' => PaymentStatusEnum::COMPLETED,
            'SUCCESS' => PaymentStatusEnum::COMPLETED,
            'PENDING' => PaymentStatusEnum::PENDING,
            default => PaymentStatusEnum::FAILED,
        };

        if (! $status) {
            return $this
                ->httpResponse()
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }

        $payment = Payment::query()
            ->where('charge_id', $request->input('trans_id'))
            ->where('status', PaymentStatusEnum::PENDING)
            ->firstOrFail();

        $payment->update([
            'status' => $status,
            'metadata' => $response->jsonSerialize(),
        ]);

        if ($status !== PaymentStatusEnum::COMPLETED) {
            return $this
                ->httpResponse()
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }

        return $this
            ->httpResponse()
            ->setNextUrl(PaymentHelper::getRedirectURL())
            ->setMessage(__('Payment successfully!'));
    }

    public function status(Request $request)
    {
        $request->validate([
            'response' => ['required', 'string'],
        ]);

        try {
            $data = base64_decode(json_decode($request->input('response')))['data'];

            $status = match ($data['state']) {
                'COMPLETED' => PaymentStatusEnum::COMPLETED,
                'PENDING' => PaymentStatusEnum::PENDING,
                default => PaymentStatusEnum::FAILED,
            };

            $payment = Payment::query()
                ->where('charge_id', $data['transactionId'])
                ->where('status', PaymentStatusEnum::PENDING)
                ->firstOrFail();

            $payment->update([
                'status' => $status,
                'metadata' => $data,
            ]);

            return response()->noContent();
        } catch (Exception) {
            abort(400);
        }
    }
}
