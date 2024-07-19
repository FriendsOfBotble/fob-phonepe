<?php

namespace FriendsOfBotble\PhonePe\PhonePe\common\utils;

class Response implements \JsonSerializable
{
    private $success;
    private $code;
    private $message;
    /**
     * @var mixed
     */
    private $data;

    /**
     * @param $success
     * @param $code
     * @param $message
     * @param mixed $data
     */
    public function __construct($success, $code, $message, $data)
    {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
