<?php

namespace Tws\Common;

use Guzzle\Http\EntityBody;
use Guzzle\Http\EntityBodyInterface;
use Guzzle\Http\QueryString;
use Guzzle\Http\RedirectPlugin;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Message\EntityEnclosingRequest;

/**
 * HTTP request that sends an entity-body in the request message (POST, PUT, PATCH, DELETE)
 */
class TwsEntityEnclosingRequest extends EntityEnclosingRequest
{
    /**
     * {@inheritdoc}
     */
    public function setAuth($user, $password = '', $scheme = CURLAUTH_BASIC)
    {
        // Guzzle\Http\Message\Request::setAuth : If we got false or null, disable authentication if (!$user || !$password) { .... } 
        //We always have authentification, => unexpected case

        if(is_array($user) && isset($user['sso']) && isset($user['sso']['key']) && isset($user['sso']['name'])) {
            // SSO auth for externs customers
            $this->username = $user['sso']['key'];
            $this->password = isset($user['sso']['password']) ? $user['sso']['password'] : '';
            $this->setHeader('SSO', $user['sso']['name']);
        } else {
            //classic auth
            $this->username = $user;
            $this->password = $password;
        }
      
        // Bypass CURL when using basic auth to promote connection reuse
        if ($scheme == CURLAUTH_BASIC) {
            $this->getCurlOptions()->remove(CURLOPT_HTTPAUTH);
            $this->setHeader('Authorization', 'Basic ' . base64_encode($this->username . ':' . $this->password));
        } else {
            $this->getCurlOptions()->set(CURLOPT_HTTPAUTH, $scheme)
                 ->set(CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }

        return $this;
    }
}
