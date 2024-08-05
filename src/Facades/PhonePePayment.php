<?php

namespace FriendsOfBotble\PhonePe\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isSetup()
 * @method static string getId()
 * @method static string getDisplayName()
 * @method static array supportedCurrencies()
 * @method static array authorize(array $data, \Illuminate\Http\Request $request)
 *
 * @see \FriendsOfBotble\PhonePe\Contracts\PhonePePayment
 */
class PhonePePayment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FriendsOfBotble\PhonePe\Contracts\PhonePePayment::class;
    }
}
