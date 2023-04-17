<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Domain\ValueObject;

abstract class BooleanValueObject
{
    public function __construct(private readonly bool $value)
    {
    }

    public function value(): bool
    {
        return $this->value;
    }
}