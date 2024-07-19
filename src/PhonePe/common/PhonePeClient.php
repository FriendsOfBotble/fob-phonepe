<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common;

use FriendsOfBotble\PhonePe\PhonePe\common\config\ConfigBuilder;
use FriendsOfBotble\PhonePe\PhonePe\common\config\MerchantConfig;
use FriendsOfBotble\PhonePe\PhonePe\common\config\PhonePeSDKConfig;
use FriendsOfBotble\PhonePe\PhonePe\common\utils\Utils;

class PhonePeClient
{
    /**
     * @var PhonePeSDKConfig
     */
    private $phonePeSdkConfig;
    private $hostUrl;

    /**
     * @param $merchantId
     * @param $saltKey
     * @param $saltIndex
     * @param $env
     */
    public function __construct($merchantId, $saltKey, $saltIndex, $env)
    {
        $this->hostUrl = ConfigBuilder::getBaseUrl($env);
        $merchantConfig = new MerchantConfig($merchantId, $saltKey, $saltIndex);
        $this->phonePeSdkConfig = new PhonePeSDKConfig($merchantConfig, $this->hostUrl, $env);
    }

    /**
     * @return PhonePeSDKConfig
     */
    protected function getPhonePeSdkConfig(): PhonePeSDKConfig
    {
        return $this->phonePeSdkConfig;
    }

    /**
     * @param PhonePeSDKConfig $phonePeSdkConfig
     */
    protected function setPhonePeSdkConfig(PhonePeSDKConfig $phonePeSdkConfig)
    {
        $this->phonePeSdkConfig = $phonePeSdkConfig;
    }

    /**
     * @return mixed
     */
    protected function getHostUrl()
    {
        return $this->hostUrl;
    }

    /**
     * @param mixed $hostUrl
     */
    protected function setHostUrl($hostUrl)
    {
        $this->hostUrl = $hostUrl;
    }

    public function encryptedData($publicKey, $data): string
    {
        $PEM_HEADER = '-----BEGIN PUBLIC KEY-----';
        $PEM_FOOTER = '-----END PUBLIC KEY-----';
        $is_pem_file_read = strpos($publicKey, $PEM_HEADER) === 0 && strpos($publicKey, $PEM_FOOTER) !== false;

        // covert to Public key format if $public is not already in the format
        $formattedPublicKey = ($is_pem_file_read) ? $publicKey : sprintf("%s\n%s\n%s", $PEM_HEADER, $publicKey, $PEM_FOOTER);

        $key = openssl_get_publickey($formattedPublicKey);
        openssl_public_encrypt($data, $encrypted, $key);

        return base64_encode($encrypted);
    }

    public function verifyCallback($response, $observerCheckSum): bool
    {
        $generatedCheckSum = Utils::generateChecksumForCallback(
            $response,
            $this->getPhonePeSdkConfig()->getMerchantConfig()->getSaltKey(),
            $this->getPhonePeSdkConfig()->getMerchantConfig()->getSaltIndex()
        );

        return ($observerCheckSum === $generatedCheckSum);
    }

}
