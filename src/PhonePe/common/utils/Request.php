<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\utils;

use FriendsOfBotble\PhonePe\PhonePe\common\config\Headers;

class Request
{
    public $headers;
    public $url;
    public $payload;

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param $name64EncodedPayload
     * @param $path
     * @param $baseUrl
     * @param $mid
     * @param $saltKey
     * @param $index
     * @return Request
     */
    public static function buildPostRequest($base64EncodedPayload, $path, $baseUrl, $mid, $saltKey, $index, $additionalHeaders): Request
    {
        $request = new Request();
        $request->url = ($baseUrl . $path);

        $request->payload = json_encode(['request' => $base64EncodedPayload]);
        $headers = [];
        $headers[] = Headers::MERCHANT_ID . ': ' . $mid;
        $headers[] = Headers::CHECKSUM . ': ' . Utils::generateChecksum($base64EncodedPayload, $saltKey, $index, $path);

        $request->headers = array_merge($headers, $additionalHeaders);

        return $request;
    }

    /**
     * @param $path
     * @param $baseUrl
     * @param $mid
     * @param $saltKey
     * @param $index
     * @return Request
     */
    public static function buildGetRequest($path, $baseUrl, $mid, $saltKey, $index, $additionalHeaders): Request
    {
        $request = new Request();
        $request->url = ($baseUrl . $path);
        $headers = [];
        $headers[] = Headers::MERCHANT_ID . ': ' . $mid;
        $headers[] = Headers::CHECKSUM . ': ' . Utils::generateChecksum('', $saltKey, $index, $path);

        $request->headers = array_merge($headers, $additionalHeaders);

        return $request;
    }
}
