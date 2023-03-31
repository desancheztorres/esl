<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Domain\ValueObject;

abstract class StringValueObject
{

    public function __construct(private readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}