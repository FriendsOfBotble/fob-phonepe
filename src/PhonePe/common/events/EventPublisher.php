<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\events;

use FriendsOfBotble\PhonePe\PhonePe\common\config\Constants;
use FriendsOfBotble\PhonePe\PhonePe\common\config\MerchantConfig;
use FriendsOfBotble\PhonePe\PhonePe\common\utils\Request;
use FriendsOfBotble\PhonePe\PhonePe\common\utils\RequestGenerator;

class EventPublisher
{
    private $hostUrl;
    /**
     * @var MerchantConfig
     */
    private $merchantConfig;
    private $shouldPublishEvents;
    private $additionalHeaders;

    /**
     * @param $hostUrl
     * @param MerchantConfig $merchantConfig
     */
    public function __construct($hostUrl, MerchantConfig $merchantConfig, $shouldPublishEvents, $additionalHeaders)
    {
        $this->hostUrl = $hostUrl;
        $this->merchantConfig = $merchantConfig;
        $this->shouldPublishEvents = $shouldPublishEvents;
        $this->additionalHeaders = $additionalHeaders;
    }

    /**
     * @return mixed
     */
    public function getHostUrl()
    {
        return $this->hostUrl;
    }

    /**
     * @param mixed $hostUrl
     */
    public function setHostUrl($hostUrl)
    {
        $this->hostUrl = $hostUrl;
    }

    /**
     * @return MerchantConfig
     */
    public function getMerchantConfig(): MerchantConfig
    {
        return $this->merchantConfig;
    }

    /**
     * @param MerchantConfig $merchantConfig
     */
    public function setMerchantConfig(MerchantConfig $merchantConfig)
    {
        $this->merchantConfig = $merchantConfig;
    }

    /**
     * @return mixed
     */
    public function getShouldPublishEvents()
    {
        return $this->shouldPublishEvents;
    }

    /**
     * @param mixed $shouldPublishEvents
     */
    public function setShouldPublishEvents($shouldPublishEvents)
    {
        $this->shouldPublishEvents = $shouldPublishEvents;
    }

    /**
     * @return mixed
     */
    public function getAdditionalHeaders()
    {
        return $this->additionalHeaders;
    }

    /**
     * @param mixed $additionalHeaders
     */
    public function setAdditionalHeaders($additionalHeaders)
    {
        $this->additionalHeaders = $additionalHeaders;
    }

    public function sendEvent($event)
    {
        if(! $this->shouldPublishEvents) {
            return;
        }

        $base64EncodedPayload = base64_encode(json_encode($event));
        $request = Request::buildPostRequest(
            $base64EncodedPayload,
            Constants::EVENT_ENDPOINT,
            $this->hostUrl,
            $this->merchantConfig->getMerchantId(),
            $this->merchantConfig->getSaltKey(),
            $this->merchantConfig->getSaltIndex(),
            $this->getAdditionalHeaders()
        );

        try {
            RequestGenerator::postRequest($request->getUrl(), $request->getPayload(), $request->getHeaders());
        } catch (\Exception $e) {
            //            echo $e;
            //            echo "Failed to Publish event";
        }
    }
}
