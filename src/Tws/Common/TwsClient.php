<?php

namespace Tws\Common;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Tws\Plugin\Auth\AuthPlugin;
use Tws\Common\TwsConnect;
use Tws\Common\TwsRequestFactory;

/**
 * @see http://guzzlephp.org/tour/building_services.html
 * @see https://github.com/klaussilveira/phpcs-psr
 */
class TwsClient extends Client {
    /**
     * Factory method to create a new TwsClient
     *
     * @param TwsConnect $twsConnect Configuration data
     *
     * @return self
     */
    public static function factory($config = array()) {
        $default = array(
            'base_url' => $config['api_url']
        );
        $required = array('consumer_key', 'base_url');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);
        $client->setRequestFactory(new TwsRequestFactory());
        // Attach a service description to the client
        $description = ServiceDescription::factory(__DIR__ . '/../Resources/service.json');
        $client->setDescription($description);
        $client->addSubscriber(new AuthPlugin($config));
        return $client;
    }

}