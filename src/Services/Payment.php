<?php

namespace Getnet\Services;

use Getnet\Getnet\Auth;
use Getnet\Getnet\Environment;

/**
 * Class Payment
 *
 * @package Getnet\SDK\Services
 */
class Payment
{
    /** @var Environment $environment */
    private $environment;

    /** @var Auth $auth */
    private $auth;

    /** @var boolean $success */
    private $success;

    /** @var string $code */
    private $code;

    /** @var string $message */
    private $message;

    /**
     * constructor.
     *
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param Auth $auth
     *
     * @return $this
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

}
