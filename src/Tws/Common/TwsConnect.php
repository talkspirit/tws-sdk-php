<?php

namespace Tws\Common;

use Tws\Common\TwsClient;
use Tws\Plugin\Auth\AuthPlugin;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Tws\Exception\TwsConnectException;

/**
 * @see http://guzzlephp.org/tour/building_services.html
 * @see https://github.com/klaussilveira/phpcs-psr
 */
class TwsConnect {

    private $config;

    /**
     * Factory method to create a new TwsClient
     *
     * @param array|Collection $config Configuration data
     *
     * @return self
     */
    public function __construct($config = array()) {
        $this->config = $config;
    }

    /**
     * Getter
     * @return array|Collection config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Method for connect user to tws via login/pwd
     *
     * @param $login
     * @param $pwd password
     *
     * @return String $token
     */
    public function connect($login, $pwd) {
        $client = TwsClient::factory($this->config);
        try{
            $response = $client->post('access_token')->setAuth($login, $pwd)->send();
            $arrayInfo = explode('=', $response->getBody());
            $token = $arrayInfo[1];
            $this->config['token'] = $token;

            return $token;
        } catch (ClientErrorResponseException $e) {
            throw new TwsConnectException("Authentication failed bad login/pwd.");
        }
    }

    /**
     * Method for check if connection is OK
     *
     * @return bool
     */
    public function checkValidToken() {
        $client = TwsClient::factory($this->config);
        try{
            $me = $client->getMe();
            if(isset($me['user'])) {
                return true;
            } else {
                return false;
            }
        } catch (ClientErrorResponseException $e) {
            throw new TwsConnectException($e->getMessage());
        }
    }

}