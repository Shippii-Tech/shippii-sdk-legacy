<?php
namespace Shippii\Exceptions\Auth;

use Exception;

class ShippiiAuthenticationException extends Exception
{
    /**
     * ShippiiAuthenticationException constructor.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(string $message, $code = 1000, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}