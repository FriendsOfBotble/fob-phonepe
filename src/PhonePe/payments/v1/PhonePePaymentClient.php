<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1;

use Exception;
use FriendsOfBotble\PhonePe\PhonePe\common\config\ConfigBuilder;
use FriendsOfBotble\PhonePe\PhonePe\common\events\EventPublisher;
use FriendsOfBotble\PhonePe\PhonePe\common\exceptions\PhonePeException;
use FriendsOfBotble\PhonePe\PhonePe\common\models\constants\EventState;
use FriendsOfBotble\PhonePe\PhonePe\common\models\events\SdkEvent;
use FriendsOfBotble\PhonePe\PhonePe\common\PhonePeClient;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgPayRequest;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgRefundRequest;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgCheckStatusResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgPaymentsOptionsResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgPayResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgRefundResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgValidateVpaResponse;

class PhonePePaymentClient extends PhonePeClient
{
    /**
     * @var PaymentTransactionClient
     */
    private $paymentTransactionClient;
    private $eventPublisher;
    private $shouldPublishEvents;

    /**
     * Constructs a new instance of the PhonePe client.
     * @param $merchantId /Unique merchant ID provided by PhonePe.
     * @param $saltKey /Salt key for secure communication with PhonePe.
     * @param $saltIndex /Salt index for secure communication with PhonePe.
     * @param $env /Environment for the PhonePeClient: `Env.PROD` (production), `Env.UAT` (testing).
     */
    public function __construct(
        $merchantId,
        $saltKey,
        $saltIndex,
        $env,
        $shouldPublishEvents = false
    ) {
        parent::__construct($merchantId, $saltKey, $saltIndex, $env);
        $this->paymentTransactionClient = new PaymentTransactionClient($this->getPhonePeSdkConfig()->getMerchantConfig(), $this->getHostUrl());
        $this->eventPublisher = new EventPublisher(
            ConfigBuilder::getEventUrl($env),
            $this->getPhonePeSdkConfig()->getMerchantConfig(),
            $shouldPublishEvents,
            $this->paymentTransactionClient->getHeaders()
        );
        if($shouldPublishEvents) {
            $this->eventPublisher->sendEvent(SdkEvent::buildClientInitEvent(EventState::INIT, $merchantId));
        }
        $this->shouldPublishEvents = $shouldPublishEvents;
    }

    /**
     * @return PaymentTransactionClient
     */
    private function getPaymentTransactionClient(): PaymentTransactionClient
    {
        return $this->paymentTransactionClient;
    }

    /**
     * @param PaymentTransactionClient $paymentTransactionClient
     */
    private function setPaymentTransactionClient(PaymentTransactionClient $paymentTransactionClient)
    {
        $this->paymentTransactionClient = $paymentTransactionClient;
    }

    /**
     * @return EventPublisher
     */
    private function getEventPublisher(): EventPublisher
    {
        return $this->eventPublisher;
    }

    /**
     * @param EventPublisher $eventPublisher
     */
    private function setEventPublisher(EventPublisher $eventPublisher)
    {
        $this->eventPublisher = $eventPublisher;
    }

    /**
     * @return false|mixed
     */
    private function getShouldPublishEvents()
    {
        return $this->shouldPublishEvents;
    }

    /**
     * @param false|mixed $shouldPublishEvents
     */
    private function setShouldPublishEvents($shouldPublishEvents)
    {
        $this->shouldPublishEvents = $shouldPublishEvents;
    }

    /**
     * @desc This method help to initiate transaction at PhonePe PG.
     * @param PgPayRequest $pgPayRequest
     * @return PgPayResponse
     * @throws PhonePeException
     */
    public function pay(PgPayRequest $pgPayRequest): PgPayResponse
    {
        $this->eventPublisher->sendEvent(
            SdkEvent::buildPayEvent(EventState::INIT, $pgPayRequest)
        );
        $pgPayResponse = null;

        try {
            $pgPayResponse = $this->paymentTransactionClient->pay($pgPayRequest);
            $this->eventPublisher->sendEvent(
                SdkEvent::buildPayEvent(EventState::S2S_CALL_SUCCESS, $pgPayRequest)
            );
        } catch (Exception $e) {
            $this->eventPublisher->sendEvent(
                SdkEvent::buildPayEvent(EventState::S2S_CALL_FAILED, $pgPayRequest, $e->getMessage())
            );

            throw $e;
        }

        return $pgPayResponse;
    }

    /**
     * @desc This method help to initiate a refund of a transaction Done using PhonePe PG.
     * @param PgRefundRequest $pgRefundRequest
     * @return PgRefundResponse
     * @throws PhonePeException
     */
    public function refund(PgRefundRequest $pgRefundRequest): PgRefundResponse
    {
        $this->eventPublisher->sendEvent(
            SdkEvent::buildRefundEvent(EventState::INIT, $pgRefundRequest)
        );
        $pgRefundResponse = null;

        try {
            $pgRefundResponse = $this->paymentTransactionClient->refund($pgRefundRequest);
            $this->eventPublisher->sendEvent(
                SdkEvent::buildRefundEvent(EventState::S2S_CALL_SUCCESS, $pgRefundRequest)
            );
        } catch (Exception $e) {
            $this->eventPublisher->sendEvent(
                SdkEvent::buildRefundEvent(EventState::S2S_CALL_FAILED, $pgRefundRequest, $e->getMessage())
            );

            throw $e;
        }

        return $pgRefundResponse;
    }

    /**
     * @desc This method help to check status of a transaction Done using PhonePe PG.
     * @param string $merchantTransactionId
     * @return PgCheckStatusResponse
     * @throws Exception
     */
    public function statusCheck(string $merchantTransactionId): PgCheckStatusResponse
    {
        $pgCheckStatusResponse = null;
        $this->eventPublisher->sendEvent(
            SdkEvent::buildStatusCheckEvent(EventState::INIT, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId(), $merchantTransactionId)
        );

        try {
            $pgCheckStatusResponse = $this->paymentTransactionClient->checkStatus($merchantTransactionId);
            $this->eventPublisher->sendEvent(
                SdkEvent::buildStatusCheckEvent(EventState::S2S_CALL_SUCCESS, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId(), $merchantTransactionId)
            );
        } catch (Exception $e) {
            $this->eventPublisher->sendEvent(
                SdkEvent::buildStatusCheckEvent(EventState::S2S_CALL_FAILED, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId(), $merchantTransactionId, $e->getMessage())
            );

            throw $e;
        }

        return $pgCheckStatusResponse;
    }

    /**
     * @throws PhonePeException
     */
    public function validateVpa(string $vpa): PgValidateVpaResponse
    {
        $pgValidateVpaResponse = null;
        $this->eventPublisher->sendEvent(
            SdkEvent::buildValidateVpaEvent(EventState::INIT, $vpa, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId())
        );

        try {
            $pgValidateVpaResponse = $this->paymentTransactionClient->validateVpa($vpa);
            $this->eventPublisher->sendEvent(
                SdkEvent::buildValidateVpaEvent(EventState::S2S_CALL_SUCCESS, $vpa, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId())
            );
        } catch (Exception $e) {
            $this->eventPublisher->sendEvent(
                SdkEvent::buildValidateVpaEvent(EventState::S2S_CALL_FAILED, $vpa, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId(), $e->getMessage())
            );

            throw $e;
        }

        return $pgValidateVpaResponse;
    }

    /**
    * @throws PhonePeException|Exception
     */
    public function paymentOptions($includeNetBankingBanksList): PgPaymentsOptionsResponse
    {
        $pgPaymentOptionsResponse = null;
        $this->eventPublisher->sendEvent(
            SdkEvent::buildPaymentOptionsEvent(EventState::INIT, $includeNetBankingBanksList, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId())
        );

        try {
            $pgPaymentOptionsResponse = $this->paymentTransactionClient->paymentOptions($includeNetBankingBanksList);
            $this->eventPublisher->sendEvent(
                SdkEvent::buildPaymentOptionsEvent(EventState::S2S_CALL_SUCCESS, $includeNetBankingBanksList, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId())
            );
        } catch (Exception $e) {
            $this->eventPublisher->sendEvent(
                SdkEvent::buildPaymentOptionsEvent(EventState::S2S_CALL_FAILED, $includeNetBankingBanksList, $this->paymentTransactionClient->getMerchantConfig()->getMerchantId(), $e->getMessage())
            );

            throw $e;
        }

        return $pgPaymentOptionsResponse;
    }

}
