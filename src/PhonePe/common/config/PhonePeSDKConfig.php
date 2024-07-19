<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\config;

class PhonePeSDKConfig
{
    /**
     * @var MerchantConfig
     */
    private $merchantConfig;
    private $hostUrl;
    private $env;

    /**
     * @param MerchantConfig $merchantConfig
     * @param $hostUrl
     * @param $env
     */
    public function __construct(MerchantConfig $merchantConfig, $hostUrl, $env)
    {
        $this->merchantConfig = $merchantConfig;
        $this->hostUrl = $hostUrl;
        $this->env = $env;
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

    /**
     * @return mixed
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param mixed $env
     */
    public function setEnv($env)
    {
        $this->env = $env;
    }




}
