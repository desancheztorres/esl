<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\ValueObject;

use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeBackendTypeNotFound;
use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeNotFound;

final class AttributeBackendType
{
    private const INTEGER = 'int';
    private const BOOLEAN = 'bool';
    private const VARCHAR = 'varchar';
    private const TEXT = 'text';
    private const DATE = 'date';
    private const DECIMAL = 'decimal';
    private const SELECT = 'select';
    private const MULTISELECT = 'multiselect';

    private const ALLOWED_VALUES = [
        self::INTEGER => 'decimal',
        self::BOOLEAN => 'int',
        self::VARCHAR => 'varchar',
        self::TEXT => 'text',
        self::DATE => 'datetime',
        self::DECIMAL => 'decimal',
        self::SELECT => 'int',
        self::MULTISELECT => 'varchar'
    ];

    private string $value;

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
        $this->ensureValueIsValid($value);
    }

    public function ensureValueIsValid(string $value): void
    {
        if (!array_key_exists($value, self::ALLOWED_VALUES)) {
            throw new ProductAttributeNotFound("Attribute backend type with value `$value` not found.");
        }
    }
}