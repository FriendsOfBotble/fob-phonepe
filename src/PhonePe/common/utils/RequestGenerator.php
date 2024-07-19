<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\utils;

use FriendsOfBotble\PhonePe\PhonePe\common\exceptions\PhonePeException;

/**
 * Class RequestGenerator
 * @package PhonePe\RequestGenerator
 */
class RequestGenerator
{
    /**
     * @desc Helper function to send a post request
     * @param $url
     * @param $body
     * @param $headers
     * @return mixed
     * @throws PhonePeException
     */
    public static function postRequest($url, $body, $headers)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $httpResponse = new HttpResponse();

        $response = curl_exec($ch);
        $httpResponse->setResponse($response);

        $responseHeaders = curl_getinfo($ch);
        $httpResponse->setHeaders($responseHeaders);

        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpStatus == 200) {
            return $httpResponse;
        } else {
            throw new PhonePeException("{$httpStatus}: {$response}", $httpStatus);
        }
    }

    /**
     * @desc Helper function to send a get request
     * @param $url
     * @param $headers
     * @return mixed
     * @throws PhonePeException
     */
    public static function getRequest($url, $headers)
    {
        // Creating Array of headers
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $httpResponse = new HttpResponse();

        $response = curl_exec($ch);
        $httpResponse->setResponse($response);

        $responseHeaders = curl_getinfo($ch);
        $httpResponse->setHeaders($responseHeaders);

        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpStatus == 200) {

            return $httpResponse;
        } else {
            throw new PhonePeException("{$httpStatus}: {$response}", $httpStatus);
        }
    }

}
