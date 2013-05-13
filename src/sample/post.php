<?php

require_once 'vendor/autoload.php';

use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Service\Exception\ValidationException;
use Guzzle\Service\Resource\Model;
use Tws\Common\TwsClient;
use Tws\Common\TwsConnect;
use Tws\Exception\TwsConnectException;

$config = array('api_url' => 'http://t23.api.bm.onu/api/v1/',
                'consumer_key' => 'consomer_key',
                'consumer_secret' => 'consumer_secret');

$auth = new TwsConnect($config);
// get the token of the user
try{
    $auth->connect('no-reply@talkspirit.fr', 'password');
    $auth->checkValidToken();

    // get tws client
    $client = TwsClient::factory($auth->getConfig());

    // method for activity stream
    $retVal = $client->getPost(array('discussion-id' => "community-open",
                                            'post-id' => "article"));
    print_r($retVal->getResponse( ));
} catch (TwsConnectException $e) {
    echo $e->getMessage().PHP_EOL;
} catch (ClientErrorResponseException $e) {
    echo "Error :".$e->getMessage().PHP_EOL;
} catch (ValidationException $e) {
    echo "Error Validation :".$e->getMessage().PHP_EOL;
}
