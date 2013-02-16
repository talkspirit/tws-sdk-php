TWS SDK for PHP
===============
tws-sdk-php is a PHP client to easily interface with TWS services and build solutions on top of the API. The sdk is build on top of Guzzle

Getting started
---------------

- Docs: [connect.talkspirit.com](http://connect.talkspirit.com/)
- Console: [console.talkspirit.com](http://console.talkspirit.com/)

### Installing via Composer

The recommended way to install tws-sdk-php is through [Composer](http://getcomposer.org).

1. Add ``tws/tws-sdk-php`` as a dependency in your project's ``composer.json`` file:

        {
            "require": {
                "tws/tws-sdk-php": "dev-master"
            }
        }

2. Download and install Composer:

        curl -s http://getcomposer.org/installer | php

3. Install your dependencies:

        php composer.phar install

4. Require Composer's autoloader

    Composer also prepares an autoload file that's capable of autoloading all of the classes in any of the libraries that it downloads. To use it, just add the following line to your code's bootstrap process:

        require 'vendor/autoload.php';

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at [getcomposer.org](http://getcomposer.org).

Features
--------

- Supports all the API of TWS


HTTP basics
-----------

```php
<?php

require_once 'vendor/autoload.php';

use Tws\Common\TwsClient;

$config = array('api_url' => 'http://*************/api/v1/',
                'consumer_key' => '**********',
                'consumer_secret' => '*************',
                'token' => '**************');

$client = TwsClient::factory($config);

// get the token of the user
$response = $client->post('access_token')->setAuth('{{email}}', '{{paswword}}');
$arrayInfo = explode('=', $response->getBody());
$token = $arrayInfo[1];


// get the profile of the connected user
$me = $client->getSelf();
