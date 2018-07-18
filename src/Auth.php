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

        $client = new Client();

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

            $return = json_decode($guzzleReturn->getBody(), true);

            $this->success = true;
            $this->code = $guzzleReturn->getStatusCode();
            $this->message = "";
            $this->accessToken = $return['access_token'];
            $this->tokenType = $return['token_type'];
            $this->expiresIn = $return['expires_in'];
            $this->scope = $return['scope'];

        } catch (RequestException $e) {
            $this->success = false;
            $this->code = $e->getCode();
            $this->message = $e->getMessage();
        }

        return $this;
    }


}
