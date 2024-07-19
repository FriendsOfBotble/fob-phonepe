<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common;

use FriendsOfBotble\PhonePe\PhonePe\common\config\MerchantConfig;

class TransactionClient
{
    /**
     * @var MerchantConfig
     */
    private $merchantConfig;
    private $hostUrl;

    /**
     * @param MerchantConfig $merchantConfig
     * @param $hostUrl
     */
    public function __construct(MerchantConfig $merchantConfig, $hostUrl)
    {
        $this->merchantConfig = $merchantConfig;
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

    public function getHeaders(): array
    {
        $headers = [];
        $headers[] = config\Headers::ACCEPT_HEADER . ': ' . config\Headers::APPLICATION_JSON;
        $headers[] = config\Headers::SOURCE . ': ' . config\Headers::INTEGRATION;
        $headers[] = config\Headers::SOURCE_VERSION . ': ' . config\Headers::API_VERSION;
        $headers[] = config\Headers::SOURCE_PLATFORM_VERSION . ': ' . config\Headers::SDK_VERSION;
        $headers[] = config\Headers::SOURCE_PLATFORM . ': ' . config\Headers::SDK_TYPE;
        $headers[] = config\Headers::ACCEPT_HEADER . ': ' . config\Headers::APPLICATION_JSON;
        $headers[] = config\Headers::CONTENT_TYPE . ': ' . config\Headers::APPLICATION_JSON;

        return $headers;
    }

}
