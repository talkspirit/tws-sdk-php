<?php

require_once 'vendor/autoload.php';

use Tws\Common\TwsClient;
use Tws\Common\TwsConnect;
use Tws\Exception\TwsConnectException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Service\Exception\ValidationException;

// $config = array('api_url' => 'http://t23.api.bm.onu/api/v1/',
//                 'consumer_key' => 'consomer_key',
//                 'consumer_secret' => 'consumer_secret');

$config = array('api_url' => 'http://t101.bstetreez.qa.talkspirit.net/api/v1/',
                'consumer_key' => 'pdemo',
                'consumer_secret' => 'm956s3pYfCyno');

$auth = new TwsConnect($config);
// get the token of the user
try{
    $auth->connect('no-reply@talkspirit.fr', 'do1Oochi');
    $auth->checkValidToken();

    // get tws client
    $client = TwsClient::factory($auth->getConfig());
    // method for activity stream
    $retVal = $client->getGraphSearch(array("limit" => "10", "sort" => "lastdate", "type" => "articles,ideas,questions,problemes,blog,calendar"));
    print_r($retVal);

} catch (TwsConnectException $e) {
    echo $e->getMessage().PHP_EOL;
} catch (ClientErrorResponseException $e) {
    echo "Error :".$e->getMessage().PHP_EOL;
} catch (ValidationException $e) {
    echo "Error Validation :".$e->getMessage().PHP_EOL;
}
