<?php

declare(strict_types=1);

namespace App\Category\Shared\Domain\ValueObject;

abstract class BooleanValueObject
{
    private bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function value(): bool
    {
        return $this->value;
    }
}