<?php

namespace Shippii\Exceptions;

use Exception;

class ShippiiSdkException extends Exception
{
    /**
     * ShippiiEndpointNotFoundException constructor.
     * @param  string  $message
     * @param  int  $code
     * @param  Exception  $previous
     */
    public function __construct(string $message = 'Error', $code = 1000, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}