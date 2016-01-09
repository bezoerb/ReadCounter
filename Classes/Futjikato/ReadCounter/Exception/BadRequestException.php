<?php

namespace Futjikato\ReadCounter\Exception;

use TYPO3\Flow\Http\Exception;

/**
 * Generic "Bad Request" exception.
 */
class BadRequestException extends Exception
{
    /**
     * {@inheritdoc}
     */
    protected $statusCode = 400;
} 