<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use InvalidArgumentException;

final class AttributeDescription
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Attribute description is empty.");
        }
    }
}