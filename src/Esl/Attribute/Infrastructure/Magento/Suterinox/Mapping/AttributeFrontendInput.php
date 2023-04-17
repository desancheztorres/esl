<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;
use Arcmedia\Esl\Attribute\Domain\Exception\AttributeNotValid;

final class AttributeFrontendInput
{
    private string $value;

    private const INTEGER = 'int';
    private const BOOLEAN = 'bool';
    private const VARCHAR = 'varchar';
    private const TEXT = 'text';
    private const DATE = 'date';
    private const DECIMAL = 'decimal';
    private const SELECT = 'select';
    private const MULTISELECT = 'multiselect';

    private const ALLOWED_VALUES = [
        self::INTEGER => 'price',
        self::BOOLEAN => 'boolean',
        self::VARCHAR => 'text',
        self::TEXT => 'text',
        self::DATE => 'date',
        self::DECIMAL => 'price',
        self::SELECT => 'select',
        self::MULTISELECT => 'multiselect'
    ];

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return self::ALLOWED_VALUES[$this->value];
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
        $this->ensureValueIsValid($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new AttributeIsEmpty('Attribute frontend input is empty.');
        }
    }

    private function ensureValueIsValid(string $value): void
    {
        if (!array_key_exists($value, self::ALLOWED_VALUES)) {
            throw new AttributeNotValid("Attribute frontend input with value `$value` is not valid.");
        }
    }
}
