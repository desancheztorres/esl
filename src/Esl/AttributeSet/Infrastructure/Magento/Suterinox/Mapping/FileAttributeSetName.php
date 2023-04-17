<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\AttributeSet\Domain\Exception\AttributeSetIsEmpty;
use Arcmedia\Shared\Domain\StringFormatter;

final class FileAttributeSetName
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
        return preg_replace('/[^A-Za-z]/u', '', $noUmlauts);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new AttributeSetIsEmpty("Attribute set name empty.");
        }
    }
}