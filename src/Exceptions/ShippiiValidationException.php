<?php
namespace Shippii\Exceptions;

use Exception;
use Tightenco\Collect\Support\Collection;

class ShippiiValidationException extends Exception
{
    private $errors;

    /**
     * ShippiiAuthenticationException constructor.
     *
     * @param string $message
     * @param array $errors
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(string $message, array $errors, $code = 1003, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getValidationErrors()
    {
        return $this->errors;
    }


}