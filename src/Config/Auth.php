<?php

namespace Getnet\Config;

use Getnet\Requests\GetNetResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Auth
 *
 * @package Getnet\Config
 */
class Auth
{
    /** @var string $authString */
    private $authString;

    /** @var Environment $environment */
    private $environment;

    /** @var GetNetResponse $getnetResponse */
    public $getnetResponse;

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
     * @return GetNetResponse
     */
    public function getResponse()
    {
        return $this->getnetResponse;
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

            $this->getnetResponse = new GetNetResponse(true, $guzzleReturn->getStatusCode(), '');

            $this->accessToken = $return['access_token'];
            $this->tokenType = $return['token_type'];
            $this->expiresIn = $return['expires_in'];
            $this->scope = $return['scope'];

        } catch (RequestException $e) {
            $this->getnetResponse = new GetNetResponse(false, $e->getCode(), $e->getMessage());
        }

        return $this;
    }


}
