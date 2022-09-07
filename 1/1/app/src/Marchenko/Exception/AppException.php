<?php


namespace Marchenko\Exception;

use Throwable;
use Exception;
use Marchenko\Logger\AppLogger;

class AppException extends Exception
{

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        AppLogger::addError($message);
    }

}