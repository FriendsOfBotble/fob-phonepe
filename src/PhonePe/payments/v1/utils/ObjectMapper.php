<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1\utils;

use FriendsOfBotble\PhonePe\PhonePe\common\utils\Response;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\constants\PaymentInstrumentConstants;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\CardPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\NetbankingPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\PayPagePaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\RedirectInfo;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\SavedCardPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\TokenPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\UpiCollectPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\UpiIntentPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentInstrument\UpiQrPaymentInstrument;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PaymentOptionNetBanking;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgExternalCards;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgIntent;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgPaymentsOptionsResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgPayResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgRefundResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgUpiCollect;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgValidateVpaResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\PaymentConstants;

class ObjectMapper
{
    /**
     * @param object $response
     * @return PgPayResponse
     */
    public static function pgPayResponseMapper($response): PgPayResponse
    {
        $instrumentResponse = null;

        switch ($response->instrumentResponse->type) {
            case PaymentInstrumentConstants::PAY_PAGE:
                $instrumentResponse = self::payPageInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::UPI_INTENT:
                $instrumentResponse = self::upiIntentInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::UPI_QR:
                $instrumentResponse = self::upiQrInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::NET_BANKING:
                $instrumentResponse = self::NetbankingInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::CARD:
                $instrumentResponse = self::CardInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::SAVED_CARD:
                $instrumentResponse = self::SavedCardInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::TOKEN:
                $instrumentResponse = self::TokenInstrumentResponseMapper($response->instrumentResponse);

                break;
            case PaymentInstrumentConstants::UPI_COLLECT:
                $instrumentResponse = new UpiCollectPaymentInstrument();

                break;
            default:
                $instrumentResponse = new PaymentInstrument($response->instrumentResponse->type);
        }

        return new PgPayResponse(
            $response->merchantId,
            $response->merchantTransactionId,
            $instrumentResponse
        );
    }

    public static function pgRefundResponseMapper($response): PgRefundResponse
    {
        return new PgRefundResponse(
            $response->merchantId,
            $response->merchantTransactionId,
            $response->transactionId,
            $response->amount,
            $response->state,
            $response->responseCode
        );
    }

    public static function payPageInstrumentResponseMapper($instrumentResponse): PayPagePaymentInstrument
    {
        $redirectInfo = new RedirectInfo(
            $instrumentResponse->redirectInfo->url,
            $instrumentResponse->redirectInfo->method
        );

        return new PayPagePaymentInstrument($redirectInfo);
    }

    private static function upiIntentInstrumentResponseMapper($instrumentResponse): UpiIntentPaymentInstrument
    {
        return new UpiIntentPaymentInstrument($instrumentResponse->intentUrl);
    }

    private static function upiQrInstrumentResponseMapper($instrumentResponse): UpiQrPaymentInstrument
    {
        return new UpiQrPaymentInstrument($instrumentResponse->intentUrl, $instrumentResponse->qrData);
    }

    private static function NetbankingInstrumentResponseMapper($instrumentResponse): NetbankingPaymentInstrument
    {
        $redirectInfo = new RedirectInfo(
            $instrumentResponse->redirectInfo->url,
            $instrumentResponse->redirectInfo->method
        );

        return new NetbankingPaymentInstrument($redirectInfo);
    }

    private static function CardInstrumentResponseMapper($instrumentResponse): CardPaymentInstrument
    {
        $redirectInfo = new RedirectInfo(
            $instrumentResponse->redirectInfo->url,
            $instrumentResponse->redirectInfo->method
        );

        return new CardPaymentInstrument($redirectInfo);
    }

    private static function SavedCardInstrumentResponseMapper($instrumentResponse): SavedCardPaymentInstrument
    {
        $redirectInfo = new RedirectInfo(
            $instrumentResponse->redirectInfo->url,
            $instrumentResponse->redirectInfo->method
        );

        return new SavedCardPaymentInstrument($redirectInfo);
    }

    private static function TokenInstrumentResponseMapper($instrumentResponse): TokenPaymentInstrument
    {
        $redirectInfo = new RedirectInfo(
            $instrumentResponse->redirectInfo->url,
            $instrumentResponse->redirectInfo->method
        );

        return new TokenPaymentInstrument($redirectInfo);
    }

    private static function pgPaymentOptionsResponseMapper($data): PgPaymentsOptionsResponse
    {
        $upiCollect = new PgUpiCollect(
            isset($data->upiCollect->enabled),
            (isset($data->upiCollect->apps)) ? $data->upiCollect->apps : null
        );
        $intent = new PgIntent(
            isset($data->intent->enabled),
            (isset($data->intent->apps)) ? $data->intent->apps : null
        );
        $card = new PgExternalCards(isset($data->card->enabled));
        $netBanking = new PaymentOptionNetBanking(
            $data->netBanking->enabled,
            (isset($data->netBanking->popularBanks)) ? $data->netBanking->popularBanks : null,
            (isset($data->netBanking->topBanks)) ? $data->netBanking->topBanks : null,
            (isset($data->netBanking->allBanks)) ? $data->netBanking->allBanks : null,
            (isset($data->netBanking->ttl)) ? $data->netBanking->ttl : null
        );

        return new PgPaymentsOptionsResponse(
            $upiCollect,
            $intent,
            $card,
            $netBanking
        );
    }

    private static function pgValidateVpaResponseMapper($data): PgValidateVpaResponse
    {
        return new PgValidateVpaResponse(
            $data->name,
            $data->vpa
        );
    }

    public static function mapResponse($response, $path): Response
    {
        $data = null;
        if($path == PaymentConstants::PAY_API) {
            $data = self::pgPayResponseMapper($response->data);
        }
        if($path == PaymentConstants::REFUND_API) {
            $data = self::pgRefundResponseMapper($response->data);
        }
        if($path == PaymentConstants::STATUS_API) {
            $data = CheckStatusMapper::pgCheckStatusResponseMapper($response->data);
        }
        if($path == PaymentConstants::VALIDATE_VPA_API) {
            $data = self::pgValidateVpaResponseMapper($response->data);
        }
        if($path == PaymentConstants::PAYMENT_OPTIONS_API) {
            $data = self::pgPaymentOptionsResponseMapper($response->data);
        }

        return new Response(
            $response->success,
            $response->code,
            $response->message,
            $data
        );
    }

}
