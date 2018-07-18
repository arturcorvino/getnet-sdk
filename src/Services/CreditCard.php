<?php

namespace Getnet\SDK\Services;

use Getnet\SDK\Auth;
use Getnet\SDK\Environment;

/**
 * Class CreditCard
 *
 * @package Getnet\SDK\Services
 */
class CreditCard
{
    /** @var Environment $environment */
    private $environment;

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

    /** @var boolean $success */
    private $success;

    /** @var string $code */
    private $code;

    /** @var string $message */
    private $message;

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

    /**
     *
     * @return $this
     */
    public function tokenizeCard()
    {
        // Criar o token passando só o número do cartão e o id do cliente
        $url = $this->environment->getApiUrl() . "v1/tokens/card";
        $data = [
            'header' => [
                'Authorization' => $this->auth->getTokenType() . " " . $this->auth->getAccessToken(),
            ],
            'body' => [
                "card_number" => $this->cardNumber,
                "customer_id" => $this->customerId,
            ],
        ];

        // Salvar o cartão passando o token e o restante dos dados
        $url = $this->environment->getApiUrl() . "v1/cards";
        $data = [
            'header' => [
                'Authorization' => $this->auth->getTokenType() . " " . $this->auth->getAccessToken(),
            ],
            'body' => [
                "card_number" => "", // retorno do primeiro endpoint
                "cardholder_name" => $this->customerHolderName,
                "expiration_month" => $this->expirationMonth,
                "expiration_year" => $this->expirationYear,
                "customer_id" => $this->customerId,
                "verify_card" => $this->verifyCard,
                "security_code" => $this->securityCode
            ],
        ];

        $this->success = true;
        $this->code = 200;
        $this->message = "ASD";

        return $this;
    }

}
