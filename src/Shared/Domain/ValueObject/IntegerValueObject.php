<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}