<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\exceptions;

use Exception;
use Throwable;

/**
 * PhonePe Generic Exception
 */
class PhonePeException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
