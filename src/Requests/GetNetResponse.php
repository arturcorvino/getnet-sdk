<?php

namespace Getnet\Requests;

/**
 * Class GetNetError
 *
 * @package Getnet\SDK\Requests
 */
class GetNetResponse
{

    /** @var string $code */
    private $code;

    /** @var string $message */
    private $message;

    /** @var boolean $success */
    private $success;

    /**
     * GetNetError constructor.
     *
     * @param $success
     * @param $code
     * @param $message
     */
    public function __construct($success, $code, $message)
    {
        $this->setSuccess($success);
        $this->setCode($code);
        $this->setMessage($message);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param $success
     *
     * @return $this
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }
}
