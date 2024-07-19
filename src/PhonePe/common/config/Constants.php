<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\config;

/**
 * Constants
 */
class Constants
{
    const STAGE = "STAGE";
    const UAT = "UAT";
    const PRODUCTION = "PRODUCTION";

    const BASE_URL_PROD = "https://api.phonepe.com/apis/hermes";
    const BASE_URL_STAGE = "https://api-testing.phonepe.com/apis/hermes";
    const BASE_URL_UAT = "https://api-preprod.phonepe.com/apis/hermes";
    const EVENT_ENDPOINT = "/plugin/ingest-event";

    const ERROR = "PAYMENT_ERROR";
    const IOS = "IOS";
    const ANDROID = "ANDROID";
}
