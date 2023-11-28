<?php

namespace common\exceptions;

use yii\web\HttpException;

/**
 * ContestForiddenException represents a "Forbidden" HTTP exception with status code 403.
 * Class ContestForbiddenException
 * @package common\exceptions
 */
class ContestForbiddenException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(403, $message, $code, $previous);
    }
}