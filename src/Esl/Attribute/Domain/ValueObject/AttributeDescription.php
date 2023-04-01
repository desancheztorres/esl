<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\ValueObject;

use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeNotFound;

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

    public function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new ProductAttributeNotFound('Attribute description not found.');
        }
    }
}