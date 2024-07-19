<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1;

use FriendsOfBotble\PhonePe\PhonePe\common\config\MerchantConfig;
use FriendsOfBotble\PhonePe\PhonePe\common\exceptions\PhonePeException;
use FriendsOfBotble\PhonePe\PhonePe\common\TransactionClient;
use FriendsOfBotble\PhonePe\PhonePe\common\utils\Request;
use FriendsOfBotble\PhonePe\PhonePe\common\utils\RequestGenerator;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgPayRequest;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgRefundRequest;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\request\PgValidateVpaRequest;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgCheckStatusResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgPaymentsOptionsResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgPayResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgRefundResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\models\response\PgValidateVpaResponse;
use FriendsOfBotble\PhonePe\PhonePe\payments\v1\utils\ObjectMapper;

class PaymentTransactionClient extends TransactionClient
{
    /**
     * @param MerchantConfig $merchantConfig
     * @param $hostUrl
     */
    public function __construct(MerchantConfig $merchantConfig, $hostUrl)
    {
        parent::__construct($merchantConfig, $hostUrl);
    }

    /**
     * @throws PhonePeException
     */
    public function pay(PgPayRequest $pgPayRequest): PgPayResponse
    {
        $payload = json_encode($pgPayRequest);
        $base64EncodedPayload = base64_encode($payload);
        $path = PaymentConstants::PAY_API;

        $request = Request::buildPostRequest(
            $base64EncodedPayload,
            $path,
            $this->getHostUrl(),
            $this->getMerchantConfig()->getMerchantId(),
            $this->getMerchantConfig()->getSaltKey(),
            $this->getMerchantConfig()->getSaltIndex(),
            $this->getHeaders()
        );

        $httpResponseObj = RequestGenerator::postRequest($request->getUrl(), $request->getPayload(), $request->getHeaders());
        $httpResponse = json_decode($httpResponseObj->getResponse());
        if($httpResponse->success) {
            $response = ObjectMapper::mapResponse($httpResponse, PaymentConstants::PAY_API);

            return $response->getData();
        } else {
            throw new PhonePeException('ResponseCode: ' . $httpResponse->code . ' Message: ' . $httpResponse->message);
        }
    }

    /**
     * @throws PhonePeException
     */
    public function refund(PgRefundRequest $pgRefundRequest): PgRefundResponse
    {
        $payload = json_encode($pgRefundRequest);
        $base64EncodedPayload = base64_encode($payload);
        $path = PaymentConstants::REFUND_API;

        $request = Request::buildPostRequest(
            $base64EncodedPayload,
            $path,
            $this->getHostUrl(),
            $this->getMerchantConfig()->getMerchantId(),
            $this->getMerchantConfig()->getSaltKey(),
            $this->getMerchantConfig()->getSaltIndex(),
            $this->getHeaders()
        );

        $httpResponseObj = RequestGenerator::postRequest($request->getUrl(), $request->getPayload(), $request->getHeaders());
        $httpResponse = json_decode($httpResponseObj->getResponse());
        if($httpResponse->success) {
            $response = ObjectMapper::mapResponse($httpResponse, PaymentConstants::REFUND_API);

            return $response->getData();
        } else {
            throw new PhonePeException('ResponseCode: ' . $httpResponse->code . ' Message: ' . $httpResponse->message);
        }
    }

    /**
     * @throws PhonePeException
     */
    public function checkStatus(string $merchantTransactionId): PgCheckStatusResponse
    {
        $path = sprintf(PaymentConstants::STATUS_API, $this->getMerchantConfig()->getMerchantId(), $merchantTransactionId);
        $request = Request::buildGetRequest(
            $path,
            $this->getHostUrl(),
            $this->getMerchantConfig()->getMerchantId(),
            $this->getMerchantConfig()->getSaltKey(),
            $this->getMerchantConfig()->getSaltIndex(),
            $this->getHeaders()
        );
        $httpResponseObj = RequestGenerator::getRequest($request->getUrl(), $request->getHeaders());
        $httpResponse = json_decode($httpResponseObj->getResponse());

        $code = $httpResponse->code;

        if(strcmp($code, 'TRANSACTION_NOT_FOUND') == 0) {
            throw new PhonePeException('Transaction NotFound');
        }

        $response = ObjectMapper::mapResponse($httpResponse, PaymentConstants::STATUS_API);

        return $response->getData();
    }

    /**
     * @param string $vpa
     * @return PgValidateVpaResponse
     * @throws PhonePeException
     */
    public function validateVpa(string $vpa): PgValidateVpaResponse
    {
        $pgValidateVpaRequest = new PgValidateVpaRequest($this->getMerchantConfig()->getMerchantId(), $vpa);

        $payload = json_encode($pgValidateVpaRequest);
        $base64EncodedPayload = base64_encode($payload);
        $path = PaymentConstants::VALIDATE_VPA_API;

        $request = Request::buildPostRequest(
            $base64EncodedPayload,
            $path,
            $this->getHostUrl(),
            $this->getMerchantConfig()->getMerchantId(),
            $this->getMerchantConfig()->getSaltKey(),
            $this->getMerchantConfig()->getSaltIndex(),
            $this->getHeaders()
        );

        $httpResponseObj = RequestGenerator::postRequest($request->getUrl(), $request->getPayload(), $request->getHeaders());
        $httpResponse = json_decode($httpResponseObj->getResponse());
        if($httpResponse->success) {
            $response = ObjectMapper::mapResponse($httpResponse, PaymentConstants::VALIDATE_VPA_API);

            return $response->getData();
        } else {
            throw new PhonePeException('ResponseCode: ' . $httpResponse->code . ' Message: ' . $httpResponse->message);
        }
    }

    public function paymentOptions($includeNetBankingBanksList): PgPaymentsOptionsResponse
    {
        $path = sprintf(PaymentConstants::PAYMENT_OPTIONS_API, $this->getMerchantConfig()->getMerchantId());
        $request = Request::buildGetRequest(
            $path,
            $this->getHostUrl(),
            $this->getMerchantConfig()->getMerchantId(),
            $this->getMerchantConfig()->getSaltKey(),
            $this->getMerchantConfig()->getSaltIndex(),
            $this->getHeaders()
        );
        $pathForCheckSum = $request->getUrl();
        if($includeNetBankingBanksList) {
            $pathForCheckSum = $pathForCheckSum . '?' . PaymentConstants::NETBANKING_INCLUDE_LIST . '=true';
        }

        $httpResponseObj = RequestGenerator::getRequest($pathForCheckSum, $request->getHeaders());
        $httpResponse = json_decode($httpResponseObj->getResponse());
        $response = ObjectMapper::mapResponse($httpResponse, PaymentConstants::PAYMENT_OPTIONS_API);

        return $response->getData();
    }

}
