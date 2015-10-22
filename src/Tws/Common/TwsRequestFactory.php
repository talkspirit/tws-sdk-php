<?php

namespace Tws\Common;

use Guzzle\Common\Collection;
use Guzzle\Http\EntityBody;
use Guzzle\Http\Url;
use Guzzle\Http\Message\RequestFactory;
use Guzzle\Parser\ParserRegistry;
use Tws\Common\TwsEntityEnclosingRequest;

/**
 * Default HTTP request factory used to create the default {@see Request} and {@see EntityEnclosingRequest} objects.
 */
class TwsRequestFactory extends RequestFactory 
{
    /**
     * extends requestClass to customize Guzzle\Http\Message\Request::setAuth()
     * Guzzle\Http\Message\RequestFactory::create() send two types of request Object : Request & EntityEnclosingRequest
     * Request object is defined for GET, authenfication is only in POST => no need to extend Request
     */
    protected $entityEnclosingRequestClass = 'Tws\\Common\\TwsEntityEnclosingRequest';
}