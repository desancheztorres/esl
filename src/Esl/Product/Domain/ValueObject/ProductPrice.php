<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Domain\ValueObject;

use InvalidArgumentException;

final class ProductPrice
{
    public function __construct(private readonly int $value)
    {
        $this->validate($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    private function validate(int $value): void
    {
        $this->ensurePriceIsNotEmpty($value);
        $this->ensurePriceIsNotNegative($value);
    }

    private function ensurePriceIsNotEmpty(int $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Price cannot be empty.');
        }
    }

    private function ensurePriceIsNotNegative(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Price cannot be negative.');
        }
    }
}