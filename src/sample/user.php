<?php

require_once 'vendor/autoload.php';

use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Service\Exception\ValidationException;
use Guzzle\Service\Resource\Model;
use Tws\Common\TwsClient;
use Tws\Common\TwsConnect;
use Tws\Exception\TwsConnectException;

$config = array('api_url' => 'http://t2.api.dev/api/v1/',
                'consumer_key' => 'consumer_key',
                'consumer_secret' => 'consumer_secret',);

$auth = new TwsConnect($config);
// get the token of the user
try {
    $auth->connect('no-reply@talkspirit.fr', 'password');
    $auth->checkValidToken();

    // get tws client
    $client = TwsClient::factory($auth->getConfig());


    $retVal = $client->getCommand('getUsers', array('username' => "olivier"));

    echo get_class($retVal);
    //var_dump($retVal);
} catch (TwsConnectException $e) {
    echo $e->getMessage().PHP_EOL;
} catch (ClientErrorResponseException $e) {
    echo "Error :".$e->getMessage().PHP_EOL;
} catch (ValidationException $e) {
    echo "Error Validation :".$e->getMessage().PHP_EOL;
}
