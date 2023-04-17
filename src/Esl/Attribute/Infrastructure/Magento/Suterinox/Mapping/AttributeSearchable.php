<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;
use InvalidArgumentException;

final class AttributeSearchable
{
    private string $value;
    private array $types = [
        'Nein' => false,
        'Ja' => true
    ];

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): bool
    {
        return $this->types[$this->value];
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
        $this->ensureValueIsValid($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new AttributeIsEmpty("Attribute searchable is empty.");
        }
    }

    private function ensureValueIsValid(string $value): void
    {
        if (!array_key_exists($value, $this->types)) {
            throw new InvalidArgumentException("Attribute searchable with value `$value` is not valid.");
        }
    }
}
