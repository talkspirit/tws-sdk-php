<?php

namespace Tws\Common;

use Guzzle\Common\Collection;
use Guzzle\Http\EntityBody;
use Guzzle\Http\Url;
use Guzzle\Http\Message\RequestFactory;
use Guzzle\Parser\ParserRegistry;
use Tws\Common\TwsEntityEnclosingRequest;
use Tws\Common\TwsRequest;

/**
 * Default HTTP request factory used to create the default {@see Request} and {@see EntityEnclosingRequest} objects.
 */
class TwsRequestFactory extends RequestFactory 
{
    /**
     * extends requestClass to customize Guzzle\Http\Message\Request::setAuth()
     * Guzzle\Http\Message\RequestFactory::create() send two types of request Object (Request & EntityEnclosingRequest)
     */
    protected $requestClass = 'Tws\\Common\\TwsRequest';

    /**
     * extends requestClass to customize Guzzle\Http\Message\Request::setAuth()
     * Guzzle\Http\Message\RequestFactory::create() send two types of request Object (Request & EntityEnclosingRequest)
     */
    protected $entityEnclosingRequestClass = 'Tws\\Common\\TwsEntityEnclosingRequest';
}
