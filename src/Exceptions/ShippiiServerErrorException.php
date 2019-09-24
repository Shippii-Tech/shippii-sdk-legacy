<?php
namespace Shippii\Exceptions;

use Exception;

class ShippiiServerErrorException extends Exception
{
    /**
     * @var string|null
     */
    private $eventId;

    /**
     * ShippiiAuthenticationException constructor.
     * @param string $message
     * @param string|null $eventId
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(string $message, string $eventId = null, $code = 1002, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->eventId = $eventId;
    }

    public function getEventId()
    {
        return $this->eventId;
    }
}