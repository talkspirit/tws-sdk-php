<?php

namespace Tws\Plugin\Auth;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;

/**
 *
 */
class AuthPlugin implements EventSubscriberInterface {
    private $config;

    function __construct($_config) {
        $this->config = $_config;
    }

    public static function getSubscribedEvents() {
        return array('request.before_send' => 'onRequestBeforeSend');
    }

    public function onRequestBeforeSend(Event $event) {
        $event['request']->setHeader('Consumer-Key', $this->config['consumer_key']);
        if(!is_array($event['request']->getheader('Accept'))) {
            $event['request']->setheader('Accept', 'application/json');
        }
        $header = $event['request']->getheader('Authorization');
        if(isset($this->config['token']) && empty($header)) {
            $this->addAuthorizationHeader($event);
        }
    }

    private function addAuthorizationHeader(Event $event) {
        $auth_attributes = array();
        $auth_attributes['token'] = $this->config['token'];
        $auth_attributes['class'] = 'oauth';
        $auth_attributes['method'] = 'hmac-sha-1';
        $auth_attributes['timestamp'] = time();
        $auth_attributes['nonce'] = md5(uniqid(rand(), true));
        $str = '';
        $str2 = '';
        foreach($auth_attributes as $k => $v) {
            $str .= "$k=\"$v\",";
        }
        ksort($auth_attributes);
        foreach($auth_attributes as $k => $v) {
            $str2 .= "$k=$v,";
        }
        $path = $event['request']->getPath();
        $query = $event['request']->getQuery();
        $method = $event['request']->getMethod();
        $host = $event['request']->getHost();
        $digest = "$method," . $host . ':80,' . $str2 . $this->config['consumer_secret'] . ',' . $path. $query;
        $auth = sha1($digest);
        $event['request']->setHeader("Authorization", "Token $str auth=\"$auth\"");
    }
}
