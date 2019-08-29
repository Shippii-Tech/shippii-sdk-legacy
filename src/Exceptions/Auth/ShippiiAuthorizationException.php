<?php
namespace Shippii\Exceptions\Auth;

use Exception;

class ShippiiAuthorizationException extends Exception
{
    /**
     * ShippiiAuthenticationException constructor.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(string $message, $code = 1001, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}