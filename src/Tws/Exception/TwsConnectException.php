<?php

namespace Tws\Exception;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Exception when a client error is encountered
 */
class TwsConnectException extends BadResponseException {

}