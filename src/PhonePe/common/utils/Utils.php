<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\utils;

class Utils
{
    public static function convertRupeeToPaisa($amount_in_rupees)
    {
        return ($amount_in_rupees * 100);
    }

    /**
     * @param $base64_encoded_payload
     * @param $key
     * @param $endpoint
     */
    public static function generateChecksum($base64_encoded_payload, $key, $index, $endpoint): string
    {
        $string_to_be_hashed = $base64_encoded_payload . $endpoint . $key;
        $sha256_hash = hash('sha256', $string_to_be_hashed);

        return $sha256_hash . '###' . $index;
    }

    /**
     * @param $payload
     * @param $merchant_key
     * @param $key_index
     * @return string
     */
    public static function generateChecksumForCallback($payload, $merchant_key, $key_index): string
    {
        $hash_string = hash('sha256', $payload . $merchant_key);

        return $hash_string . '###' . $key_index;
    }
}
