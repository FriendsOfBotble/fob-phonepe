<?php

namespace FriendsOfBotble\PhonePe\PhonePe\payments\v1;

class PaymentConstants
{
    public const REFUND_API = '/pg/v1/refund';
    public const STATUS_API = '/pg/v1/status/%s/%s';
    public const PAY_API = '/pg/v1/pay';
    public const VALIDATE_VPA_API = '/pg/v1/vpa/validate';
    public const PAYMENT_OPTIONS_API = '/pg/v1/options/%s';
    public const NETBANKING_INCLUDE_LIST = 'includeNetBankingBanksList';
}
