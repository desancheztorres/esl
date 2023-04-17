<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\Exception;

use RuntimeException;
use Throwable;

final class AttributeNotValid extends RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [$this->code]: $this->message\n";
    }
}