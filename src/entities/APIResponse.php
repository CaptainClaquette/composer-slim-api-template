<?php

namespace urca\template\api\entities;

use JsonSerializable;

class APIResponse implements JsonSerializable
{
    const RESPONSE_SUCCESS = "success";
    const RESPONSE_WARNING = "warn";
    const RESPONSE_ERROR = "error";

    private $code;
    private $status;
    private $message;
    private $data;

    public function __construct(int $code, string $status, $message = "", $data = null)
    {
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    public function jsonSerialize()
    {
        if ($this->data != null) {
            return get_object_vars($this);
        }
        return ['code' => $this->code, 'status' => $this->status, 'message' => $this->message];
    }

    /**
     * Get the value of code
     */
    public function getCode() : int
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code) : APIResponse
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status): APIResponse
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message): APIResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data): APIResponse
    {
        $this->data = $data;
        return $this;
    }
}
