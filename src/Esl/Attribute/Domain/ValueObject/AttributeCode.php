<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\ValueObject;

use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeNotFound;
use Arcmedia\Shared\Domain\StringFormatter;

final class AttributeCode
{
    private string $value;

    public function __construct(string $value)
    {
        $attribute = $this->clean($value);
        $this->validate($attribute);
        $this->value = $attribute;
    }

    public function value(): string
    {
        return lcfirst($this->value);
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
    }

    private function clean(string $value): string
    {
        $noUmlauts = StringFormatter::convertUmlauts($value);
        return preg_replace('/[^A-Za-z0-9]/u', '', $noUmlauts);
    }

    public function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new ProductAttributeNotFound("Attribute code not found.");
        }
    }
}