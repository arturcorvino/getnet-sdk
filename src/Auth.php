<?php

namespace Getnet\SDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Auth
 *
 * @package Getnet\SDK
 */
class Auth
{
    private $authString;
    private $environment;

    /** @var boolean $success */
    private $success;

    /** @var string $code */
    private $code;

    /** @var string $message */
    private $message;

    /** @var string $accessToken */
    private $accessToken;

    /** @var string $tokenType */
    private $tokenType;

    /** @var string $expiresIn */
    private $expiresIn;

    /** @var string $scope */
    private $scope;

    /**
     * Auth constructor.
     *
     * @param $clientId
     * @param $clientSecret
     * @param Environment $environment
     */
    public function __construct($clientId, $clientSecret, Environment $environment)
    {
        $this->authString = base64_encode($clientId . ':' . $clientSecret);
        $this->environment = $environment;
    }

    /**
     * Gets result of auth in api
     *
     * @return boolean success
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Gets result of auth in api
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Gets result of auth in api
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Gets result of auth in api
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Gets result of auth in api
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Gets result of auth in api
     *
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * Gets result of auth in api
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Make auth in api GetNet.
     *
     */
    public function makeAuth()
    {
        $url = $this->environment->getApiUrl() . "auth/oauth/v2/token";

        $this->success = true;
        $this->code = 200;
        $this->message = 200;
        $this->accessToken = "ABC-123";
        $this->tokenType = "Bearer";
        $this->expiresIn = "3600";
        $this->scope = "3600";

        return $this;

        /*$client = new Client();

        try {
            $guzzleReturn = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Basic ' . $this->authString
                ],
                'form_params' => [
                    'scope' => 'oob',
                    'grant_type' => 'client_credentials',
                ]
            ]);
        } catch (RequestException $e) {
            $e->getCode();
            $e->getMessage();
            return false;
        }

        dd($url);

        return [];*/
    }


}
