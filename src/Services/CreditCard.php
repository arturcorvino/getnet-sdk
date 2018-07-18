<?php

namespace Getnet\SDK\Services;

use Getnet\SDK\Getnet\Auth;
use Getnet\SDK\Getnet\Environment;
use Getnet\SDK\Requests\GetNetResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class CreditCard
 *
 * @package Getnet\SDK\Services
 */
class CreditCard
{
    /** @var Environment $environment */
    private $environment;

    /** @var GetNetResponse $getnetResponse */
    private $getnetResponse;

    /** @var string $cardNumber */
    private $cardNumber;

    /** @var string $customerId */
    private $customerId;

    /** @var string $customerHolderName */
    private $customerHolderName;

    /** @var string $expirationMonth */
    private $expirationMonth;

    /** @var string $expirationYear */
    private $expirationYear;

    /** @var boolean $verifyCard */
    private $verifyCard;

    /** @var string $securityCode */
    private $securityCode;

    /** @var Auth $auth */
    private $auth;

    /** @var string $numberToken */
    private $numberToken;

    /** @var string $numberToken */
    private $cardId;

    /**
     * Auth constructor.
     *
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
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
     * @param $cardNumber
     *
     * @return $this
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param $customerId
     *
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @param $customerHolderName
     *
     * @return $this
     */
    public function setCustomerHolderName($customerHolderName)
    {
        $this->customerHolderName = $customerHolderName;

        return $this;
    }

    /**
     * @param $expirationMonth
     *
     * @return $this
     */
    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;

        return $this;
    }

    /**
     * @param $expirationYear
     *
     * @return $this
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;

        return $this;
    }

    /**
     * @param $verifyCard
     *
     * @return $this
     */
    public function setVerifyCard($verifyCard)
    {
        $this->verifyCard = $verifyCard;

        return $this;
    }

    /**
     * @param $securityCode
     *
     * @return $this
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
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
     * @return string
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     *
     * @return string
     */
    public function getNumberToken()
    {
        return $this->numberToken;
    }

    /**
     *
     * Tokenize Card
     *
     * @return $this
     */
    public function tokenizeCard()
    {
        $this->createNumberToken();

        if (!$this->getSuccess()) {
            return $this;
        }

        $this->createCard();

        return $this;
    }

    /**
     *
     * Create token number
     *
     * @return $this
     */
    private function createNumberToken()
    {
        $url = $this->environment->getApiUrl() . "v1/tokens/card";

        $client = new Client();

        try {
            $guzzleReturn = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => $this->auth->getTokenType() . " " . $this->auth->getAccessToken(),
                ],
                'form_params' => [
                    "card_number" => $this->cardNumber,
                    "customer_id" => $this->customerId,
                ]
            ]);

            $return = json_decode($guzzleReturn->getBody(), true);

            $this->getnetResponse = new GetNetResponse(true, $guzzleReturn->getStatusCode(), '');
            $this->numberToken = $return['number_token'];

        } catch (RequestException $e) {
            $this->getnetResponse = new GetNetResponse(false, $e->getCode(), $e->getMessage());
        }

        return $this;
    }

    /**
     *
     * Create card number
     *
     * @return $this
     */
    private function createCard()
    {
        $url = $this->environment->getApiUrl() . "v1/cards";

        $client = new Client();

        try {
            $guzzleReturn = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => $this->auth->getTokenType() . " " . $this->auth->getAccessToken(),
                ],
                'form_params' => [
                    "card_number" => "", $this->numberToken,
                    "cardholder_name" => $this->customerHolderName,
                    "expiration_month" => $this->expirationMonth,
                    "expiration_year" => $this->expirationYear,
                    "customer_id" => $this->customerId,
                    "verify_card" => $this->verifyCard,
                    "security_code" => $this->securityCode
                ]
            ]);

            $return = json_decode($guzzleReturn->getBody(), true);

            $this->getnetResponse = new GetNetResponse(true, $guzzleReturn->getStatusCode(), '');

            $this->numberToken = $return['number_token'];
            $this->cardId = $return['card_id'];

        } catch (RequestException $e) {
            $this->getnetResponse = new GetNetResponse(false, $e->getCode(), $this->message = $e->getMessage());
        }

        return $this;
    }

}
