<?php

namespace Getnet\SDK;

use Getnet\SDK\Interfaces\Environment as EnvironmentInterface;

/**
 * Class Environment
 *
 * @package Getnet\SDK
 */
class Environment implements EnvironmentInterface
{
    private $api;

    /**
     * Environment constructor.
     *
     * @param $api
     */
    private function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return Environment
     */
    public static function sandbox()
    {
        $api = 'https://api-homologacao.getnet.com.br/';

        return new Environment($api);
    }

    /**
     * @return Environment
     */
    public static function production()
    {
        $api = 'https://api.getnet.com.br/';

        return new Environment($api);
    }

    /**
     * Gets the environment's Api URL
     *
     * @return string the Api URL
     */
    public function getApiUrl()
    {
        return $this->api;
    }

}
