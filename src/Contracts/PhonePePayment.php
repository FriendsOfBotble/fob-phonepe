<?php

namespace FriendsOfBotble\PhonePe\Contracts;

use Illuminate\Http\Request;

interface PhonePePayment
{
    public function isConfigured(): bool;

    public function getId(): string;

    public function getDisplayName(): string;

    public function supportedCurrencies(): array;

    public function isSupportRefundOnline(): bool;

    public function authorize(array $data, Request $request): array;

    public function refund(string $transactionId, float $amount, array $data = []): array;
}
