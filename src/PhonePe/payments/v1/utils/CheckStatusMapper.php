<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\utils;

use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\CheckStatusCardInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\CheckStatusNetbankingInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\CheckStatusPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\CheckStatusPaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\CheckStatusUpiInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgCheckStatusResponse;

class CheckStatusMapper
{
    public static function pgCheckStatusResponseMapper($response): PgCheckStatusResponse
    {
        if(isset($response->paymentInstrument->type)) {
            switch ($response->paymentInstrument->type) {
                case CheckStatusPaymentInstrumentConstants::UPI:
                    $instrumentResponse = self::upiInstrumentResponseMapper($response->paymentInstrument);

                    break;
                case CheckStatusPaymentInstrumentConstants::CARD:
                    $instrumentResponse = self::cardInstrumentResponseMapper($response->paymentInstrument);

                    break;
                case CheckStatusPaymentInstrumentConstants::NETBANKING:
                    $instrumentResponse = self::netbankingInstrumentResponseMapper($response->paymentInstrument);

                    break;
                default:
                    $instrumentResponse = new CheckStatusPaymentInstrument($response->paymentInstrument->type);
            }
        } else {
            $instrumentResponse = null;
        }

        return new PgCheckStatusResponse(
            $response->merchantId,
            $response->merchantTransactionId,
            $response->transactionId,
            $response->amount,
            ($response->state ?? $response->paymentState),
            $response->responseCode,
            $instrumentResponse
        );
    }

    private static function upiInstrumentResponseMapper($instrumentResponse): CheckStatusUpiInstrument
    {
        return new CheckStatusUpiInstrument($instrumentResponse->utr);
    }

    private static function cardInstrumentResponseMapper($instrumentResponse): CheckStatusCardInstrument
    {
        return new CheckStatusCardInstrument(
            $instrumentResponse->cardType,
            $instrumentResponse->pgTransactionId,
            $instrumentResponse->bankTransactionId,
            $instrumentResponse->pgAuthorizationCode,
            $instrumentResponse->arn,
            $instrumentResponse->bankId
        );
    }

    private static function netbankingInstrumentResponseMapper($instrumentResponse): CheckStatusNetbankingInstrument
    {
        return new CheckStatusNetbankingInstrument(
            $instrumentResponse->pgTransactionId,
            $instrumentResponse->pgServiceTransactionId,
            $instrumentResponse->bankTransactionId,
            $instrumentResponse->bankId
        );
    }

}
